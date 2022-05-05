<?php
require('../getSQL.php');

session_start(); 

if($_SESSION['SESS_USER_ID']){
	
	$quantity =0;
	$categoryid = $_POST["vCatId"];
	$iId = $_POST["vId"];
	$inm = $_POST["vNm"];
	$itype = $_POST["vType"];
	//$customer_id = $_POST["vCustId"];
	$div_id = $_POST["vDivId"];
	$vTblNm = $_POST["vTblNm"];
	$itypeS = substr(lcfirst($itype), 0, 1);

	$loc_img = "placeholder.png";
	
	if($itype == 'a'){
		$item_sql = "SELECT a.asset_status_id, a.asset_condition_id, a.id as asset_id, a.quantity, at.*, al.id as loc_id, al.site_map_img , al.site_id as site,al.building_id as build,al.floor_id as floor,al.room_id as room,al.area_id as area,al.rack_id as rack,al.shelf_id as shelf,al.crate_number  
		FROM asset_type as at LEFT JOIN asset_location as al ON (at.id = al.asset_type_id), assets a WHERE at.id = a.asset_type_id and at.id = '$iId'";
	}else if($itype == 'p'){
		$item_sql = "SELECT p.quantity,p.id as product_id, pt.*, pl.id as loc_id, pl.site_map_img, pl.site_id as site,pl.building_id as build,pl.floor_id as floor,pl.room_id as room,pl.area_id as area,pl.rack_id as rack,pl.shelf_id as shelf
		FROM product_type as pt  LEFT JOIN product_location as pl ON (pt.id = pl.product_type_id), `products` as p WHERE pt.id = p.product_type_id AND pt.id = '$iId'";
	}
	
	$disabled = '';	
	$userType = 6; // Default user type
	$userType = $_SESSION['SESS_USER_TYPE'];
	
	
	
	if (!empty($_POST["vId"])){
		
		
		
		
		try {
		$stmt = $conn->prepare($item_sql); 
		$stmt->execute(); 
		if ($stmt->rowCount()){
			while ($item_row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				//$locSH = is_null($item_row['locId']) ? "" : $item_row['locId'];
				
				//common
				$division_id = $item_row['division_id'];
				$custId = $item_row['customer_id'];
				
				$mid = is_null($item_row['maunufacturer_id']) ? "" : $item_row['maunufacturer_id'];
				$iDesc = $item_row['description'];
				$iBarcode = $item_row['barcode'];
				$iCost = $item_row['cost'];
				$iBNPrice = $item_row['buy_new_price'];
				$iSPrice = $item_row['selling_price'];
				$iASPrice = $item_row['alt_selling_price'];
				$iCurrency = $item_row['currency'];
				$quantity = is_null($item_row['quantity']) ? 0 : $item_row['quantity'];
				//Location
				$locId = $item_row['loc_id'];
				$site = $item_row['site'];
				$siteMap = $item_row['site_map_img'];
				$build = $item_row['build'];
				$floor = $item_row['floor'];
				$room = $item_row['room'];
				$area = $item_row['area'];
				$rack = $item_row['rack'];
				$shelf = $item_row['shelf'];
				$crateNo = $item_row['crate_number'];
				//asset
				
				$owner_id = is_null($item_row['owner_id']) ? "" : $item_row['owner_id'];
				$a_sid = is_null($item_row['asset_status_id']) ? 0 : $item_row['asset_status_id'];
				$a_cid = is_null($item_row['asset_condition_id']) ? 0 : $item_row['asset_condition_id'];
				$asset_id = is_null($item_row['asset_id']) ? 0 : $item_row['asset_id'];
				$iDiL = $item_row['dimensions'];
				$iFinish = $item_row['finish'];
				//product
				$vid = $item_row['vendor_id'];
				
				$product_id = is_null($item_row['product_id']) ? 0 : $item_row['product_id'];
				$iUAmt = is_null($item_row['unit_amount']) ? 0 : $item_row['unit_amount'];
				$iUnit = is_null($item_row['unit_id']) ? 0 : $item_row['unit_id'];
				
				$loc_img = is_null($item_row['site_map_img']) ? "placeholder.png" : $item_row['site_map_img'];
				//$loc_img = 'locationmap.png';
				
			}
		}
				
		$stmt = null; 
		}
		catch (PDOException $e) {	print $e->getMessage();	}
	
		
		//Set up User type access to edit inout fields
		
		/*
		
INSERT INTO `user_types` (`id`, `name`) VALUES
(0, 'Super Admin'),
(1, 'Country Manager'),
(2, 'Country Admin'),
(3, 'Customer Manager'),
(4, 'Site Admin'),
(5, 'Site Supervisor'),
(6, 'User'),
(7, 'Client');

		
		*/
		
		$disabled = 'DISABLED';
				
		$userTypeAccess = array(0,2,4);//Admin users
		if (in_array($userType, $userTypeAccess)) {
			
			$disabled_notadmin = '';
		}else{
			$disabled_notadmin = 'DISABLED';
			
		}
		
	}
	
	
	?>
	
	
	<form class="" name="item_form" id="item_form" method="POST" enctype="multipart/form-data">
	<input type="hidden" id="division_id" name="division_id" placeholder="" value="<?php echo $division_id;?>">
	<input type="hidden" id="customer_id" name="customer_id" placeholder="" value="<?php echo $custId;?>">
	
	<input type="hidden" id="calledfrom" name="calledfrom" placeholder="" value="<?php echo $vTblNm;?>">
	<input type="hidden" id="itypeS" name="itypeS" placeholder="" value="">
	<input type="hidden" id="iId" name="iId" placeholder="" value="<?php echo $iId;?>">
	<input type="hidden" id="assetId" name="assetId" placeholder="" value="<?php echo $asset_id;?>">
	<input type="hidden" id="productId" name="productId" placeholder="" value="<?php echo $product_id;?>">
	<input type="hidden" id="itype" name="itype" placeholder="" value="<?php echo $itype;?>">
	<input type="hidden" id="istatus" name="istatus" placeholder="" value="<?php echo $a_sid;?>">
	<input type="hidden" id="icondition" name="icondition" placeholder="" value="<?php echo $a_cid;?>">
	<input type="hidden" id="iCatId" name="iCatId" placeholder="" value="">
	
	<input type="hidden" id="icategoryid" name="icategoryid" placeholder="" value="<?php echo $categoryid;?>">
	<input type="hidden" id="isite_currency" name="isite_currency" placeholder="" value="<?php echo $iCurrency;?>">
	
	
	<input type="hidden" id="imanu_id" name="imanu_id" placeholder="" value="<?php echo $mid;?>">
	<input type="hidden" id="ivendor_id" name="ivendor_id" placeholder="" value="<?php echo $vid;?>">
	<input type="hidden" id="iowner_id" name="iowner_id" placeholder="" value="<?php echo $owner_id;?>">
	
	<input type="hidden" id="iLocId" name="iLocId" placeholder="" value="<?php echo $locId;?>">
	<input type="hidden" id="iSite" name="iSite" placeholder="" value="<?php echo $site;?>">
	<input type="hidden" id="iSiteImg" name="iSiteImg" placeholder="" value="<?php echo $siteMap;?>">
	<input type="hidden" id="iBld" name="iBld" placeholder="" value="<?php echo $build;?>">
	<input type="hidden" id="iFloor" name="iFloor" placeholder="" value="<?php echo $floor;?>">
	<input type="hidden" id="iRoom" name="iRoom" placeholder="" value="<?php echo $room;?>">
	<input type="hidden" id="iArea" name="iArea" placeholder="" value="<?php echo $area;?>">
	<input type="hidden" id="iRack" name="iRack" placeholder="" value="<?php echo $rack;?>">
	<input type="hidden" id="iShelf" name="iShelf" placeholder="" value="<?php echo $shelf;?>">
	<input type="hidden" id="ish_division" name="ish_division" value="">
	<input type="hidden" id="ish_customer" name="ish_customer" value="">
	<input type="hidden" id="ish_site" name="ish_site" value="">
	<input type="hidden" id="ish_bld" name="ish_bld" value="">
	<input type="hidden" id="ish_flr" name="ish_flr" value="">
	<input type="hidden" id="ish_room" name="ish_room" value="">
	<input type="hidden" id="ish_area" name="ish_area" value="">
	<input type="hidden" id="ish_rack" name="ish_rack" value="">
	<input type="hidden" id="ish_shelf" name="ish_shelf" value="">
	<fieldset>
	
	<!--
	<div class="col-12 col-lg-6 col-xl-8">
	
	-->
	<div class="card-deck-xl">

		<div class="card card-fluid">
		<!-- .card-header -->
		<div class="card-header">
		

					
		<ul class="nav nav-tabs card-header-tabs">
		
			<li class="nav-item">
			<a class="nav-link active show" data-toggle="tab" href="#what"><span class="oi oi-box"></span> What</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#who"><span class="oi oi-people"></span> Who</a>
			</li>
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#where"><span class="oi oi-map-marker"></span> Where</a>
			</li>
			
			<li class="nav-item tab-costings">
			<a class="nav-link" data-toggle="tab" href="#costs"><span class="oi oi-map-marker"></span> Costing</a>
			</li>
			

			
			<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#lifecycle"><span class="oi oi-loop-square"></span> Life Cycle</a>
			</li>
			

		</ul><!-- /.nav-tabs -->
		

		
		

		

		</div><!-- /.card-header -->
		<!-- .card-body -->
		<div class="card-body">
		<!-- .tab-content -->
		<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade active show" id="what">

			<div class="form-group">
			  <label class="col-form-label col-form-label-smX" for="division">Division <span class="badge badge-danger">Required</span></label> 
				
			  <?php
		
				$sqlx = "SELECT DISTINCT c.id, c.name, c.short_name FROM `division` as c , site as s, user_sites u WHERE c.`id` = s.customer_id AND s.id = u.site_id AND u.user_id = $_SESSION[SESS_USER_ID]  ORDER BY name";
				$sql = "SELECT DISTINCT c.id, c.name, c.short_name FROM `division` as c , site as s, user_sites u WHERE c.`id` = s.division_id AND s.id = u.site_id 
					AND u.user_id = $_SESSION[SESS_USER_ID]  ORDER BY name";
				try {
					$stmt = $conn->prepare($sql); 
					$stmt->execute(); 
					if ($stmt->rowCount()){
						
						//$rowCount = $stmt->rowCount();
						echo "<select $disabled class='form-control form-control-smX' id='division' name='division' >";
						echo "<option value='0'>Choose...</option>";
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$isSelected = "";
							$div_sh_nm = empty($row["short_name"]) ? "-" : trim($row["short_name"]);
							if($row[id] == $division_id ){$isSelected = "selected";}
							echo "<option data-divshnm=$div_sh_nm value=$row[id] ".$isSelected.">$row[name]</option>";
						}echo "</select>";
					}
						
				$stmt = null; }
				catch (PDOException $e) {
				print $e->getMessage();
				}
				?>
			  
			</div><!-- /.form-group -->
		
			
			<div class="showItemCat"></div>
			
			
			<div class="form-group category_div">
			  <label class="col-form-label col-form-label-smX" for="input_category">Category <span class="badge badge-danger">Required</span></label> 
				<select <?php echo $disabled;?> class='form-control form-control-smX showCategoryList' id='input_category' name='input_category' > <option value='0'>No options available</option> </select>
			</div><!-- /.form-group -->
		
			<div class="form-group item_div">
		  <label class="col-form-label col-form-label-smX" for="input_item_name">Item Name <span class="badge badge-danger">Required</span></label>  <!-- .input-group -->
		  <div class="input-group input-group-alt">
		  <select <?php echo $disabled_notadmin;?> class='form-control form-control-smX showNamesList editBrandName' id='input_item_name' name='input_item_name'> <option value='0'>No options available</option> </select>

			<div class="input-group-append input-group-append-smX">
			  <button class="btn btn-secondary addBrandName" type="button"><span class="oi oi-pencil"></span></button>
			</div>
		  </div><!-- /.input-group -->
		</div>
		
			<div class="form-group edit_brand_div" style="display:none">
			<div  class="edit_brand_div" >
			  <label class="col-form-label col-form-label-smX" for="input_item_nm">Add a name</label> 
			  <input type="text" class="form-control form-control-smX" aria-label="addbrand" id="inm" name="inm" value="<?php echo $inm;?>">
			  
			</div>
			</div><!-- /.form-group -->
		
			<div class="form-row item_div">
					<!-- grid column -->

					<div class="col-md-2 mb-3">
					  
						  <label for="input_item_quantity">Quantity</label> 
						  <input type="number" min="0" class="form-control " aria-label="quantity" id="input_item_quantity" name="input_item_quantity" value="<?php echo $quantity;?>">
						
					</div><!-- /grid column -->
					<!-- grid column -->
					<div class="col-md-5 mb-3">
					  <label for="input_item_cost">Unit Cost</label> 

						 <div class="input-group input-group-alt">
							<?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select <?php echo $disabled_notadmin;?> class="form-control col-4" id="input_item_currency" name="input_item_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
						  <input <?php echo $disabled_notadmin;?> type="number" min=0 class="form-control" id="input_item_cost" name="input_item_cost" value="<?php echo $iCost;?>">
							
						</div><!-- /.input-group -->
					</div><!-- /grid column -->
					<!-- grid column -->
					<div class="col-md-5 mb-3">
						<label class="text-primary" for="input_tc_value">Total Cost</label> 
					  <div class="input-group input-group-alt">
					  <?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select DISABLED class="form-control col-4 text-primary" id="input_tc_currency" name="input_tc_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
					   <input DISABLED type="number" min=0 class="form-control text-primary" id="input_tc_value" name="input_tc_value" value="<?php echo $iTC_Value;?>">
						</div>		
					</div><!-- /grid column -->

			</div>

		
			<div class="row item_div">
				
				<div class="col-sm">
				
				<div class="form-group product_div">
				  <label class="col-form-label col-form-label-smX" for="input_item_unit">Unit</label> 
				   <div class="input-group input-group-alt">
				    <?php
					$sql = "SELECT id, `type` FROM `unit` ORDER BY type";

					try {
						$stmt = $conn->prepare($sql); 
						$stmt->execute(); 
						if ($stmt->rowCount()){
							
							echo "<select $disabled_notadmin class='form-control form-control-smX' id='input_item_unit' name='input_item_unit'>";
							//
							if($iId==0){
								
								echo "<option value='0'>Choose...</option>";
							}
							
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								$isSelected = "";
								if($row[id] == $iUnit ){$isSelected = "selected";}	
								echo "<option value=$row[id] ".$isSelected.">$row[type]</option>";
							}echo "</select>";
						}
							
						$stmt = null; }
						catch (PDOException $e) {
						print $e->getMessage();
						}
					?>
					<input <?php echo $disabled_notadmin; ?> type="number" min=0 class="form-control form-control-smX" id="input_item_unit_amt" name="input_item_unit_amt" value="<?php echo $iUAmt;?>">
			 
				 
				   </div>
				  
				</div><!-- /.form-group -->
				
				
				
				
				</div>
			 </div>
					
			<div class="row asset_div">
				<div class="col-sm">
				 	<div class="form-group asset_div">
					  <label class="col-form-label col-form-label-smX" for="input_item_condition">Condition <span class="badge badge-danger">Required</span></label> 
						<select <?php echo $disabled_notadmin;?> class='form-control showConditionList' id='input_item_condition' name='input_item_condition' > <option value='0'>No options available</option> </select>
					</div><!-- /.form-group -->
				
			
				</div>
				
				<div class="col-sm">
					<div class="form-group asset_div">
					  <label class="col-form-label col-form-label-smX" for="input_item_status">Status <span class="badge badge-danger">Required</span></label> 
						<?php

						$sql = "SELECT id, `asset_status` FROM `asset_status` ORDER BY asset_status";

						try {
							$stmt = $conn->prepare($sql); 
							$stmt->execute(); 
							if ($stmt->rowCount()){
								
								echo "<select $disabled_notadmin class='form-control form-control-smX' id='input_item_status' name='input_item_status'>";
								echo "<option value='0'>Choose...</option>";
								while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
									$isSelected = "";
									if($row[id] == $a_sid ){$isSelected = "selected";}	
									echo "<option value=$row[id] ".$isSelected.">$row[asset_status]</option>";
								}echo "</select>";
							}
								
							$stmt = null; }
							catch (PDOException $e) {
							print $e->getMessage();
							}
							
						?>
					
					</div><!-- /.form-group -->
				</div>
			</div>
			
			<div class="row asset_div">
				<div class="col-sm">
				
					<div class="form-group asset_div">
					  <label class="col-form-label col-form-label-smX" for="input_item_dimensions">Dimensions </label> 
						<input <?php echo $disabled_notadmin;?> type="text" class="form-control form-control-smX" id="input_item_dimensions" name="input_item_dimensions" aria-label="Default" aria-describedby="input_item_dimensions" placeholder="L x W (x H)" value="<?php echo $iDiL; ?>">
					</div><!-- /.form-group -->
				</div>
				
				<div class="col-sm">
					<div class="form-group asset_div">
					  <label class="col-form-label col-form-label-smX" for="input_item_dimensions">Finish </label> 
						<input <?php echo $disabled_notadmin;?> type="text" class="form-control form-control-smX" id="input_item_finish" name="input_item_finish" aria-label="Default" aria-describedby="input_item_finish" value="<?php echo $iFinish; ?>">
					</div><!-- /.form-group -->
				</div>
			</div>
			
			<div class="form-group item_div">
			  <label class="col-form-label col-form-label-smX" for="input_item_desc">Description </label> 
				<textarea class="form-control form-control-sm" rows="1" id="input_item_desc" name="input_item_desc" aria-label="With textarea"><?php echo $iDesc;?></textarea>
			</div><!-- /.form-group -->
					
			<div class="form-group item_div">
			  <label class="col-form-label col-form-label-smX" for="item_barcode">Barcode </label> 
				<textarea <?php echo $disabled_notadmin; ?> class="form-control form-control-sm" rows="1" id="item_barcode" name="item_barcode" aria-label="With item_barcode"><?php echo $iBarcode;?></textarea>
			</div><!-- /.form-group -->
			
		</div>
		
		
		<div class="tab-pane fade" id="who">
		
			<div class="form-group division_div">
			  <label class="col-form-label col-form-label-smX" for="customer">Client <span class="badge badge-danger">Required</span></label> 
				<select <?php echo $disabled_notadmin;?> class='form-control form-control-smX showDivCustomer' id='customer' name='customer' > <option value='0'>No options available</option> </select>
			</div><!-- /.form-group -->
			<div class="form-group asset_div">
			  <label class="col-form-label col-form-label-smX" for="input_item_owner">Owner </label> 
				<select <?php echo $disabled_notadmin;?> class='form-control form-control-smX showOwnerList' id='input_item_owner' name='input_item_owner'> <option value='0'>No options available</option> </select>
			</div><!-- /.form-group -->
			
			<div class="form-group product_div">
			  <label class="col-form-label col-form-label-smX" for="input_item_vendor">Vendor <span class="badge badge-danger">Required</span></label> 
				<select <?php echo $disabled_notadmin;?> class='form-control form-control-smX showVendorList' id='input_item_vendor' name='input_item_vendor'> <option value='0'>No options available</option> </select>
			</div><!-- /.form-group -->

			<div class="form-group item_div">
			  <label class="col-form-label col-form-label-smX" for="input_item_manu">Manufacturer <span class="badge badge-danger">Required</span></label> 
				<select <?php echo $disabled_notadmin;?> class='form-control form-control-smX showManuList' id='input_item_manu' name='input_item_manu'> <option value='0'>No options available</option> </select>
			</div><!-- /.form-group -->
			<div class="form-group">
			
			
			
			<!-- Client -->
			<!--<div class="input-group input-group-smX mb-3 asset_div">
			  <div class="input-group-prepend">
				<label class="input-group-text" for="input_item_client">Client </label>
			  </div>
			  <select <?php echo $disabled_notadmin;?> class='custom-select showClientList' id='input_item_client' name='input_item_client'> <option value='0'>No options available</option> </select>
			</div>-->
				
		  	


			</div>
		</div>
		
		
		
		<div class="tab-pane fade" id="where">
			<div class="form-group division_div">
			<fieldset>
				<span class="showSite"></span>		
				<div class="showBld"></div>		
				<div class="showFloor"></div>		
				<div class="showRoom"></div>		
				<div class="showArea"></div>		
				<div class="showRack"></div>		
				<div class="showShelf"></div>
				
				<span class="" style="color:transparent" id="sh_customer" name="sh_customer"></span>
				<span class="" style="color:transparent" id="sh_division" name="sh_division"></span>
				
				
				<!--<img class="" src="images/<?php echo $loc_img;?>" data-locimg="<?php echo $loc_img;?>" name="loc_img" id="loc_img" alt="..." style="width:40%;height:40%;">-->
				<img style="display:none" class="showMapX" src="images/<?php echo $loc_img;?>" data-locimg="<?php echo $loc_img;?>" name="loc_img" id="loc_img" alt="..." width="180px">
			</fieldset>
			</div>
		</div>
		
		<div class="tab-pane fade " id="costs">
			<div style="" class="" role="group" aria-label="costing group">
		
				<div class="col-12">
				<div class="asset_div">

					<div class="form-row">
					<!-- grid column -->

					<div class="col-md-6 mb-3">
					  <label for="input_selling_price">Unit Selling Price</label> 

						 <div class="input-group input-group-alt">
							<?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select <?php echo $disabled_notadmin;?> class="form-control col-3" id="input_sp_currency" name="input_sp_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
						  <input <?php echo $disabled_notadmin;?> type="number" min=0 class="form-control" id="input_selling_price" name="input_selling_price" value="<?php echo $iSPrice;?>">
							
						</div><!-- /.input-group -->
					</div><!-- /grid column -->
					<!-- grid column -->
					<div class="col-md-6 mb-3">
						<label class="text-primary" for="input_sp_value">Stock Value</label> 
					  <div class="input-group input-group-alt">
					  <?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select DISABLED class="form-control col-3 text-primary" id="input_spv_currency" name="input_spv_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
					   <input DISABLED type="number" min=0 class="form-control text-primary" id="input_sp_value" name="input_sp_value" value="<?php echo $iSP_Value;?>">
						</div>		
					</div><!-- /grid column -->

					</div>

					
					<div class="form-row">
					<!-- grid column -->

					<div class="col-md-6 mb-3">
					  <label for="input_alt_selling_price">Alt Selling Price</label> 

						 <div class="input-group input-group-alt">
							<?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select <?php echo $disabled_notadmin;?> class="form-control col-3" id="input_asp_currency" name="input_asp_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
						  <input <?php echo $disabled_notadmin;?> type="number" min=0 class="form-control" id="input_alt_selling_price" name="input_alt_selling_price" value="<?php echo $iASPrice;?>">
							
						</div><!-- /.input-group -->
					</div><!-- /grid column -->
					<div class="col-md-6 mb-3">
						<label class="text-primary" for="input_asp_value">Alt Stock Value</label> 
					  <div class="input-group input-group-alt">
					  <?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select DISABLED class="form-control col-3 text-primary" id="input_aspv_currency" name="input_aspv_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
					   <input DISABLED type="number" min=0 class="form-control text-primary" id="input_asp_value" name="input_asp_value" value="<?php echo $iASP_Value;?>">
						</div>		
					</div><!-- /grid column -->
					</div>
					
					<div class="form-row">
					<!-- grid column -->

					<div class="col-md-6 mb-3">
					  <label for="input_bn_price">'Buy New' Price</label> 

						 <div class="input-group input-group-alt">
							<?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select <?php echo $disabled_notadmin;?> class="form-control col-3 val-currency" id="input_bn_currency" name="input_bn_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
						  <input <?php echo $disabled_notadmin;?> type="number" min=0 class="form-control" id="input_bn_price" name="input_bn_price" value="<?php echo $iBNPrice;?>">
							
						</div><!-- /.input-group -->
					</div><!-- /grid column -->
					<div class="col-md-6 mb-3">
						<label class="text-primary" for="input_bn_value">'Buy New' Value</label> 
					  <div class="input-group input-group-alt">
					  <?php 
						   $StgSelected = "";
						   $EuroSelected = "selected";
						   
						   if($iCurrency == 2 ){$StgSelected = "selected";$EuroSelected = "";}
						   ?>
						   <select DISABLED class="form-control col-3 text-primary val-currency" id="input_bnv_currency" name="input_bnv_currency">
								<option value=1 <?php echo $EuroSelected;?>> &euro;</option>
								<option value=2 <?php echo $StgSelected;?>> &pound;</option>
						  </select>
					   <input DISABLED type="number" min=0 class="form-control text-primary" id="input_bn_value" name="input_bn_value" value="<?php echo $iBN_Value;?>">
						</div>		
					</div><!-- /grid column -->
					</div>
				</div><!-- /.asset div -->
				</div><!-- /.col -->

			</div>
		
		</div>
		
		<div class="tab-pane fade " id="lifecycle">
			<div style="" class="" role="group" aria-label="First group">
			  
			  <?php
				if($iId>0){
					
			  ?>
				<button type="button" class="btn btn-secondary openLifeCycle asset_div" >Life Cycle</button>
			<?php
			
				}
			?>
		
		
			</div>
		
		</div>
		
		</div><!-- /.tab-content -->
		
		
		</div><!-- /.card-body -->
		
		<div class="card-footer">
		<div class="form-group" style="margin:15px">
		<button type="button" id="submitItemSave" class="btn btn-primary"> 
		<span class="oi oi-data-transfer-upload"> </span> Save</button>
		
		</div><!-- /.form-group -->	
		
		<span id="errSaveitemX"></span>
		
		</div>
		 <div class="card-footer"><span id="errSaveitem"></span></div>
		</div><!-- /.card -->



	<!-- .card -->
	</div>
	
	
	</fieldset>
	</form>
	

 
	<?php
}else{
	
	//echo "no session";
	//header("location: ../login-idErr.php");
	header("location: ../sqrl_login.php");
	exit();

}


