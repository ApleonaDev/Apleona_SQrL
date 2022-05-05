 <?php 	
//require_once('auth.php'); //	CHECK: 	IF LOGIN SUCCESSFUL  -> Done in HEADER FILE head.php//
// Check if session is not registered, redirect back to main page.
// Put this code in first line of web page.
//if(!session_is_registered($_SESSION['SESS_USER_NAME'])){header("location:../index.php");}

session_start(); 

if($_SESSION['SESS_USER_ID']){
	
	require('head.php');
	include('aside_index.php');
	//Connect to server
	require('../getSQL.php');
	//Get customer and site list available to user
	//If user type is super admin then select all sites : 0, 1, 2
	//else 
		//type 3: sees all customer sites
		//type 4, 5, 6, 7: see only site information
		
	$qry_sites="SELECT * FROM user_sites WHERE user_id='".$_SESSION['SESS_USER_ID']."'";

?>

	<!-- Content Wrapper. Contains page content -->
<main class="app-main">
	<!-- .wrapper -->
	<div class="wrapper">
	  <!-- .page -->
	  <div class="page">
		 <div class="page-inner">
		  <!-- .page-title-bar -->
		  <!--<header class="page-title-bar">
			<div class="d-flex flex-column flex-md-row">
			  <p class="lead">
				<span class="font-weight-bold">Hey, <?php echo $_SESSION['SESS_USER_NAME']; ?>.</span> <span class="d-block text-muted"> View Report</span>
			  </p>
			  <div class="ml-auto">
			  </div>
			</div>
		  </header>--><!-- /.page-title-bar -->


	<form class="form-horizontal" name="site_report_form" id="site_report_form" method="POST" enctype="multipart/form-data" action="" >
		<input type="hidden" id="session_user" name="session_user" placeholder="" value="<?php echo $_SESSION['SESS_USER_NAME'];?>">
		<input type="hidden" id="rptDivId" name="rptDivId" value="">
	
		<div class="page-section">
		<!-- .section-block -->
		<div class="section-block">
		<!-- metric row -->
		</div><!-- /.section-block -->
	<div class="row"><div class="col-md-4"><div id="displayRptErr"></div></div></div>
		
		<!-- grid row -->
		<div class="row">
			<!-- grid column -->
			<div class="col-12 col-lg-8 col-xl-8">
				<div class="card card-fluid">
				  <!-- .card-body -->
				  <div class="card-body">
					<fieldset>
					<div class="form-group">
					  <label class="col-form-label col-form-label-smX" for="rpt_division">Division <span class="badge badge-danger">Required</span></label> 
						
					  <?php
				
						$sql = "SELECT DISTINCT c.id, c.name, c.short_name FROM `division` as c , site as s, user_sites u WHERE c.`id` = s.customer_id AND s.id = u.site_id 
							AND u.user_id = $_SESSION[SESS_USER_ID]  ORDER BY name";
							
							
						try {
							$stmt = $conn->prepare($sql); 
							$stmt->execute(); 
							if ($stmt->rowCount()){
								
								//$rowCount = $stmt->rowCount();
								echo "<select $disabled class='form-control form-control-smX' id='rpt_division' name='rpt_division' >";
								echo "<option value='0'>Choose...</option>";
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$isSelected = "";
									$div_sh_nm = empty($row["short_name"]) ? "-" : trim($row["short_name"]);
									if($row[id] == $custId ){$isSelected = "selected";}
									echo "<option data-divshnm=$div_sh_nm value=$row[id] ".$isSelected.">$row[name]</option>";
								}echo "</select>";
							}
								
						$stmt = null; }
						catch (PDOException $e) {
						print $e->getMessage();
						}
						?>
					  
					</div><!-- /.form-group -->
					
					<div class="form-group"><div class="showRptSite"></div></div>
					
					<!--
					<div class="form-group division_div">
					  <label class="col-form-label col-form-label-smX" for="rpt_customer">Client </label> 
						<select class='form-control form-control-smX' id='rpt_customer' name='rpt_customer' > <option value='0'>No options available</option> </select>
					</div>--><!-- /.form-group -->
					

					<div class="form-group" >
					<button type="button" data-style="expand-right" id="submitSiteReport" class="btn btn-primary"><i class="fa fa-clipboard"> </i> View</button>
					</div><!-- /.form-group -->				
					</fieldset>
					
				  </div><!-- /.card-body -->
				 </div><!-- /.card -->
				
			
				<div class="card card-fluid" id="rpt_results_div" style="display:none">
				  <!-- .card-body -->
				  <div class="card-body">
					<h3 class="card-title mb-4"></h3>
					<div class="form-group" id="vw_site_rpt_tbl"></div>
				  </div><!-- /.card-body -->
				</div><!-- /.card -->
			</div>
			<div class="col-12 col-lg-4 col-xl-4" id = "item_details" ></div>  
		
		</div>
	
	
	
	
	
	
		</div><!-- /.page-section -->


	<?php //include 'item_modal.php';?>  
	</form>
   
   
   

   
 </div>
  <!-- /.content-wrapper -->
	<!-- Main Footer -->
	 <?php require('foot.php');?>

	</div>  <!-- /.content-wrapper -->
<?php	
	
}else{
	
	//echo "no session";
	//header("location: ../login-idErr.php");
	header("location: ../sqrl_login.php");
	exit();

}


?>
<!-- REQUIRED JS SCRIPTS -->

<script src="../assets/javascript/sqrl_valid.js"></script>
<script src="../assets/javascript/sqrl_search.js"></script>
<script src="../assets/javascript/sqrl_rpt.js"></script>


<script>

	$(document).ready(function() 
	{

		
		$('#rpt_division').on('change',function(){
			
			$('#vw_site_rpt_tbl').empty();
			$('#item_details').hide();
			$('.showRptSite').hide();
			
			var userId = "<?php echo $_SESSION['SESS_USER_ID']; ?>";
			
			
			getRptSite(userId);
			
		});	
		
		//$(".closeItemMdl").click(function(e) {$('#vw_site_rpt_tbl').empty();fn_view_report();});
		
	});

	
	//Ladda.bind( 'input[type=button]' );
	$('#submitSiteReport').click(function(e){
		e.preventDefault();
		
		$("#rpt_results_div").css("display","none");
	 	//var l = Ladda.create(this);
	 	//l.start();
		$('#item_details').hide();
		$('#vw_site_rpt_tbl').empty();
		//fn_view_report(l);
		fn_view_report();
		//l.stop();
		return false;
	});
	
	
	






</script>

