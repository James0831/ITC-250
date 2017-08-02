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
 
# check variable of item passed in - if invalid data, forcibly redirect back to index.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "p3/index.php");
}

$mySurvey = new Survey($myID);
//dumpDie($mySurvey);  //found in inc_0700/common_inc.php 

if($mySurvey->IsValid)
{#only load data if record found
	$config->titleTag = $mySurvey->CategoryName . " surveys made with php and love!"; #overwrite PageTitle with info!
	#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
}

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php


if($mySurvey->IsValid)
{#records exist - show survey!
	echo '
	<h3 align="center">' . $mySurvey->CategoryName . '</h3>
	<p>' . $mySurvey->Description . '</p>
	';
	echo $mySurvey->showArticle();
}else{//no such survey!
    echo '<div align="center">What! No such survey? There must be a mistake!!</div>';
    
}

echo '<div align="center"><a href="' . VIRTUAL_PATH . 'p3/index.php">Back</a></div>';

get_footer(); #defaults to theme footer or footer_inc.php

class Survey
{
    public $CategoryID = 0;
	public $Name = '';
  	public $Description = '';
	public $IsValid = false;
	public $SubCategories = array();
    
    public function __construct($id)
    {
        $id = (int)$id; //cast to integer disallows SQL injection
        $sql = "select CategoryName,Description from sm17_NewsCategory where CategoryID = " . $id;
        
   
		# connection comes first in mysqli (improved) function
		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

		if(mysqli_num_rows($result) > 0)
		{#records exist - process
			$this->IsValid = true;//record found!
			while ($row = mysqli_fetch_assoc($result))
			{
				$this->CategoryName = dbOut($row['CategoryName']);
				$this->Description = dbOut($row['Description']);
			}
		}

		@mysqli_free_result($result); # We're done with the data!

		
		
		//----start question class data here
		$sql = "select Title,Description from sm17_SubCategory where CategoryID = " . $id;
  
		# connection comes first in mysqli (improved) function
		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

		if(mysqli_num_rows($result) > 0)
		{#records exist - process
			$this->IsValid = true;//record found!
			while ($row = mysqli_fetch_assoc($result))
			{
				//$this->Title = dbOut($row['Title']);
				//$this->Description = dbOut($row['Description']);
				$this->Articles[] = new Article(dbOut($row['Title']),dbOut($row['Description']));
			}
		}

		@mysqli_free_result($result); # We're done with the data!
		//-----end question class data here
			
		
	}//end Survey __construct
	
	public function showArticle()
	{
		$id = (int)$id;
		$sql = "select Title,Description from sm17_SubCategory where CategoryID = " . $id;
		$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

		$myReturn = '';
		
		echo'
			<table class="table table-striped table-hover ">
  				<thead>
					<tr>
							<th>Title</th>
							<th>Description</th>
					</tr>
				</thead>
				<tbody>
		';
		while($row = mysqli_fetch_assoc($result))
		{# process each row
		echo'
			<tr>

				<td><a href="' . VIRTUAL_PATH . 'p3/view.php?id=' . (int)$row['SubCategoryID'] . '">' . dbOut($row['Title']) . '</a></td>
				<td>' . $article->Description . '</td>
			</tr>
		';
		}
		echo'
				</tbody>
			</table>
			';
		
		return $myReturn;
		
	}//end of showQuestions
}//end Survey class

class Article
{
	public $Title = '';
	public $Description = '';
	
	public function __construct($Title, $Description)
	{
		$this->Title = $Title;
		$this->Description = $Description;
		
		
		
	}//end of constructor
	
}//end Article class