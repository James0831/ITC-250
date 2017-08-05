<?php
//Category.php
namespace MyClasses;

/**
 * Category Class retrieves data info for an individual Category
 * 
 * The constructor creates an instance of the Category class, creates multiple instances of the 
 * SubCategory class from the DB.
 *
 * Properties of the Category class like Title, Description and TotalSubCategories provide 
 * summary information upon demand.
 * 
 * A Category object (an instance of the Category class) can be created in this manner:
 *
 * <code>
 * $myCategory = new MyClasses\Category(1);
 * </code>
 *
 * In which one is the number of a valid Category in the database. 
 *
 * The forward slash in front of IDB picks up the global namespace, which is required 
 * now that we're here inside the MyClasses namespace: \IDB::conn()
 *
 * The showSubCategories() method of the Category object created will access an array of SubCategory 
 * objects and internally access a method of the SubCategory class named showFeed() which will 
 * display the news feed related to the subcategory
 *
 * @see SubCategory
 * @todo none
 */

class Category
{
	 public $CategoryID = 0;
	 public $Title = "";
	 public $Description = "";
	 public $isValid = FALSE;
	 public $TotalSubCategories = 0; #stores number of SubCategories
	 protected $SubCategories = Array(); #stores an array of SubCategory objects
	
	/**
	 * Constructor for Category class. 
	 *
	 * @param integer $id The unique ID number of the Category
	 * @return void 
	 * @todo none
	 */ 
    function __construct($id)
	{
		//Creates CategoryID property
		$this->CategoryID = (int)$id;
		if($this->CategoryID == 0){return FALSE;}
		
		//SQL statement stored in variable
		$sql = sprintf("select CategoryID, Category, Description from " . PREFIX . "MainCategories Where CategoryID =%d", $this->CategoryID);
		
		//Records stored in variable
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));

		//if records exist, use db fields to create Title and Description properties
		if (mysqli_num_rows($result) > 0){
			$this->isValid = TRUE;
			while ($row = mysqli_fetch_assoc($result)){
			     $this->Title = dbOut($row['Category']);
			     $this->Description = dbOut($row['Description']);
			}
		}

		//Clear results
		@mysqli_free_result($result);
				
		//attempt to create SubCategory objects from db
		$sql = sprintf("select CategoryID, SubCategoryID, SubCategory, Description from " . PREFIX . "SubCategories where CategoryID = %d", $this->CategoryID);
		$result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));

		if (mysqli_num_rows($result) > 0) {
		   	while ($row = mysqli_fetch_assoc($result)){
				#create SubCategory, and push onto stack!
				$this->SubCategories[] = new SubCategory(dbOut($row['SubCategoryID']),dbOut($row['SubCategory']),dbOut($row['Description'])); 
		   	} #end while
		} #end if

		$this->TotalSubCategories = count($this->SubCategories);
		@mysqli_free_result($result); 
	} #end Category constructor
	
	/**
	 * Reveals SubCategories in array of SubCategory Objects 
	 *
	 * @param none
	 * @return string prints data from SubCategory Array 
	 * @todo none
	 */ 

	function showSubCategories()
	{
		//Create Table Headings
		echo '
		    	<table class="table table-striped table-hover ">
					<thead>
					    <tr>
					      	<th>SubCategory</th>
					      	<th>Description</th>
					    </tr>
					</thead>
					<tbody>
			';

		//Print data for each subcategory
		foreach($this->SubCategories as $SubCategory){
     		echo '
				<tr>
			      	<td><a href="' . VIRTUAL_PATH . 'p3/view.php?id=' . (int)$SubCategory->SubCategoryID . '">' . $SubCategory->Title . '</a></td>
			      	<td>' . $SubCategory->Description . '</td>
			    </tr>
	        ';
		}

		//End Table
		echo '
			</tbody>
			</table>
	    ';
		
	} #end showSubCategories()
}# end Category class