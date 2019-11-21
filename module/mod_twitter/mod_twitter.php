<?php
/**
 * twitter! Module Entry Point
 *
 * @package    Joomla.twitter
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.php
 * @author     Michel Gerding
 * mod_twitter is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access
defined('_JEXEC') or die;

JHtml::script(Juri::base() . 'modules/mod_twitter/js/owl.carousel.min.js');
JHtml::stylesheet(Juri::base() . 'modules/mod_twitter/css/owl.carousel.min.css');
JHtml::stylesheet(Juri::base() . 'modules/mod_twitter/css/mod_twitter.css');

$css = "
  .tks-twitter-item .tks-twitter-body:after {
    border: ".$params->get('borderRadius')."px solid ".$params->get('borderColor')."
  }.tks-twitter-item .tks-twitter-body:hover .tks-twitter-image {filter: blur(".$params->get('blurRadius')."px);-webkit-filter: blur(".$params->get('blurRadius')."px);}";
JFactory::getDocument()->addStyleDeclaration($css);
JFactory::getDocument()->addStyleDeclaration($params->get('extaCSS'));

require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__) . '/twitterApiHelper.php';


if (ModTwitterHelper::nextDayExecute($params) || ModTwitterHelper::nameChange($params)) {
        $helper = new twitterApiHelper($params);
        $helper->setDataInDatabase();
}

 $items = modTwitterHelper::getData($params);

require JModuleHelper::getLayoutPath('mod_twitter');
