<?php
/**
 * view.php along with index-2.php and index.php provides a sample web application
 *
 * The associated index-2.php will show list of subcategories for category selected
 * index.php shows main categories
 * 
 * @package p3
 * @author Melissa Wong <mellymai@gmail.com>
 * @version 0.1 2017/07/17
 * @link http://mel.codes/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see view.php
 * @see index-2.php 
 * @todo none
 */

require '../inc_0700/config_inc.php'; 
spl_autoload_register('MyAutoLoader::NamespaceLoader');

if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails

} else {
	myRedirect(VIRTUAL_PATH . "p3/index.php");
}

//Creates SubCategory object
$mySubCategory = new MyClasses\SubCategory($myID);

//Creates Custom Title Tag
if($mySubCategory->isValid) { 
	$config->titleTag = $mySubCategory->Title . " News Feed!"; //use subcategory name in Title
} else {
	$config->titleTag = smartTitle(); //use constant 
}

get_header();

//if subcategory exists, show its news feed
if($mySubCategory->isValid) {
	$mySubCategory->showFeed();
} else { #else inform user does not exist
	echo "Sorry, no such Feed!";	
}

get_footer();