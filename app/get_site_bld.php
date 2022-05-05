<?php 
require('../getSQL.php');

/*Building*/
$sqlBld = "SELECT id,name FROM building WHERE 1=2";
if(isset($_POST["site_id"]) && !empty($_POST["site_id"])){
	
  $sqlBld = "SELECT id,name,short_name FROM building WHERE site_id =".$_POST['site_id']." ORDER BY name ASC";
}
?>
	
 <div class="form-group ">
	<label class="col-form-label col-form-label-smX" for="build">Building <span class="badge badge-danger">Required</span></label> 
	<div class="input-group input-group-alt">	
	

<?php
try {
	$stmtBld = $conn->prepare($sqlBld); 
	$stmtBld->execute();
	
	echo "<select class='custom-select build_change' id='build' name='build'>";
	if ($stmtBld->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($bld_row = $stmtBld->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			$bld_sh_nm = empty($bld_row["short_name"]) ? "-" : trim($bld_row["short_name"]);
			if($bld_row[id] == $_POST["build_id"] ){$isSelected = "selected";}
			echo "<option data-bldshnm=$bld_sh_nm value=$bld_row[id] ".$isSelected.">$bld_row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}
	echo "</select>";	
	$stmtBld = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>

	<div class="input-group-append">
		<button class="btn btn-outline-secondary getBuildingModal" type="button"><span class="loc_sh_txt" id="sh_bld" name="sh_bld"></span></button>
	</div>	
	</div>	
</div>

<script>
//Get filtered floor list based on building selected
$( ".build_change" ).change(function() {
	
	document.getElementById('iBld').value =0;
	document.getElementById('iFloor').value =0;
	document.getElementById('iRoom').value =0;
	document.getElementById('iArea').value =0;
	document.getElementById('iRack').value =0;
	document.getElementById('iShelf').value =0;
	document.getElementById('sh_flr').innerHTML ="";
	document.getElementById('sh_room').innerHTML ="";
	document.getElementById('sh_area').innerHTML ="";
	document.getElementById('sh_rack').innerHTML ="";
	document.getElementById('sh_shelf').innerHTML ="";
	if(this.value>0){		
		var bldshnm = $( "#build option:selected" ).data('bldshnm');
		document.getElementById('sh_bld').innerHTML  = bldshnm;
		document.getElementById('ish_bld').value  = bldshnm;
	}
	getRoom(0);
	getArea(0);
	getRack(0);
	getShelf(0);
	getFloor(this.value);
	
});
//$(".getBuildingModal").click(function(e) {alert($('#build').val());});


</script>
