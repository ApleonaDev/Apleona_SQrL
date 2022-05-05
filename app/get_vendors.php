<?php 
require('../getSQL.php');

$vid = $_POST["vendor_id"];
			
$sql_vndr = "SELECT distinct id,description FROM `vendor` WHERE division_id =".$_POST['division_id']." order by description";


try {
	$stmtV = $conn->prepare($sql_vndr); 
	$stmtV->execute();
	
	
	if ($stmtV->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($v_row = $stmtV->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			if($v_row[id] == $vid ){$isSelected = "selected";}
			echo "<option value=$v_row[id] ".$isSelected.">$v_row[description]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtV = null; 
}
catch (PDOException $e) {print $e->getMessage();}

?>
	
