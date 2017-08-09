<?php
/**
 * index.php along with survey_view.php provides a sample web application
 *
 * The difference between demo_list.php and index.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, survey_view.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package SurveySez
 * @author James Carroll <jdcarroll08@gmail.com>
 * @version 0.1 2017/07/17
 * @link http://www.james31.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

//Provides namespace
spl_autoload_register('MyAutoLoader::NamespaceLoader');

# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
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

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php


#records exist - show survey!
	echo '
	<h3 align="center">' . smartTitle() . '</h3>
	';
	if($myCategory->isValid) {
	$myCategory->showSubCategories();
	} else { // else inform user no subcategories exist for this category
	echo "<div align=center>There are currently no SubCategories for" . $this->Title . "</div>";	
	} 
	
	VIRTUAL_PATH . 'p3/index.php">Back</a></div>';

get_footer(); #defaults to theme footer or footer_inc.php
