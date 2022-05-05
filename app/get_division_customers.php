<?php 
require('../getSQL.php');

$custid = $_POST["customer_id"];

$sql_customer = "SELECT distinct id,name FROM `customer` WHERE division_id =".$_POST['division_id']." order by name";

try {
	$stmtC = $conn->prepare($sql_customer); 
	$stmtC->execute();
	
	
	if ($stmtC->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($c_row = $stmtC->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			if($c_row[id] == $custid ){$isSelected = "selected";}
			echo "<option value=$c_row[id] ".$isSelected.">$c_row[name]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtC = null; 
}
catch (PDOException $e) {print $e->getMessage();}

?>
	
