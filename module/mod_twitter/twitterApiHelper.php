<?php
require_once dirname(__FILE__) . "/twitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

class twitterApiHelper{

	private $api_key;
	private $api_secret;
	private $acces_token;
	private $acces_secret;

	private $dir;
	private $thumbHeight;
	private $thumbWidth;

	private $profile_name;

	public function __construct($params) {
		$this->api_key = $params['api_key'];
		$this->api_secret = $params['api_secret'];
		$this->access_token = $params['acces_token'];
		$this->access_secret = $params['acces_secret'];

		$this->dir = $this->CheckDir($params['saveDir']);
		$this->thumbHeight = $params['thumbHeight'];
		$this->thumbWidth = $params['thumbWidth'];

		$this->profile_name = ModTwitterHelper::makeScreenName($params['profile_name']);
		$this->twitter_data = $this->getData();
        // $this->twitter_data = array();
		$this->params = $params;
	}


	public function fetchUrl($path) {
		$connection = new TwitterOAuth($this->api_key, $this->api_secret, $this->access_token, $this->access_secret);
		$tweets = $connection->get($path, ["screen_name" => $this->profile_name, "exclude_replies" => true, "count" => 1000, 'tweet_mode' => 'extended']);
		$tweets = json_encode($tweets);

		return json_decode($tweets, true);
	}

	public function getData() {
        $php_array = array();
		$php_array = $this->fetchUrl("statuses/user_timeline");
		if (isset($object['errors'])) {
			return false;
		}

        $data = array();
		if(!array_key_exists('errors', $php_array)) {
			foreach ($php_array as $obj) {
				$object = array(	"id" => $obj['id_str'],
									"created_at"=> $obj['created_at'],
									"text" => $obj['full_text'],
									"favorite" => $obj['favorite_count'],
									"link" => "https://www.twitter.com/{$obj['user']['id_str']}/status/{$obj['id_str']}",
									"type" => 'text');

				if(array_key_exists('media', $obj['entities'])) {
					$object["image"] = $obj['entities']['media'][0]['media_url'];
					$object["type"] = $obj['entities']['media'][0]['type'];
				}

				array_push($data, $object);
			}	
		}else {
			print_r(json_encode($php_array));
		}

		return $data;
	}

	public function getDBUuid(){
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select('uuid');
        $query->from($db->quoteName('#__twitter'));
        $db->setQuery($query);

        $data = [];
        foreach ($db->loadObjectList() as $obj) {
            if (isset($obj->uuid))
                $data[] = $obj->uuid;
        }
        return $data;
    }

    public function setDataInDatabase() {
    	$dbData = $this->getDBUuid();

    	foreach ($this->twitter_data as $object) {
    		if(!in_array($object['id'], $dbData)) {
    			$data = new stdClass();
    			$data->uuid = $object['id'];
    			$data->text = $object['text'];
    			$data->type = $object['type'];
    			$data->link = $object['link'];
    			$data->favorite = $object['favorite'];
    			$data->created_at = date("Y-m-d H:i:s", strtotime($object['created_at']));
    			if (array_key_exists('image', $object)) {
    				$data->image = $this->makePictureName($object['image']);
    			} else { $data->image = null; }
    			
                if(JFactory::getDbo()->insertObject('#__twitter', $data)){
    				if($data->image !== null) {
    					$this->download($object, $data->image);
    				}
    			}
    		} else {
    			$data = new stdClass();
				$data->uuid = $object['id'];
				$data->favorite = $object['favorite'];
				JFactory::getDbo()->updateObject('#__twitter', $data, 'uuid');
    		}   		
    	}
    }
 

    private function makePictureName($pic) {
    	$uniq = uniqid();
        $ext = ".jpg";
        if (strpos($pic, 'png') !== false) {
            $ext = '.png';
        }
        return $uniq . $ext;
    }

    private function download($obj, $filename) {
		if (isset($obj['image'])) {
            $imageData = file_get_contents(urldecode($obj['image']));

            $image = imagecreatefromstring($imageData);

            $thumb_width = $this->thumbWidth;
            $thumb_height = $this->thumbHeight;
            $width = imagesx($image);
            $height = imagesy($image);
            $original_aspect = $width / $height;
            $thumb_aspect = $thumb_width / $thumb_height;

            if ( $original_aspect >= $thumb_aspect )
            {
                // If image is wider than thumbnail (in aspect ratio sense)
                $new_height = $thumb_height;
                $new_width = $width / ($height / $thumb_height);
            }
            else
            {
                // If the thumbnail is wider than the image
                $new_width = $thumb_width;
                $new_height = $height / ($width / $thumb_width);
            }
            $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
            // Resize and crop
            imagecopyresampled($thumb,
                $image,
                0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                0, 0,
                $new_width, $new_height,
                $width, $height);
            imagejpeg($thumb, $this->dir . $filename, 100);

            imagedestroy($thumb);
        }
        return false;
    }
    private function CheckDir($dir){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        return $dir;
    }

}