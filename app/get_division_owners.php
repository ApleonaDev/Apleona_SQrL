<?php 
require('../getSQL.php');

$own_id = $_POST["owner_id"];

$sql_owner = "SELECT distinct id,name FROM `owner` WHERE division_id =".$_POST['division_id']." order by name";
//$sql_owner = "SELECT distinct id,name FROM `vendor` WHERE division_id =".$_POST['division_id']." order by name";

try {
	$stmtOwn = $conn->prepare($sql_owner); 
	$stmtOwn->execute();
	
	
	if ($stmtOwn->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($o_row = $stmtOwn->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			if($o_row[id] == $own_id ){$isSelected = "selected";}
			echo "<option value=$o_row[id] ".$isSelected.">$o_row[name]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtOwn = null; 
}
catch (PDOException $e) {print $e->getMessage();}

?>
	
