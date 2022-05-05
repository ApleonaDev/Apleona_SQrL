<?php 
require('../getSQL.php');

/* Get List of Categories for Customer: Asset or Product */
//$categoryid  = empty($_POST["category_id"] : 0 ? $_POST["category_id"];
//$categoryid  = $_POST["category_id"];
//$categorytype  = $_POST["category_type"];

$categoryid = empty($_POST["category_id"]) ? "0" : $_POST["category_id"];
$categorytype = empty($_POST["category_type"]) ? "" : $_POST["category_type"];

$sqlCat = "SELECT id,name FROM asset_category WHERE 1=2";

if(isset($_POST["customer_id"]) && !empty($_POST["customer_id"])){
	
	$sqlCat = "SELECT id,category_name, 'a' as type FROM `asset_category` WHERE customer_id =".$_POST['customer_id']." UNION select id,category_name, 'p' as type from product_category WHERE customer_id =".$_POST['customer_id']." ORDER BY category_name";

	if($categoryid>0){
					
		if($categorytype=='a'){
		
			$sqlCat = "SELECT id,category_name, 'a' as type FROM `asset_category` WHERE customer_id =".$_POST['customer_id']." AND id =".$categoryid.";";
		
		}else{
			
			$sqlCat = "select id,category_name, 'p' as type from product_category WHERE customer_id =".$_POST['customer_id']." AND id =".$categoryid.";";
			
		}
		
		
	}
 }
 


try {
	$stmtCat = $conn->prepare($sqlCat); 
	$stmtCat->execute();
	
	
	if ($stmtCat->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($cat_row = $stmtCat->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			$dsc = $cat_row['type'].','.$cat_row['id'];
			
			if($cat_row['id'] == $categoryid ){$isSelected = "selected";}
			echo "<option value=$dsc ".$isSelected.">$cat_row[category_name]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtCat = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	
	
	

?>
	
