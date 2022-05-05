<?php 
//Connect to server
require('../getSQL.php');
$sqlCat = "SELECT id,name FROM asset_category WHERE 1=2";
if(isset($_POST["customer_id"]) && !empty($_POST["customer_id"])){
  $sqlCat = "SELECT id, category_name, 'a' as type FROM `asset_category` WHERE customer_id =".$_POST['customer_id']." UNION select id, category_name, 'p' as type from product_category WHERE customer_id =".$_POST['customer_id']." ORDER BY category_name";
  //$sqlCat = "SELECT id, category_name, 'a' as type FROM `asset_category` WHERE division_id =".$_POST['division_id']." UNION select id, category_name, 'p' as type from product_category WHERE division_id =".$_POST['division_id']." ORDER BY category_name";
}

?>
<div class="form-group">
 <label class="col-form-label col-form-label-smX" for="srch_category">Category <span class="badge badge-danger">Required</span></label>


<?php
try {
	$stmtSCat = $conn->prepare($sqlCat); 
	$stmtSCat->execute(); 

	echo "<select class='form-control form-control-smX site_change' id='srch_category' name='srch_category' onchange='srchCatType(this.value);'>";

	if ($stmtSCat->rowCount()){
		
		echo "<option value='0'>Choose...</option>";
		while ($row = $stmtSCat->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value=$row[type] data-id=$row[id] >$row[category_name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}	
	echo "</select>";
	$stmtSCat = null; 
}
catch (PDOException $e) {print $e->getMessage();}
?>
</div>

