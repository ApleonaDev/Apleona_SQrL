<?php 
require('../getSQL.php');

/*Rack*/
$sqlRack = "SELECT id,name FROM rack WHERE 1=2";
if(isset($_POST["area_id"]) && !empty($_POST["area_id"])){
	$sqlRack = "SELECT id,name,area_number as short_name FROM rack WHERE area_id =".$_POST['area_id']." ORDER BY name ASC";
}
?>
	

 <div class="form-group ">
	<label class="col-form-label col-form-label-smX" for="rack">Rack <span class="badge badge-danger">Required</span></label> 
	<div class="input-group input-group-alt">
<?php
try {
	$stmtRack = $conn->prepare($sqlRack); 
	$stmtRack->execute(); 
	echo "<select class='custom-select rack_change' id='rack' name='rack'>";
	if ($stmtRack->rowCount()){
		

	
		echo "<option value='0'>Choose...</option>";

		while ($rk_row = $stmtRack->fetch(PDO::FETCH_ASSOC)) {
			$rack_sh_nm = empty($rk_row["short_name"]) ? "-" : trim($rk_row["short_name"]);	
			$isSelected = "";
			if($rk_row[id] == $_POST["rack_id"] ){$isSelected = "selected";}
			echo "<option data-rackshnm=$rack_sh_nm value=$rk_row[id] ".$isSelected.">$rk_row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}
	echo "</select>";	
	$stmtRack = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>
	<div class="input-group-append">
		<button class="btn btn-outline-secondary getRackModal" type="button"><span class="loc_sh_txt" id="sh_rack" name="sh_rack"></span></button>
	</div>
	</div>
	<!--<div class="input-group-append">
		<button class="btn btn-outline-secondary getRackModal" type="button"><i class="fa fa-edit"> </i></button>
		<button class="btn btn-outline-secondary addRackModal" type="button"><i class="fa fa-plus"> </i></button>
	</div>-->
</div>

<script>
//Get filtered shelf list based on rack selected
$( ".rack_change" ).change(function() { 
	
	document.getElementById('iRack').value =0;
	document.getElementById('iShelf').value =0;
	document.getElementById('sh_rack').innerHTML ="";
	
	getShelf(this.value);

	if(this.value>0){
		
		var rackshnm = "";
		rackshnm = $( "#rack option:selected" ).data('rackshnm');
		document.getElementById('sh_rack').innerHTML  = rackshnm;
		document.getElementById('ish_rack').value  = rackshnm;
		
	}
 
	
;});


</script>
