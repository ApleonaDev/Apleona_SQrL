<?php 
require('../getSQL.php');

if(isset($_POST["division_id"]) && !empty($_POST["division_id"])){
  //$sqlCat = "SELECT s.id, s.name, s.short_name FROM `site` s, user_sites u WHERE s.id = u.site_id AND u.user_id = ".$_POST['user_id']." AND s.customer_id =".$_POST['customer_id']." ORDER BY s.name";
  
  $sql_customer = "SELECT distinct id,name FROM `customer` WHERE division_id =".$_POST['division_id']." order by name";
}



?>

			
<div class="form-group">
 <label class="col-form-label col-form-label-smX" for="srch_customer">Client <span class="badge badge-danger">Required</span></label>


<?php
try {
	$stmtSC = $conn->prepare($sql_customer); 
	$stmtSC->execute(); 

	echo "<select class='form-control form-control-smX customer_change' id='srch_customer' name='srch_customer' onchange='srchCustChange(this.value)'>";

	if ($stmtSC->rowCount()){
		
		echo "<option value='0'>Choose...</option>";
		while ($row = $stmtSC->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value=$row[id] >$row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}	
	echo "</select>";
	$stmtSC = null; 
}
catch (PDOException $e) {print $e->getMessage();}
?>
</div>



	
