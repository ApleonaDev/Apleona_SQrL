<?php 
require('../getSQL.php');

$cltid = $_POST["client_id"];

$sql_clt = "SELECT distinct id,name FROM `client` WHERE division_id =".$_POST['division_id']." order by name";

try {
	$stmtClt = $conn->prepare($sql_clt); 
	$stmtClt->execute();
	
	
	if ($stmtClt->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($clt_row = $stmtClt->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			if($clt_row[id] == $cltid ){$isSelected = "selected";}
			echo "<option value=$clt_row[id] ".$isSelected.">$clt_row[name]</option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmtClt = null; 
}
catch (PDOException $e) {print $e->getMessage();}

?>
	
