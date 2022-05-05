<?php 
require('../getSQL.php');

/*Shelf*/

//SELECT `id`, `rack_id`, `responsible_user_id`, `name`, `type`, `area_number`, `description`, `created_at`, `last_updated` FROM `shelf` WHERE 1
$sqlShelf = "SELECT id,name FROM shelf WHERE 1=2";

if(isset($_POST["rack_id"]) && !empty($_POST["rack_id"])){
	
  //$sqlShelf = "SELECT id,name,area_number as short_name  FROM shelf WHERE rack_id =".$_POST['rack_id']." ORDER BY name ASC";
  $sqlShelf = "SELECT id,name, short_name  FROM shelf WHERE rack_id =".$_POST['rack_id']." ORDER BY name ASC";
}
?>
	

 <div class="form-group ">
	<label class="col-form-label col-form-label-smX" for="shelf">Shelf <span class="badge badge-danger">Required</span></label> 
	<div class="input-group input-group-alt">	
<?php
try {
	$stmtShelf = $conn->prepare($sqlShelf); 
	$stmtShelf->execute(); 
	
	echo "<select class='custom-select shelf_change' id='shelf' name='shelf'>";
	if ($stmtShelf->rowCount()){
		

	
		echo "<option value='0'>Choose...</option>";

		while ($shlf_row = $stmtShelf->fetch(PDO::FETCH_ASSOC)) {
			$shelf_sh_nm = empty($shlf_row["short_name"]) ? "-" : trim($shlf_row["short_name"]);		
			$isSelected = "";
			if($shlf_row[id] == $_POST["shelf_id"] ){$isSelected = "selected";}
			echo "<option data-shlfshnm=$shelf_sh_nm value=$shlf_row[id] ".$isSelected.">$shlf_row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}
	echo "</select>";	
	$stmtShelf = null; 
}
catch (PDOException $e) {print $e->getMessage();}
	

?>
	<div class="input-group-append">
		<button class="btn btn-outline-secondary getShelfModal" type="button"><span class="loc_sh_txt" id="sh_shelf" name="sh_shelf"></span></button>
	</div>
	</div>	
</div>

<script>

$( ".shelf_change" ).change(function() { 

	var shlfshnm = "";
	shlfshnm = $( "#shelf option:selected" ).data('shlfshnm');
	document.getElementById('sh_shelf').innerHTML  = shlfshnm;
	document.getElementById('ish_shelf').value  = shlfshnm;
	
});
//$(".getShelfModal").click(function(e) {alert($('#shelf').val());});
//$(".addShelfModal").click(function(e) { alert('<?php echo $_POST["shelf_id"]; ?>');  });


</script>
