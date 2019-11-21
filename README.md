# Joomla Twitter Feed Module
### How to use this module
To use this module you need the followig things:
- a joomla site
- Twitter handle of the feed you want to display
- A twitter developer account. [How to get a twitter developer account](https://developer.twitter.com/ "how to get a twitter developer account")
- Authentivication tokens. [how to get the acces tokens](https://developer.twitter.com/en/docs/basics/authentication/guides/access-tokens "how to get the acces tokens")
    - api key
    - api secret
    - acces token
    - acces token secret


### How to install the module
 First you need to download the module or get the link to for the [download](#download "Download link") when you have the module or download link you need to log into the administrator page of your website 
 
 ![Log in to the administrator page](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/image_login.PNG?raw=true "Log in to the administrator page")
 
 after you are logged-in you need to go to the module management page
 
 ![Go to the module controll page](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/image_install_1.PNG?raw=true "Go to the module manager")
 
 if you want to install the module by using a download link got to the chapter **installing using the download link**.
 but if you downloaded the zip file you need to follow the steps under the chapter **installing using the zip file**.
 if you want to install using a folder skip to the chapter **installing using a folder**.
 
 #### Installing using a zip file
 
 ![Go to the upload package tab](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/image_install_3.PNG?raw=true "Go to the upload package tab")
 
 if you are on the correct page you need to drag the zip file into the space that says **Drag and drop file here to upload.**
 
  ![upload the file](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/image_install_2.PNG?raw=true "drag the folder into the upload field")
  
if you followed the steps correct you should see a green box above the upload field and have complete the instalation succesfully
#### Installing using the download link
if you want to install it using the download link you need to make sure you are on the page install from url

![Go to the install from link tab](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/image_install_4.PNG?raw=true "Got to the install from link tab")

when you are on the correct tab you need to paste the url into the text box

![Insert link into textbox](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/image_install_5.PNG?raw=true "Insert link into textbox")


when you have completed these steps succesfully you can go on to configuring the module
### How to configure the module
once you have completed the instalation you need to go to the modules page

![Got to the modules page](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/config_1.PNG?raw=true "Go to the modules page")

once on that page you need to search for a module with the name twitter. First enter the text twitter into the search box and then click on the search icon

![Search for the module twitter](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/config_2.PNG?raw=true "Search for the module twitter")

if you found the module you need to click on it and enter the module manager. once in the module manager you need to fill in these fields 

![Fill in the fields](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/config_3.PNG?raw=true "Fill in the fields")
1. the twitter handle
2. your api key
3. your api key secret
4. your access token
5. your access secret
after you have enterd those fields you need to select a position 

when you have enterd the information you need to hit the safe button 

![Save the config](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/images/config_4.PNG?raw=true "Save the config")

[Additional information over the settings in the config menu](https://github.com/MichelGerding/joomlaTwitterFeedModule/blob/master/docs/settings.md "info over de instellingen")

## How to delete the tweets
to delete the tweets you need to use a ftp tool to go onto the server and go to the folder of the module **/modules/mod_twitter** and edit the file **date.txt** to contain the word **DELETE** after that you need to reload the page you have the module postioned on to load new tweets or you need to change the name to **DELETE** and back to the twitter handle









