<?php 
//Connect to server
require('../getSQL.php');

if(isset($_POST["div_id"]) && !empty($_POST["div_id"])){
  $sqlCat = "SELECT s.id, s.name, s.short_name FROM `site` s, user_sites u WHERE s.id = u.site_id AND u.user_id = ".$_POST['user_id']." AND s.customer_id =".$_POST['customer_id']." ORDER BY s.name";
  //$sqlSite = "SELECT s.id, s.name, s.short_name FROM `site` s, user_sites u WHERE s.id = u.site_id AND u.user_id = ".$_POST['user_id']." AND s.division_id =".$_POST['div_id']." ORDER BY s.name";
}

?>

			
<div class="form-group">
 <label class="col-form-label col-form-label-smX" for="site">Site <span class="badge badge-danger">Required</span></label>


<?php
try {
	$stmtS = $conn->prepare($sqlSite); 
	$stmtS->execute(); 

	echo "<select class='form-control form-control-smX site_change' id='srch_site' name='srch_site'>";

	if ($stmtS->rowCount()){
		
		echo "<option value='0'>Choose...</option>";
		while ($row = $stmtS->fetch(PDO::FETCH_ASSOC)) {
			echo "<option value=$row[id] >$row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}	
	echo "</select>";
	$stmtS = null; 
}
catch (PDOException $e) {print $e->getMessage();}
?>
</div>

