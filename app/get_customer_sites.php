<?php session_start();
//Connect to server
require('../getSQL.php');
$userId = $_SESSION['SESS_USER_ID'];
/*Sites*/
$sqlSite = "SELECT id,name FROM site WHERE 1=2";

if(isset($_POST["customer_id"]) && !empty($_POST["customer_id"])){
  //$sqlSite = "SELECT id,name, short_name, site_map_img FROM site WHERE customer_id =".$_POST['customer_id']." ORDER BY name ASC";
  
  $sqlSite = "SELECT s.id, s.name, s.short_name, s.site_map_img FROM `site` s, user_sites u WHERE s.id = u.site_id AND u.user_id = ".$userId." AND s.customer_id =".$_POST['customer_id']." ORDER BY s.name";

}
?>
	
<div class="input-group mb-3">
	<div class="input-group-prepend">
	<label class="input-group-text" for="site">Site <span class="badge badge-danger">Required</span></label>
	</div>

<?php
try {
	$stmtSite = $conn->prepare($sqlSite); 
	$stmtSite->execute(); 

	echo "<select class='custom-select site_change' id='site' name='site'>";

	if ($stmtSite->rowCount()){
		
		//if ($stmtSite->rowCount()>1){}
		echo "<option value='0'>Choose...</option>";
		while ($row = $stmtSite->fetch(PDO::FETCH_ASSOC)) {
				
			$isSelected = "";
			//$site_map = $row["site_map_img"];
			$site_map = empty($row["site_map_img"]) ? "placeholder.png" : trim($row["site_map_img"]);
		
			$site_sh_nm = empty($row["short_name"]) ? "-" : trim($row["short_name"]);
			if($row[id] == $_POST["site_id"] ){$isSelected = "selected";}
			echo "<option data-siteshnm=$site_sh_nm data-siteimg=$site_map value=$row[id] ".$isSelected.">$row[name]</option>";
		}
	}else{
		echo "<option value='0'>No options available</option>";
	}	
	echo "</select>";
	
		
		
	$stmtSite = null; 
}
catch (PDOException $e) {print $e->getMessage();}


?>
	<!--<div class="input-group-append">
		<button class="btn btn-outline-secondary getSiteModal" type="button"><i class="fa fa-edit"> </i></button>
		<button class="btn btn-outline-secondary" type="button"><i class="fa fa-plus"> </i></button>
	</div>-->
	
</div>
<script>
$( ".site_change" ).change(function() { 
	
	var siteimg ='placeholder.png';
	document.getElementById('iSite').value =0;
	document.getElementById('iBld').value =0;
	document.getElementById('iFloor').value =0;
	document.getElementById('iRoom').value =0;
	document.getElementById('iArea').value =0;
	document.getElementById('iRack').value =0;
	document.getElementById('iShelf').value =0;
	document.getElementById('sh_bld').innerHTML ="";
	document.getElementById('sh_flr').innerHTML ="";
	document.getElementById('sh_room').innerHTML ="";
	document.getElementById('sh_area').innerHTML ="";
	document.getElementById('sh_rack').innerHTML ="";
	document.getElementById('sh_shelf').innerHTML ="";
	if(this.value>0){
		var siteshnm = $( "#site option:selected" ).data('siteshnm');
		
		siteimg = $( "#site option:selected" ).data('siteimg');
		document.getElementById('ish_site').value  = siteshnm;
		document.getElementById('iSiteImg').value  = siteimg;
		$("#loc_img").attr("src", "images/"+siteimg);
		$("#loc_img_full").attr("src", "images/"+siteimg);

	}else{
		document.getElementById('iSiteImg').value  = siteimg;
		$("#loc_img").attr("src", "images/"+siteimg);
		$("#loc_img_full").attr("src", "images/"+siteimg);
	}
	getShelf(0);
	getRack(0);
	getArea(0);
	getRoom(0);
	getFloor(0);
	getBld(this.value);
	
});
//$(".getSiteModal").click(function(e) {alert($('#site').val());});


</script>
