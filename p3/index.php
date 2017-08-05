<?php
/**
 * index.php along with index-2.php and view.php provides a sample web application
 *
 * The associated index-2.php will show list of subcategories for category selected
 * view.php shows news feed associated with subcategory object
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

//Links to configuration file with database credentials
require '../inc_0700/config_inc.php'; 
 
//SQL statement to query db
$sql = "SELECT CategoryID, Category, Description FROM sm17_MainCategories ORDER BY Category";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'News for you!';

get_header();

//display title tag as header
echo '<h3 align="center">' . smartTitle() . '</h3>';

#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

//if records exist...
if(mysqli_num_rows($result) > 0) {
	if($myPager->showTotal()==1) { //use singular for one record
		$itemz = "Topic";
	} else { //use plural for multiple records
		$itemz = "Topics";
	}

	//print number of records
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';

    //create table headings
    echo '
    	<table class="table table-striped table-hover ">
			<thead>
			    <tr>
			      	<th>Category</th>
			      	<th>Description</th>
			    </tr>
			</thead>
			<tbody>
	';

	//while records exist, print data for each
	while($row = mysqli_fetch_assoc($result)) {
         echo '
			<tr>
		      <td><a href="' . VIRTUAL_PATH . 'p3/index-2.php?id=' . (int)$row['CategoryID'] . '">' . dbOut($row['Category']) . '</a></td>
		      <td>' . dbOut($row['Description']) . '</td>
		    </tr>
         ';
	} #end while

	//end table
	echo '
		</tbody>
		</table>
    ';

	echo $myPager->showNAV(); # show paging nav, only if enough records	 

} else { #inform user if no records
    echo "<div align=center>There are currently no news categories</div>";	
}

//clear results
@mysqli_free_result($result);

get_footer();
