<?php 
require('../getSQL.php');

/*Area*/

//SELECT `id`, `room_id`, `responsible_user_id`, `name`, `type`, `area_number`, `description`, `created_at`, `last_updated` FROM `area` WHERE 1
$sqlArea = "SELECT id,name FROM area WHERE 1=2";

if(isset($_POST["room_id"]) && !empty($_POST["room_id"])){
	
  $sqlArea = "SELECT id,name, area_number as short_name FROM area WHERE room_id =".$_POST['room_id']." ORDER BY name ASC";
}
?>
	

 <div class="form-group ">
	<label class="col-form-label col-form-label-smX" for="area">Area <span class="badge badge-danger">Required</span></label> 
	<div class="input-group input-group-alt">
<?php
try {
	$stmtArea = $conn->prepare($sqlArea); 
	$stmtArea->execute(); 
	
	echo "<select class='custom-select area_change' id='area' name='area'>";
	if ($stmtArea->rowCount()){
		

	
		echo "<option value='0'>Choose...</option>";

		while ($area_row = $stmtArea->fetch(PDO::FETCH_ASSOC)) {
			$area_sh_nm = empty($area_row["short_name"]) ? "-" : trim($area_row["short_name"]);
			$isSelected = "";
			if($area_row[id] == $_POST["area_id"] ){$isSelected = "selected";}
			echo "<option data-areashnm=$area_sh_nm value=$area_row[id] ".$isSelected.">$area_row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}
	echo "</select>";	
	$stmtArea = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>
	<div class="input-group-append">
		<button class="btn btn-outline-secondary getAreaModal" type="button"><span class="loc_sh_txt" id="sh_area" name="sh_area"></span></button>
	</div>
	</div>
	<!--<div class="input-group-append">
		<button class="btn btn-outline-secondary getAreaModal" type="button"><i class="fa fa-edit"> </i></button>
		<button class="btn btn-outline-secondary addAreaModal" type="button"><i class="fa fa-plus"> </i></button>
	</div>-->
</div>

<script>
//Get filtered Rack list based on area selected
$( ".area_change" ).change(function() { 

	var areashnm = "";
	document.getElementById('iArea').value =0;
	document.getElementById('iRack').value =0;
	document.getElementById('iShelf').value =0;
	
	document.getElementById('sh_area').innerHTML ="";
	document.getElementById('sh_rack').innerHTML ="";
	document.getElementById('sh_shelf').innerHTML ="";
	

	if(this.value>0){
		
		areashnm = $( "#area option:selected" ).data('areashnm');
		document.getElementById('sh_area').innerHTML  = areashnm;
		document.getElementById('ish_area').value  = areashnm;
	
	}
	getShelf(0);
	getRack(this.value);
	

});
//$(".getAreaModal").click(function(e) {alert($('#area').val());});
//$(".addAreaModal").click(function(e) { alert('<?php echo $_POST["area_id"]; ?>');  });


</script>
