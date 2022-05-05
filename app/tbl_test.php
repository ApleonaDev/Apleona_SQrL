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
              <header class="page-title-bar">
                <!-- .breadcrumb -->
                <nav aria-label="breadcrumb">
                
                </nav><!-- /.breadcrumb -->
                <!-- floating action -->
                <button type="button" class="btn btn-success btn-floated"><span class="fa fa-plus"></span></button> <!-- /floating action -->
                <!-- title and toolbar -->
                <div class="d-md-flex align-items-md-start">
                  <h1 class="page-title mr-sm-auto"> Test </h1><!-- .btn-toolbar -->
                  <div class="dt-buttons btn-group flex-wrap"> 
				  <button class="btn btn-secondary buttons-copy buttons-html5" tabindex="0" aria-controls="myTable" type="button"><span>Copy</span></button> <button class="btn btn-secondary buttons-print" tabindex="0" aria-controls="myTable" type="button"><span>Print</span></button> </div><!-- /.btn-toolbar -->
                </div><!-- /title and toolbar -->
              </header><!-- /.page-title-bar -->
              <!-- .page-section -->
              <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                 
                  <!-- .card-body -->
                  <div class="card-body">
                    <!-- .form-group -->
                    <div class="form-group">
                      <!-- .input-group -->
                      <div class="input-group input-group-alt">
                        <!-- .input-group-prepend -->
                        <div class="input-group-prepend">
                          <select id="filterBy" class="custom-select">
                            <option value="" selected=""> Filter By </option>
                            <option value="1"> Product </option>
                            <option value="2"> Inventory </option>
                            <option value="3"> Variants </option>
                            <option value="4"> Prices </option>
                            <option value="5"> Sales </option>
                          </select>
                        </div><!-- /.input-group-prepend -->
                        <!-- .input-group -->
                        <div class="input-group has-clearable">
                          <button id="clear-search" type="button" class="close" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times-circle"></i></span></button>
                          <div class="input-group-prepend">
                            <span class="input-group-text"><span class="oi oi-magnifying-glass"></span></span>
                          </div><input id="table-search" type="text" class="form-control" placeholder="Search products">
                        </div><!-- /.input-group -->
                      </div><!-- /.input-group -->
                    </div><!-- /.form-group -->
                    <!-- .table -->
        
					
					<div class="table-responsive">
					
					<table id="myTable" class="table dataTable no-footer" aria-describedby="myTable_info" role="grid">
                      <!-- thead -->
                      <thead>
                        <tr role="row"><th colspan="2" style="min-width: 320px;" rowspan="1">
                            <div class="thead-dd dropdown">
                              <span class="custom-control custom-control-nolabel custom-checkbox"><input type="checkbox" class="custom-control-input" id="check-handle"> <label class="custom-control-label" for="check-handle"></label></span>
                              <div class="thead-btn" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="fa fa-caret-down"></span>
                              </div>
                              <div class="dropdown-menu">
                                <div class="dropdown-arrow"></div><a class="dropdown-item" href="#">Select all</a> <a class="dropdown-item" href="#">Unselect all</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="#">Bulk remove</a> <a class="dropdown-item" href="#">Bulk edit</a> <a class="dropdown-item" href="#">Separate actions</a>
                              </div>
                            </div>
                          </th><th class="align-middle sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label=" Inventory : activate to sort column ascending"> Inventory </th><th class="align-middle sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label=" Variants : activate to sort column ascending"> Variants </th><th class="align-middle sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label=" Prices : activate to sort column ascending"> Prices </th><th class="align-middle sorting" tabindex="0" aria-controls="myTable" rowspan="1" colspan="1" aria-label=" Sales : activate to sort column ascending"> Sales </th><th style="width:100px; min-width:100px;" class="align-middle text-right sorting_disabled" rowspan="1" colspan="1" aria-label=" &amp;nbsp; "> &nbsp; </th></tr>
                      </thead><!-- /thead -->
                      <!-- tbody -->
                      <tbody>
                        <!-- create empty row to passing html validator -->
                        
                      <tr role="row" class="odd"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p598" value="598">
            <label class="custom-control-label" for="p598"></label>
          </div></td><td class="align-middle sorting_1"><a href="#598" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-5.jpg" alt="Card image cap">
          </a>
          <a href="#598">7up Diet, 355 Ml</a></td><td class=" align-middle">131</td><td class=" align-middle">6</td><td class=" align-middle">$31.51</td><td class=" align-middle">308</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#598"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#598"><i class="far fa-trash-alt"></i></a></td></tr>
		  <tr role="row" class="even"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p1000" value="1000">
            <label class="custom-control-label" for="p1000"></label>
          </div></td><td class="align-middle sorting_1"><a href="#1000" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-2.jpg" alt="Card image cap">
          </a>
          <a href="#1000">Alize Gold Passion</a></td><td class=" align-middle">405</td><td class=" align-middle">5</td><td class=" align-middle">$33.80</td><td class=" align-middle">1569</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#1000"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#1000"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="odd"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p564" value="564">
            <label class="custom-control-label" for="p564"></label>
          </div></td><td class="align-middle sorting_1"><a href="#564" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-2.jpg" alt="Card image cap">
          </a>
          <a href="#564">Alize Red Passion</a></td><td class=" align-middle">417</td><td class=" align-middle">2</td><td class=" align-middle">$20.38</td><td class=" align-middle">434</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#564"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#564"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="even"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p602" value="602">
            <label class="custom-control-label" for="p602"></label>
          </div></td><td class="align-middle sorting_1"><a href="#602" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-1.jpg" alt="Card image cap">
          </a>
          <a href="#602">Alize Red Passion</a></td><td class=" align-middle">454</td><td class=" align-middle">5</td><td class=" align-middle">$31.39</td><td class=" align-middle">583</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#602"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#602"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="odd"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p955" value="955">
            <label class="custom-control-label" for="p955"></label>
          </div></td><td class="align-middle sorting_1"><a href="#955" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-6.jpg" alt="Card image cap">
          </a>
          <a href="#955">Allspice - Jamaican</a></td><td class=" align-middle">481</td><td class=" align-middle">4</td><td class=" align-middle">$26.25</td><td class=" align-middle">348</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#955"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#955"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="even"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p349" value="349">
            <label class="custom-control-label" for="p349"></label>
          </div></td><td class="align-middle sorting_1"><a href="#349" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-3.jpg" alt="Card image cap">
          </a>
          <a href="#349">Almonds Ground Blanched</a></td><td class=" align-middle">447</td><td class=" align-middle">6</td><td class=" align-middle">$28.91</td><td class=" align-middle">512</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#349"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#349"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="odd"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p471" value="471">
            <label class="custom-control-label" for="p471"></label>
          </div></td><td class="align-middle sorting_1"><a href="#471" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-4.jpg" alt="Card image cap">
          </a>
          <a href="#471">Amarula Cream</a></td><td class=" align-middle">258</td><td class=" align-middle">5</td><td class=" align-middle">$30.98</td><td class=" align-middle">590</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#471"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#471"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="even"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p309" value="309">
            <label class="custom-control-label" for="p309"></label>
          </div></td><td class="align-middle sorting_1"><a href="#309" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-7.jpg" alt="Card image cap">
          </a>
          <a href="#309">Anchovy Fillets</a></td><td class=" align-middle">336</td><td class=" align-middle">5</td><td class=" align-middle">$26.09</td><td class=" align-middle">1405</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#309"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#309"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="odd"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p716" value="716">
            <label class="custom-control-label" for="p716"></label>
          </div></td><td class="align-middle sorting_1"><a href="#716" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-4.jpg" alt="Card image cap">
          </a>
          <a href="#716">Anchovy Fillets</a></td><td class=" align-middle">181</td><td class=" align-middle">4</td><td class=" align-middle">$20.84</td><td class=" align-middle">1052</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#716"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#716"><i class="far fa-trash-alt"></i></a></td></tr><tr role="row" class="even"><td class=" col-checker align-middle"><div class="custom-control custom-control-nolabel custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="selectedRow[]" id="p938" value="938">
            <label class="custom-control-label" for="p938"></label>
          </div></td><td class="align-middle sorting_1"><a href="#938" class="tile tile-img mr-1">
            <img class="img-fluid" src="assets/images/dummy/img-6.jpg" alt="Card image cap">
          </a>
          <a href="#938">Appetizer - Asian Shrimp Roll</a></td><td class=" align-middle">445</td><td class=" align-middle">5</td><td class=" align-middle">$22.45</td><td class=" align-middle">1485</td><td class=" align-middle text-right"><a class="btn btn-sm btn-icon btn-secondary" href="#938"><i class="fa fa-pencil-alt"></i></a>
          <a class="btn btn-sm btn-icon btn-secondary" href="#938"><i class="far fa-trash-alt"></i></a></td>
		  
		  </tr>
		  
		  </tbody><!-- /tbody -->
                    </table>
					
					
					</div>
					
					
					
					
                 

				 </div><!-- /.card-body -->
                </div><!-- /.card -->
               
                <!-- .card -->
               </div><!-- /.page-section -->
            </div>

</div>
  <!-- /.content-wrapper -->
	<!-- Main Footer -->
	 <?php //require('foot.php');
	 ?>

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


<script src="../assets/vendor/jquery/jquery.min.js"></script>

<script src="../assets/vendor/bootstrap/js/popper.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="../assets/vendor/pace/pace.min.js"></script>
<script src="../assets/vendor/stacked-menu/stacked-menu.min.js"></script>
<script src="../assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/datatables.buttons.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/buttons.html5.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/buttons.print.min.js"></script>

<script src="../assets/javascript/theme.min.js"></script>

<script src="../assets/javascript/pages/dataTables.bootstrap.js"></script>
<script src="../assets/javascript/pages/dataTables-demo.js"></script>





  
	
<script>

	$(document).ready(function() 
	{

		 var table = $('#myTable').DataTable();
		
		
		
	});

	
	






</script>

