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
 * @see survey_view.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
//$sql = "select * from sm17_surveys";
$sql = 
"
select c.CategoryName, c.Description, c.CategoryID from " . PREFIX . "NewsCategory c";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'News for you!';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 Class! ' . $config->metaDescription;

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=smartTitle();?></h3>

<p></p> 
<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "survey";}else{$itemz = "surveys";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
		echo '
					<table class="table table-striped table-hover ">
  					<thead>
    					<tr>
								<th>News Category</th>
								<th>Description</th>
    					</tr>
						</thead>
  					<tbody>
						';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
		echo '
				<tr>
					<td><a href="' . VIRTUAL_PATH . 'p3/survey_view.php?id=' . (int)$row['CategoryID'] . '">' . dbOut($row['CategoryName']) . '</a></td>
					<td>' . dbOut($row['Description']) . '</td>
				</tr>
		';
		
    /*    
		echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['Title']) . '</a>';
		
         echo '</div>';
		*/
	}
	echo '
						</tbody>
					</table>	
	';
	
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>There are currently no surveys. </div>";	
}
//clear results
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
