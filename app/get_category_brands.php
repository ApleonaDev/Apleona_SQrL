<?php 
require('../getSQL.php');


//if(isset($_POST["cust_id"]) && !empty($_POST["cust_id"])){}
$catType = trim($_POST["itypeS"]);
$inm = empty($_POST["inm"]) ? "" : $_POST["inm"];


if($catType == 'a'){
	//$sql_nm = "SELECT distinct at.name as item_name FROM `asset_type` as at WHERE customer_id =".$_POST['customer_id']." AND category_id =".$_POST['category_id']." order by at.name";
	$sql_nm = "SELECT distinct at.name as item_name FROM `asset_type` as at WHERE division_id =".$_POST['division_id']." AND category_id =".$_POST['category_id']." order by at.name";
}else if($catType == 'p'){
	//$sql_nm = "SELECT distinct pt.name as item_name FROM `product_type` as pt WHERE customer_id =".$_POST['customer_id']." AND category_id =".$_POST['category_id']." order by pt.name";	
	$sql_nm = "SELECT distinct pt.name as item_name FROM `product_type` as pt WHERE division_id =".$_POST['division_id']." AND category_id =".$_POST['category_id']." order by pt.name";	
}


try {
	$stmtNm = $conn->prepare($sql_nm); 
	$stmtNm->execute();
	
	
	if ($stmtNm->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($nm_row = $stmtNm->fetch(PDO::FETCH_ASSOC)) {
			
			$isSelected = "";
			if($nm_row['item_name'] == $inm ){$isSelected = "selected";}
			//echo "<option value=$nm_row[id] ".$isSelected.">$nm_row[name]</option>";
			echo "<option value=$nm_row[item_name] ".$isSelected.">$nm_row[item_name]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtNm = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>
