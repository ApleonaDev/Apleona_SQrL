 <?php 	
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
<main class="app-main">
        <!-- .wrapper -->
        <div class="wrapper">
          <!-- .page -->
          <div class="page">
             <div class="page-inner">
              <!-- .page-title-bar -->
             <!-- <header class="page-title-bar">
                <div class="d-flex flex-column flex-md-row">
                  <p class="lead">
                    <span class="font-weight-bold">Hey, <?php echo $_SESSION['SESS_USER_NAME']; ?>.</span> <span class="d-block text-muted">Search for Item</span>
                  </p>
                  <div class="ml-auto">
                  </div>
                </div>
              </header>--><!-- /.page-title-bar -->
<!-- .page-section -->
		<form class="form-horizontal" name="srch_form" id="srch_form" method="POST" enctype="multipart/form-data" action="" >
			<input type="hidden" id="session_user" name="session_user" placeholder="" value="<?php echo $_SESSION['SESS_USER_NAME'];?>">
			<input type="hidden" id="session_user_id" name="session_user_id" placeholder="" value="<?php echo $_SESSION['SESS_USER_ID'];?>">
			<input type="hidden" id="srchDivId" name="srchDivId" value="">
			<input type="hidden" id="srchCustId" name="srchCustId" value="">
		
		
              <div class="page-section">
                <!-- .section-block -->
                <div class="section-block">
                  <!-- metric row -->
                </div><!-- /.section-block -->
                <!-- grid row -->
                <div class="row">
				  <!-- grid column -->
                  <div class="col-12 col-lg-6 col-xl-4">
				  
				  
                    <!-- .card -->
                    <div class="card card-fluid">
                      <!-- .card-body -->
                      <div class="card-body">
                     <div id="displaySrchCat"></div>
					 
                      <!-- .fieldset -->
                      <fieldset>
                        <!-- <legend>Sizes</legend>--> <!-- .form-group -->
						
						<div class="form-group">
						  <label class="col-form-label col-form-label-smX" for="srch_division">Division <span class="badge badge-danger">Required</span></label> 
							
						  <?php
					
							$sql = "SELECT DISTINCT c.id, c.name, c.short_name FROM `division` as c , site as s, user_sites u WHERE c.`id` = s.customer_id AND s.id = u.site_id 
								AND u.user_id = $_SESSION[SESS_USER_ID]  ORDER BY name";
							try {
								$stmt = $conn->prepare($sql); 
								$stmt->execute(); 
								if ($stmt->rowCount()){
									
									//$rowCount = $stmt->rowCount();
									echo "<select $disabled class='form-control form-control-smX' id='srch_division' name='srch_division' >";
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
			
						
						<!-- <div class="showSrchDivCustomer"></div>	-->
						<div class="showSrchSite"></div>	
						<div class="showSrchCat"></div>
						<div class="showSrchBrand"></div>
			
                        <div class="form-group asset_div" style="display:none">
                          <label class="col-form-label col-form-label-smX" for="input_srch_status">Status</label>
						   <?php
								$sql = "SELECT id, `asset_status` FROM `asset_status` ORDER BY asset_status";

								try {
									$stmt = $conn->prepare($sql); 
									$stmt->execute(); 
									if ($stmt->rowCount()){
										
										echo "<select class='form-control form-control-smX' id='input_srch_status' name='input_srch_status'>";
										echo "<option value='0'>Choose...</option>";
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
												
											echo "<option value=$row[id]>$row[asset_status]</option>";
										}echo "</select>";
									}
										
									$stmt = null; }
									catch (PDOException $e) {
									print $e->getMessage();
									}
									
							?>
						  
						  
                        </div><!-- /.form-group -->
						
						<div class="form-group" >
						 
						  <button type="button" data-style="expand-right" id="submitItemSearch" class="btn btn-primary ladda-button btn-smX btn-block"><i class="fa fa-search"> </i> <span class="ladda-label">Search</span> <span class="ladda-spinner"></span></button>
                       
						
                        </div><!-- /.form-group -->
						
						
                      </fieldset><!-- /.fieldset -->
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
					
					<div class="card card-fluid" id="srch_results_div" style="display:none">
                      <!-- .card-body -->
                      <div class="card-body">
                        <h3 class="card-title mb-4"></h3>
						<div class="form-group" id="vw_srch_tbl"></div>
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                  </div><!-- /grid column -->
				  
				  
				  <div class="col-12 col-lg-6 col-xl-8" id = "item_details" ></div>  
				   <!-- grid column -->
				 
                </div><!-- /grid row -->

			  </div><!-- /.page-section -->

		<?php //include 'item_modal.php';?>       
        </form>  
	 </div><!-- /.page-inner -->

	<!-- Main Footer -->
	 <?php require('foot.php');?>
	
	
<?php	
	
}else{
	
	//echo "no session";
	//header("location: ../login-idErr.php");
	header("location: ../sqrl_login.php");
	exit();

}


