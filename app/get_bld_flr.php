<?php 
require('../getSQL.php');

/*Floor*/
//SELECT `id`, `building_id`, `responsible_user_id`, `name`, `type`, `level`, `description`, `created_at`, `last_updated` FROM `floor` WHERE 1
$sqlFlr = "SELECT id,name FROM floor WHERE 1=2";

if(isset($_POST["build_id"]) && !empty($_POST["build_id"])){
	
  $sqlFlr = "SELECT id,name,short_name FROM floor WHERE building_id =".$_POST['build_id']." ORDER BY name ASC";
}
?>
	

 <div class="form-group ">
	<label class="col-form-label col-form-label-smX" for="floor">Floor <span class="badge badge-danger">Required</span></label> 
	<div class="input-group input-group-alt">
<?php
try {
	$stmtFlr = $conn->prepare($sqlFlr); 
	$stmtFlr->execute();
	echo "<select class='custom-select floor_change' id='floor' name='floor'>";
	if ($stmtFlr->rowCount()){
		echo "<option value='0'>Choose...</option>";

		while ($flr_row = $stmtFlr->fetch(PDO::FETCH_ASSOC)) {
			$flr_sh_nm = empty($flr_row["short_name"]) ? "-" : trim($flr_row["short_name"]);
			$isSelected = "";
			if($flr_row[id] == $_POST["floor_id"] ){$isSelected = "selected";}
			echo "<option data-flrshnm=$flr_sh_nm value=$flr_row[id] ".$isSelected.">$flr_row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}
	echo "</select>";	
	$stmtFlr = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>
	<div class="input-group-append">
		<button class="btn btn-outline-secondary getFloorModal" type="button"><span class="loc_sh_txt" id="sh_flr" name="sh_flr"></span></button>
	</div>
	</div>
	<!--<div class="input-group-append">
		<button class="btn btn-outline-secondary getFloorModal" type="button"><i class="fa fa-edit"> </i></button>
		<button class="btn btn-outline-secondary addFloorModal" type="button"><i class="fa fa-plus"> </i></button>
	</div>-->
</div>

<script>
//Get filtered room list based on floor selected
$( ".floor_change" ).change(function() { 
	document.getElementById('iFloor').value =0;
	document.getElementById('iRoom').value =0;
	document.getElementById('iArea').value =0;
	document.getElementById('iRack').value =0;
	document.getElementById('iShelf').value =0;
	document.getElementById('sh_room').innerHTML ="";
	document.getElementById('sh_area').innerHTML ="";
	document.getElementById('sh_rack').innerHTML ="";
	document.getElementById('sh_shelf').innerHTML ="";
	if(this.value>0){
		
		var flrshnm = $( "#floor option:selected" ).data('flrshnm');
		document.getElementById('sh_flr').innerHTML  = flrshnm;
		document.getElementById('ish_flr').value  = flrshnm;

	}
	getShelf(0);
	getRack(0);
	getArea(0);
	getRoom(this.value);
	
});
//$(".getFloorModal").click(function(e) {alert($('#floor').val());});
//$(".addFloorModal").click(function(e) { alert('<?php echo $_POST["floor_id"]; ?>');  });

</script>
