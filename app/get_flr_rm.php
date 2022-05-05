<?php 
require('../getSQL.php');

/*Room*/

//SELECT `id`, `floor_id`, `responsible_user_id`, `name`, `type`, `room_number`, `description`, `created_at`, `last_updated` FROM `room` WHERE 1
$sqlRm = "SELECT id,name FROM room WHERE 1=2";

if(isset($_POST["floor_id"]) && !empty($_POST["floor_id"])){
	
  $sqlRm = "SELECT id,name,`room_number`,short_name FROM room WHERE floor_id =".$_POST['floor_id']." ORDER BY name ASC";
}
?>
	


 <div class="form-group ">
	<label class="col-form-label col-form-label-smX" for="room">Room <span class="badge badge-danger">Required</span></label> 
	<div class="input-group input-group-alt">
<?php
try {
	$stmtRm = $conn->prepare($sqlRm); 
	$stmtRm->execute(); 
	
	echo "<select class='custom-select room_change' id='room' name='room'>";
	if ($stmtRm->rowCount()){
		

	
		echo "<option value='0'>Choose...</option>";

		while ($rm_row = $stmtRm->fetch(PDO::FETCH_ASSOC)) {
			$rm_sh_nm = empty($rm_row["short_name"]) ? "-" : trim($rm_row["short_name"]);	
			$isSelected = "";
			if($rm_row[id] == $_POST["room_id"] ){$isSelected = "selected";}
			echo "<option data-rmshnm=$rm_sh_nm value=$rm_row[id] ".$isSelected.">$rm_row[name] $rm_row[room_number]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}
	echo "</select>";	
	$stmtRm = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>
	<div class="input-group-append">
		<button class="btn btn-outline-secondary getRoomModal" type="button"><span class="loc_sh_txt" id="sh_room" name="sh_room"></span></button>
	</div>
	</div>
	<!--<div class="input-group-append">
		<button class="btn btn-outline-secondary getRoomModal" type="button"><i class="fa fa-edit"> </i></button>
		<button class="btn btn-outline-secondary addRoomModal" type="button"><i class="fa fa-plus"> </i></button>
	</div>-->
</div>

<div class="form-group  crate_div" style="display:none">
<!-- grid column -->

<div class="col-md-4 mb-3">
<label for="input_crate_number">Crate Number</label> 
<div class="input-group input-group-alt">

<input  type="number" min=0 class="form-control" id="input_crate_number" name="input_crate_number" value="<?php echo $iCrateNo;?>">

			 
			 
</div><!-- /.input-group -->
</div><!-- /grid column -->
</div>
<script>
//Get filtered area list based on room selected
$( ".room_change" ).change(function() { 

	$('.crate_div').hide();

	document.getElementById('iRoom').value =0;
	document.getElementById('iArea').value =0;
	document.getElementById('iRack').value =0;
	document.getElementById('iShelf').value =0;
	document.getElementById('sh_area').innerHTML ="";
	document.getElementById('sh_rack').innerHTML ="";
	document.getElementById('sh_shelf').innerHTML ="";

	if(this.value>0){
		
		var rmshnm = $( "#room option:selected" ).data('rmshnm');
		document.getElementById('sh_room').innerHTML  = rmshnm;
		document.getElementById('ish_room').value  = rmshnm;
		
		//Crate System
		var str = $( "#room option:selected" ).text();
		
		if(str.indexOf("Crate") >= 0){
			
			$('.crate_div').show();
		}else{
			$('.crate_div').hide();
		}
	}
	getShelf(0);
	getRack(0);
	getArea(this.value);
	

});
//$(".getRoomModal").click(function(e) {alert($('#room').val());});
//$(".addRoomModal").click(function(e) { alert('<?php echo $_POST["room_id"]; ?>');  });


</script>
