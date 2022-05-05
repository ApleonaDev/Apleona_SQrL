 <?php 	
session_start(); 

if($_SESSION['SESS_USER_ID']){
	
	require('head.php');
	include('aside_index.php');

	//Connect to server
	require('../getSQL.php');
	
	
?>

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
                    <span class="font-weight-bold">Hey, <?php echo $_SESSION['SESS_USER_NAME']; ?>.</span> <span class="d-block text-muted">Create New Item</span>
                  </p>
                  <div class="ml-auto">
                  </div>
                </div>
              </header> -->
			  <!-- /.page-title-bar -->
	<?php
	include('search_content.php');
	?>
	
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


});
</script>