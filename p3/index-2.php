<?php
/**
 * index-2.php along with index.php and view.php provide a sample web application 
 * The associated index.php displays a list of the main categories
 * The associated view page, view.php generates a news feed based on subcategory object 
 * 
 * @package p3
 * @author Melissa Wong <mellymai@gmail.com>
 * @version 0.1 2017/07/17
 * @link http://mel.codes/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @see view.php 
 * @todo none
 */

//Links to configuration file with database credentials
require '../inc_0700/config_inc.php';

//Provides namespace
spl_autoload_register('MyAutoLoader::NamespaceLoader');

//if ID is set, use value to display subcategories
if(isset($_GET['id']) && (int)$_GET['id'] > 0){
	$myID = (int)$_GET['id']; 
} else {
	myRedirect(VIRTUAL_PATH . "p3/index.php");
}
 
//Creates Category object
$myCategory = new MyClasses\Category($myID);

//Creates custom title tag
if($myCategory->isValid) {
	$config->titleTag = $myCategory->Title . " SubCategories!"; //use category title property
} else {
	$config->titleTag = smartTitle(); //use constant 
}

get_header();

//use title tag as header
echo '<h3 align="center">' . smartTitle() . '</h3>';

//if category exists, display subcategories
if($myCategory->isValid) {
	$myCategory->showSubCategories();
} else { // else inform user no subcategories exist for this category
	echo "<div align=center>There are currently no SubCategories for" . $this->Title . "</div>";	
}

get_footer();