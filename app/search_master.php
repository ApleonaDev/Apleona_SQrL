 <?php 	
session_start(); 

if($_SESSION['SESS_USER_ID']){
	
	require('head.php');
	include('aside_srch_master.php');

	//Connect to server
	require('../getSQL.php');
	//Get customer and site list available to user
	//If user type is super admin then select all sites : 0, 1, 2
	//else 
		//type 3: sees all customer sites
		//type 4, 5, 6, 7: see only site information
		
	$qry_sites="SELECT * FROM user_sites WHERE user_id='".$_SESSION['SESS_USER_ID']."'";

?>
<!-- .page-section -->
		<form class="form-horizontal" name="srch_form" id="srch_form" method="POST" enctype="multipart/form-data" action="" >
		<input type="hidden" id="session_user" name="session_user" placeholder="" value="<?php echo $_SESSION['SESS_USER_NAME'];?>">
		<input type="hidden" id="srchCustId" name="srchCustId" value="">
			<div class="page-section">

			<div class="container-fluid py-3">
			<h1 class="page-title"> Master-details </h1>
			<p class="text-muted"> Your list items goes here. </p><button class="btn btn-danger btn-floated d-lg-none" type="button" data-toggle="sidebar"><i class="fa fa-th-list"></i></button>
			

			
			</div>
			<div class="aside-content">
		
		  
         
        </div><!-- /.aside-content -->
			<div class="row">
                  <!-- grid column -->
                  <div class="col-12 col-xl-4 overflow-hidden" style="background:red">
                    12345678901234567890qwertyuiipp12345678901234567890qwertyuiipp12345678901234567890qwertyuiipp12345678901234567890qwertyuiipp12345678901234567890qwertyuiipp12345678901234567890qwertyuiipp12345678901234567890qwertyuiipp
                    
                  </div><!-- /grid column -->
                  <!-- grid column -->
                 
                  
             </div>

			<div id="base-style" class="card container-fluid py-3 overflow-hidden">
			<!-- .card-body -->
			<div class="card-body">
			<!-- .form -->
			
			  <!-- .fieldset -->
			  <fieldset>
				<legend>Base style</legend> <!-- .form-group -->
				<div class="form-group">
				  <label for="tf1">Email address</label> <input type="email" class="form-control" id="tf1" aria-describedby="tf1Help" placeholder="e.g. johndoe@looper.com"> <small id="tf1Help" class="form-text text-muted">We'll never share your email with anyone else.</small>
				</div><!-- /.form-group -->
				<!-- .form-group -->
				<div class="form-group">
				  <label for="tf2">Number input</label>
				  <div class="custom-number">
					<input type="number" class="form-control" id="tf2" min="0" max="10" step="1" value="0" placeholder="Amount (to the nearest dollar)">
				  <div class="custom-number-controls"><div class="custom-number-btn custom-number-up">+</div><div class="custom-number-btn custom-number-down">-</div></div></div>
				</div><!-- /.form-group -->
				<!-- .form-group -->
				
				
			   
			  </fieldset><!-- /.fieldset -->
			
			</div><!-- /.card-body -->
			<!-- .card-body -->


			</div>
			</div><!-- /.page-section -->
       
        </form>  
	 <!-- .page-sidebar -->
	<div class="page-sidebar">
	  <!-- .sidebar-header -->
	  <header class="sidebar-header d-xl-none">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item active">
			  <a href="#" onclick="Looper.toggleSidebar()"><i class="breadcrumb-icon fa fa-angle-left mr-2"></i>Back</a>
			</li>
		  </ol>
		</nav>
	  </header><!-- /.sidebar-header -->
	  <!-- .sidebar-section -->
	  <div class="sidebar-section">
		<div class="alert alert-info"> This layout is the best fit for working through a queue of items. It allow your users to stay on the same screen while viewing or editing data. </div>
	  </div><!-- /.sidebar-section -->
	</div><!-- /.page-sidebar -->
	
	
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
<script src="../assets/javascript/sqrl_valid.js"></script>
<script src="../assets/javascript/sqrl_search.js"></script>
<script src="../assets/javascript/sqrl_item.js"></script>
<script>

	$(document).ready(function() 
	{

		$('#srch_customer').on('change',function(){
			
			$('#vw_srch_tbl').empty();
			$('.asset_div').hide();
			$('.product_div').hide();
			$('.showSrchSite').hide();
			$('.showSrchBrand').hide();
			var userId = "<?php echo $_SESSION['SESS_USER_ID']; ?>";
			//alert('here');
			getSrchSite(userId);
			getSrchCategory();
		});	
		
		
		
		//$(".closeItemMdl").click(function(e) {$('#vw_srch_tbl').empty();fn_srch_results();});
	});
	
	
	
	$('#submitItemSearch').click(function(e){
		
		
		e.preventDefault();
		
		$("#srch_results_div").css("display","none");
	 	//var l = Ladda.create(this);
	 	//l.start();
		$('#vw_srch_tbl').empty();

		//fn_srch_results(l);
		fn_srch_results();
		//l.stop();
		return false;
	});
	
	
	function fn_srch_results(){
	
		var validateV = validateFormData('srch_form');
		
		
		if(validateV==true){
			var customer_id = $( "#srch_customer option:selected" ).val();
			var site_id = $( "#srch_site option:selected" ).val();
			
			var catId = $( "#srch_category" ).val();
			var catNm = $( "#srch_category option:selected" ).text();
			var statusId = $( "#input_srch_status option:selected" ).val();
			//var itemNm = $( "#srch_brand option:selected" ).val() > 0  ? $( "#srch_brand option:selected" ).text() : "";
			var itemNm = $( "#srch_brand option:selected" ).text() == "Choose..."  ? "" : $( "#srch_brand option:selected" ).text();
			
			
			
			$('#srch_results_div').show();
			var dataString = 'catId=' + catId + ' &catNm=' + catNm + '& statusId=' + statusId + '& itemNm=' + itemNm.trim()+ '& customer_id=' + customer_id+ '& site_id=' + site_id;
			if(catId!==''){
				
				//alert(dataString);
				$.ajax({
					type: "POST",
					url: "get_search_tbl.php",
					data: dataString,
					async: false,
					success: function(data){
						
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