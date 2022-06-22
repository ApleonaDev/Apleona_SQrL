<?php 	

// Load Config
require_once '../config.php';

// Load Firebase
require_once '../vendor/firebase/php-jwt/src/JWT.php';
require_once '../vendor/firebase/php-jwt/src/Key.php';
require_once '../vendor/firebase/php-jwt/src/SignatureInvalidException.php';
require_once '../vendor/firebase/php-jwt/src/ExpiredException.php';
require_once '../vendor/firebase/php-jwt/src/BeforeValidException.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();

if(strpos($_SERVER['REQUEST_URI'], "/Apleona_SQrL/app/index.php?token=")!==false){

  $url = URLLOGINROOT;
  $data = array($_GET['token']);

  // use key 'http' even if you send the request to https://...
  $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
      )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);


  $decodedToken = JWT::decode($_GET['token'], new Key(JWT_KEY, 'HS256'));
  $user_details = $decodedToken->user_details;

  $user_id = 1;
  $name = $user_details->name;
  $user_type = $user_details->user_type;

  $_SESSION['SESS_USER_ID'] = $user_id;
  $_SESSION['SESS_USER_TYPE'] = (int) $user_type;
  $_SESSION['SESS_USER_NAME'] = $name;

  header("location: index.php");

}

session_start(); 
$userType = $_SESSION['SESS_USER_TYPE'];
$userNm = $_SESSION['SESS_USER_NAME'];
$userId = $_SESSION['SESS_USER_ID'];


if($_SESSION['SESS_USER_ID']){
	
	require('head.php');
	include('aside_index.php');
?>
<main class="app-main">
        <!-- .wrapper -->
        <div class="wrapper">
          <!-- .page -->
          <div class="page">
             <div class="page-inner">
              <!-- .page-title-bar -->
              <header class="page-title-bar">
                <div class="d-flex flex-column flex-md-row">
                  <p class="lead">
                    <span class="font-weight-bold">Hey, <?php echo $_SESSION['SESS_USER_NAME']; ?>.</span> <span class="d-block text-muted">Whatup?</span>
                  </p>
                  <div class="ml-auto">
                  </div>
                </div>
              </header><!-- /.page-title-bar -->

<!-- .page-inner -->
           
              <!-- .page-section -->
              <div class="page-section">
                <!-- .section-block -->
                <div class="section-block">
                  <!-- metric row -->
                  <div class="metric-row">
                    <div class="col-lg-9">
                      <div class="metric-row metric-flush">
                        <!-- metric column -->
                        <div class="col">
                          <!-- .metric -->
                          <a href="user-teams.html" class="metric metric-bordered align-items-center">
                            <h2 class="metric-label"> Assets </h2>
                            <p class="metric-value h3">
                              <sub><i class="oi oi-people"></i></sub> <span class="value">8</span>
                            </p>
                          </a> <!-- /.metric -->
                        </div><!-- /metric column -->
                        <!-- metric column -->
                        <div class="col">
                          <!-- .metric -->
                          <a href="user-projects.html" class="metric metric-bordered align-items-center">
                            <h2 class="metric-label"> Products </h2>
                            <p class="metric-value h3">
                              <sub><i class="oi oi-fork"></i></sub> <span class="value">12</span>
                            </p>
                          </a> <!-- /.metric -->
                        </div><!-- /metric column -->
                        <!-- metric column -->
                        <div class="col">
                          <!-- .metric -->
                          <a href="user-tasks.html" class="metric metric-bordered align-items-center">
                            <h2 class="metric-label"> Active Items </h2>
                            <p class="metric-value h3">
                              <sub><i class="fa fa-tasks"></i></sub> <span class="value">64</span>
                            </p>
                          </a> <!-- /.metric -->
                        </div><!-- /metric column -->
                      </div>
                    </div><!-- metric column -->
                   
                  </div><!-- /metric row -->
                </div><!-- /.section-block -->
                <!-- grid row -->
                <div class="row">
                  <!-- grid column -->
                  <div class="col-12 col-lg-12 col-xl-4">
                    <!-- .card -->
                    <div class="card card-fluid">
                      <!-- .card-body -->
                      <div class="card-body">
                        <h3 class="card-title mb-4"> Overview of Items... </h3>
                        <div class="chartjs" style="height: 292px">
                          <canvas id="completion-tasks"></canvas>
                        </div>
                      </div><!-- /.card-body -->
                    </div><!-- /.card -->
                  </div><!-- /grid column -->
                  <!-- grid column -->
                  <div class="col-12 col-lg-6 col-xl-4">
                    <!-- .card -->
                    <div class="card card-fluid">
                      <!-- .card-body -->
                      <div class="card-body">
                        <h3 class="card-title"> Tasks Performance </h3><!-- easy-pie-chart -->
                        <div class="text-center pt-3">
                          <div class="chart-inline-group" style="height:214px">
                            <div class="easypiechart" data-toggle="easypiechart" data-percent="60" data-size="214" data-bar-color="#346CB0" data-track-color="false" data-scale-color="false" data-rotate="225"></div>
                            <div class="easypiechart" data-toggle="easypiechart" data-percent="50" data-size="174" data-bar-color="#00A28A" data-track-color="false" data-scale-color="false" data-rotate="225"></div>
                            <div class="easypiechart" data-toggle="easypiechart" data-percent="75" data-size="134" data-bar-color="#5F4B8B" data-track-color="false" data-scale-color="false" data-rotate="225"></div>
                          </div>
                        </div><!-- /easy-pie-chart -->
                      </div><!-- /.card-body -->
                      <!-- .card-footer -->
                      <div class="card-footer">
                        <div class="card-footer-item">
                          <i class="fa fa-fw fa-circle text-indigo"></i> 100% <div class="text-muted small"> Assigned </div>
                        </div>
                        <div class="card-footer-item">
                          <i class="fa fa-fw fa-circle text-purple"></i> 75% <div class="text-muted small"> Completed </div>
                        </div>
                        <div class="card-footer-item">
                          <i class="fa fa-fw fa-circle text-teal"></i> 60% <div class="text-muted small"> Active </div>
                        </div>
                      </div><!-- /.card-footer -->
                    </div><!-- /.card -->
                  </div><!-- /grid column -->
                  <!-- grid column -->
                  <div class="col-12 col-lg-6 col-xl-4">
                    <!-- .card -->
                  </div><!-- /grid column -->
                </div><!-- /grid row -->
              </div><!-- /.page-section -->
          
          
		  
		  
		  
	<?php include('foot.php') ?>


<?php
	
}else{
	
	echo "no session";
	//header("location: ../login-idErr.php");
	exit();

}


?>

