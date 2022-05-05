
<?php 
require('../getSQL.php');


$cdtn_id = $_POST["condition_id"];


$sql = "SELECT id, `asset_condition`, hex_color FROM `asset_condition` WHERE division_id =".$_POST['division_id']." ORDER BY id";

try {
	$stmt = $conn->prepare($sql); 
	$stmt->execute();
	
	
	if ($stmt->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($cdtn_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			$bgcolor = $cdtn_row['hex_color'];
			
			if($cdtn_row[id] == $cdtn_id ){$isSelected = "selected";}
			echo "<option style='font-weight:bold;color:$bgcolor' value=$cdtn_row[id] ".$isSelected."> $cdtn_row[asset_condition] </option>";
		}
	}else{
		
		echo "<option value='0'>No options available</option>";
	}
	
	$stmt = null; 
}
catch (PDOException $e) {print $e->getMessage();}

?>
	