?>

<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/javascript/sqrl_valid.js"></script>
<script src="../assets/javascript/sqrl_search.js"></script>
<script src="../assets/javascript/sqrl_item.js"></script>
<script src="../assets/javascript/sqrl_loc.js"></script>

<script>


	$(document).ready(function() {
		
		$("#submitItemSave").click(function(e) {
			e.preventDefault();
			var retId=0;
			var iId = $( "#iId" ).val();
			
			//alert('Crate: '+ document.getElementById('input_crate_number').value );
			retId = saveItemDetails(iId);
			
			//alert('returned id to refresh: '+retId);
			
			
			if(retId==0){return false;}
			if(iId>0){return false;}
			document.getElementById('iId').value = retId;
			
			//calledfrom
			var calledfrom = document.getElementById('calledfrom').value;
			//alert('calledfrom; '+calledfrom);
			if(calledfrom=='get_search_tbl'){$('#vw_srch_tbl').empty();fn_srch_results();}
			if(calledfrom=='rpt_results_tbl'){$('#vw_site_rpt_tbl').empty();fn_view_report();}
		
		
			
			
			
			/*var l = Ladda.create(this);
			l.start();
			l.stop();
			//alert('Saved: id is '+iId);
			//alert('Saved: val '+retId);
			*/
		});
	
	
		if(document.getElementById('division').value==0){
			
			$('.division_div').hide();
			$('.category_div').hide();
			$('.item_div').hide();
			$('.crate_div').hide();
			$('.showMap').hide();
			$('.asset_div').hide();
			$('.product_div').hide();
			$('.tab-costings').hide();
		}else {
			
			
			$('.division_div').show();
			$('.category_div').show();
			$('.item_div').show();
			var arrUserTypes = [0,2,4];
			var iId = $('#iId').val();
			var userIdType = "<?php echo $_SESSION['SESS_USER_TYPE']; ?>";
			
			getCategoryList('<?php echo $division_id;?>', '<?php echo $categoryid;?>','<?php echo $itypeS;?>' );
			getCategoryType('<?php echo $itypeS;?>');
			tabCostings(userIdType, '<?php echo $itypeS;?>');
			getValueAnalysis();
			getCategoryBrands('<?php echo $itypeS;?>','<?php echo $division_id;?>', '<?php echo $categoryid;?>');
			getDivisionConditions();

			getDivisionCustomers('<?php echo $custId;?>');
			getDivisionOwners('<?php echo $owner_id;?>');
			getDivisionManufacturers();
			getVendors('<?php echo $division_id;?>');

			initLocationData('<?php echo $division_id;?>');
			
			
			if (iId>0 && arrUserTypes.indexOf(Number(userIdType)) < -1){
				$('.addBrandName').hide();
			}else{
				$('.addBrandName').show();
			}
		
		}
	
		$( "#input_item_name" ).change(function(e) { 
			var brandv = $( "#input_item_name option:selected" ).text();
			document.getElementById('inm').value  = brandv;
		});
	
	});

	$(".addBrandName").click(function(e) {
		
		var arrUserTypes = [0,2,4];
		var category_id = $( "#input_category option:selected" ).val();
		var iId = $( "#iId" ).val();
		var userIdType = "<?php echo $_SESSION['SESS_USER_TYPE']; ?>";
		
		
		if (iId>0 && arrUserTypes.indexOf(Number(userIdType)) < -1){	

			$('.edit_brand_div').hide();
			//addBrandName
		}else{
			
			if (category_id == null || category_id == 0 ){
			
				$('.edit_brand_div').hide();
			}else{
				$('.edit_brand_div').show();
			
			}
		}
		
		
		
			
	});

	$('#division').on('change',function(){
		
		var userId = "<?php echo $_SESSION['SESS_USER_ID']; ?>";
		var divshnm = $( "#division option:selected" ).data('divshnm');
			
		document.getElementById('sh_division').innerHTML  = divshnm;
		document.getElementById('ish_division').value  = divshnm;

		//getCategoryList(this.value, 0,'' );
		//if(this.value==0){}	
		
		document.getElementById('customer').value =0;
		$('.category_div').hide();
		$('.item_div').hide();
		$('.showMap').hide();
		$('.asset_div').hide();
		$('.product_div').hide();
		$('.tab-costings').hide();
		$('.showSite').hide();	
		$('.showBld').hide();	
		$('.showFloor').hide();
		$('.showRoom').hide();
		
		$('.showArea').hide();
		$('.showRack').hide();
		$('.showShelf').hide();
		$('.showMap').hide();
		/*
		getSite(0);
		getBld(0);
		getFloor(0);
		getRoom(0);
		getArea(0);
		getRack(0);
		getShelf(0);*/
		if(document.getElementById('division').value>0){
			
			$('.division_div').show();
			$('.customer_div').show();
			$('.category_div').show();
			
			getCategoryList(document.getElementById('division').value, 0,'' );
			getCategoryType('<?php echo $itypeS;?>');
			//tabCostings(userIdType, '<?php echo $itypeS;?>');
			getDivisionCustomers(document.getElementById('customer').value);
			getDivisionOwners(0);
			getDivisionManufacturers();
			getVendors(document.getElementById('division').value);
			getDivisionConditions();
			
			
			initLocationData(document.getElementById('division').value);
		}else {
			$('.division_div').hide();
			$('.category_div').hide();
			$('.item_div').hide();
			$('.showMap').hide();
			$('.asset_div').hide();
			$('.product_div').hide();
			$('.tab-costings').hide();
		}
	});	
		
	$('#customer').on('change',function(){
		
		var userId = "<?php echo $_SESSION['SESS_USER_ID']; ?>";
		var custshnm = $( "#customer option:selected" ).data('custshnm');
		document.getElementById('sh_customer').innerHTML  = custshnm;
		document.getElementById('ish_customer').value  = custshnm;

		
	});	

	$('#input_category').on('change',function(){
		
		if(document.getElementById('input_category').value!==''){
			
			getCategoryType(document.getElementById('input_category').value);
			//getupdtCategoryBrands(itypeS);
			
			
			tabCostings("<?php echo $_SESSION['SESS_USER_TYPE']; ?>", document.getElementById('itypeS').value);
			
			
			getCategoryBrands(document.getElementById('itypeS').value,document.getElementById('division').value, document.getElementById('iCatId').value);
			getDivisionConditions();
			$('.item_div').show();
			$('.showMap').show();

			
			
		}else{
			
			$('.category_div').hide();
			$('.item_div').hide();
			$('.showMap').hide();
			$('.asset_div').hide();
			$('.product_div').hide();
			$('.tab-costings').hide();
			
		}
		
	});
	
	
	
	$('#input_item_quantity').on('change',function(){getValueAnalysis();});	
	$('#input_item_cost').on('change',function(){getValueAnalysis();});	
	$('#input_selling_price').on('change',function(){getValueAnalysis();});	
	$('#input_alt_selling_price').on('change',function(){getValueAnalysis();});	
	$('#input_bn_price').on('change',function(){getValueAnalysis();});	
	
	$('#input_item_currency').on('change',function(){setCurrency(this.value);});	
	$('#input_sp_currency').on('change',function(){setCurrency(this.value);});	
	$('#input_asp_currency').on('change',function(){setCurrency(this.value);});	
	$('#input_bn_currency').on('change',function(){setCurrency(this.value);});	
	
</script>