<?php 
require('../getSQL.php');

$mid = $_POST["manu_id"];

$sql_manu = "SELECT distinct id,name FROM `maunufacturer` WHERE division_id =".$_POST['division_id']." order by name";

try {
	$stmtManu = $conn->prepare($sql_manu); 
	$stmtManu->execute();
	
	
	if ($stmtManu->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($manu_row = $stmtManu->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			if($manu_row[id] == $mid ){$isSelected = "selected";}
			echo "<option value=$manu_row[id] ".$isSelected.">$manu_row[name]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtManu = null; 
}
catch (PDOException $e) {print $e->getMessage();}

?>
	
