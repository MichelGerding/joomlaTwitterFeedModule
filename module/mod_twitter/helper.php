<?
/**
 * Helper class for Twitter module
 *
 * @package    Joomla.Facebook
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.php
 * @author     Michel Gerding
 * mod_twitter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class modTwitterHelper{
	public static function getData($params, $filterData = true){
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select(array('*'));
        $query->from($db->quoteName('#__twitter'));

        if($filterData) {
            if ($params['ViewType'] == 'F') {
                $query->where($db->quoteName('type') . ' = ' . $db->quote('photo'));
            }
            if ($params['ViewType'] == 'T') {
                $query->where($db->quoteName('type') . ' = ' . $db->quote('text'));
            }

            if ($params['limit'] == 1)
                $query->setLimit($params['maxTweets']);
        }

        $query->order('created_at DESC');
        $db->setQuery($query);

        return $db->loadObjectList();
    }

    public static function nextDayExecute($params) {
        $filename = dirname(__FILE__) . '/date.txt';
        $date = date("d");
        if (file_exists($filename)) {
            $savedDate = file_get_contents($filename);
            if ($date != $savedDate) {
                if ($savedDate === "DELETE") {
                    self::deleteAll($params);
                    echo "<div class='alert alert-info'>All tweetshave been deleted and redownloaded</div>";
                }
                    file_put_contents($filename, $date, FILE_TEXT);
                    return true;
            }
        }else {
            touch($filename);
            return true;
        }
        return false;
    }
    public static function nameChange($params) {
        $filename = dirname(__FILE__) . '/name.txt';
        $date = $params['profile_name'];
        if (file_exists($filename)) {
            $savedDate = file_get_contents($filename);
            if ($date != $savedDate) {
                self::deleteAll($params);
                echo "<div class='alert alert-info'>All tweetshave been deleted and redownloaded</div>";
                file_put_contents($filename, $date, FILE_TEXT);
                return true;
            }
        }else {
            touch($filename);
            return true;
        }
        return false;
    }
    public static function deleteAll($params) {
        foreach (self::getData($params, false) as $item) {
        	if($item->type == 'photo') {
            	unlink($params['saveDir'] . $item->image);	
        	}
            $db = JFactory::getDbo();

            $query = $db->getQuery(true);

            $query->delete($db->quoteName('#__twitter'));
            $query->where($db->quoteName('id') . ' = ' . $item->id);

            $db->setQuery($query);

            $db->execute();
        }
        return true;
    }
    public static function deleteAllAjax() {
        $filename = dirname(__FILE__) . '/date.txt';
        file_put_contents($filename, "DELETE", FILE_TEXT);


        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
	
    public static function makeScreenName($str) {
        return preg_replace('/@/', '', $str);
    }

}