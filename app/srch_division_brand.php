<?php 
//Connect to server
require('../getSQL.php');

$catType = trim($_POST["catType"]);
$divId = $_POST["division_id"];
$catId = $_POST["catId"];
if(isset($_POST["customer_id"]) && !empty($_POST["customer_id"])){
	if($catType == 'a'){
		//$sql_nm = "SELECT distinct at.id, at.name as item_name FROM `asset_type` as at WHERE customer_id =".$_POST['customer_id']." order by at.name";
		$sql_nm = "SELECT distinct at.name as item_name FROM `asset_type` as at WHERE division_id =".$_POST['division_id']." AND category_id =".$_POST['catId']." order by at.name";
	}else if($catType == 'p'){
		//$sql_nm = "SELECT distinct pt.id, pt.name as item_name FROM `product_type` as pt WHERE customer_id =".$_POST['customer_id']." order by pt.name";	
		$sql_nm = "SELECT distinct pt.name as item_name FROM `product_type` as pt WHERE division_id =".$_POST['division_id']." AND category_id =".$_POST['catId']." order by pt.name";	
	}
}

?>
<div class="form-group">
 <label class="col-form-label col-form-label-smX" for="srch_brand">Item Name</label>


<?php
try {
	$stmtSBrand = $conn->prepare($sql_nm); 
	$stmtSBrand->execute(); 

	echo "<select class='form-control form-control-smX site_change' id='srch_brand' name='srch_brand'>";

	if ($stmtSBrand->rowCount()){
		
		echo "<option value='0'>Choose...</option>";
		while ($row = $stmtSBrand->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value=$row[item_name] >$row[item_name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}	
	echo "</select>";
	$stmtSBrand = null; 
}
catch (PDOException $e) {print $e->getMessage();}
?>
</div>