?>
<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../dist/js/app.min.js"></script>
<link rel="stylesheet" href="../plugins/ladda/ladda-themeless.min.css">
<script src="../plugins/ladda/spin.min.js"></script>
<script src="../plugins/ladda/ladda.min.js"></script>-->

<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/javascript/sqrl_valid.js"></script>
<script src="../assets/javascript/sqrl_search.js"></script>
<script src="../assets/javascript/sqrl_item.js"></script>
<script>

	$(document).ready(function() {


	//$('.showSrchDivCustomer').hide();	
	
	
	$('#srch_division').on('change',function(){
		
		
		$('#vw_srch_tbl').empty();
		$('.asset_div').hide();
		$('.product_div').hide();
		//$('.showSrchDivCustomer').hide();
		$('.showSrchSite').hide();
		$('.showSrchBrand').hide();
		$('#srch_results_div').hide();
		$('#item_details').hide();

		
		if(this.value>0){
			
			
			//getSrchCustomer(this.value);
			
			getSrchSite(this.value,document.getElementById('session_user_id').value);
			getSrchCategory(this.value);
			
		}else {
			
			$('#vw_srch_tbl').empty();
			$('.asset_div').hide();
			$('.product_div').hide();
			//$('.showSrchDivCustomer').hide();
			$('.showSrchSite').hide();
			$('.showSrchBrand').hide();
			$('#srch_results_div').hide();
			$('#item_details').hide();
		}
	});	

	
		
		
		//$(".closeItemMdl").click(function(e) {$('#vw_srch_tbl').empty();fn_srch_results();});
	});
	
	
	
	
		
	
	$('#submitItemSearch').click(function(e){
		
		
		e.preventDefault();
		
		$("#srch_results_div").css("display","none");
	 	//var l = Ladda.create(this);
	 	//l.start();
		$('#item_details').hide();
		$('#vw_srch_tbl').empty();

		//fn_srch_results(l);
		fn_srch_results();
		//l.stop();
		return false;
	});
	
	
	function fn_srch_results()
	{
	
		var validateV = validateFormData('srch_form');
		
		
		if(validateV==true){
			var division_id = $( "#srch_division option:selected" ).val();
			//var customer_id = $( "#srch_customer option:selected" ).val();
			var customer_id ="";
			var site_id = $( "#srch_site option:selected" ).val();
			
			var catId = $( "#srch_category" ).val();
			var catNm = $( "#srch_category option:selected" ).text();
			var statusId = $( "#input_srch_status option:selected" ).val();
			//var itemNm = $( "#srch_brand option:selected" ).val() > 0  ? $( "#srch_brand option:selected" ).text() : "";
			var itemNm = $( "#srch_brand option:selected" ).text() == "Choose..."  ? "" : $( "#srch_brand option:selected" ).text();
			
			
			
			$('#srch_results_div').show();
			//var dataString = 'catId=' + catId + ' &catNm=' + catNm + '& statusId=' + statusId + '& itemNm=' + itemNm.trim()+ '& customer_id=' + customer_id+ '& site_id=' + site_id;
			var dataString = 'catId=' + catId + ' &catNm=' + catNm + '& statusId=' + statusId + '& itemNm=' + itemNm.trim()+ '& division_id=' + division_id+ '& site_id=' + site_id+ '& customer_id=' + customer_id;
			if(catId!==''){
				
				//alert(dataString);
				$.ajax({
					type: "POST",
					url: "get_search_tbl.php",
					data: dataString,
					async: false,
					success: function(data){
						$('#srch_results_div').show();
						$('#vw_srch_tbl').append(data);	
						//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
					},
					error: function() {
						$("#displaySrchCat").html('<div class="alert alert-secondary" role="alert">  Search Error...!! </div>');
						$("#displaySrchCat").fadeIn('slow').animate({opacity: 1.0}, 2500).fadeOut('slow');
						
					},
					complete: function() {} //END complete
				});
			}
		}
		//l.stop();
	}


	
</script>