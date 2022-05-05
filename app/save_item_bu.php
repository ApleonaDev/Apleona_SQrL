<?php

require('../getSQL.php');
//session_start();


$categoryType = trim($_POST["input_item_category"]);
$item_id = 0;
$asset_id = 0;
$inm = empty($_POST["inm"]) ? "" : trim($_POST["inm"]);	
$iCost = empty($_POST["input_item_cost"]) ? "0" : trim($_POST["input_item_cost"]);	
$iUnitAmt = empty($_POST["input_item_unit_amt"]) ? "0" : trim($_POST["input_item_unit_amt"]);	
$iId = trim($_POST["iId"]);
$itype = trim($_POST["itypeS"]);

$iQty = empty($_POST["input_item_quantity"]) ? 0 : $_POST["input_item_quantity"];
//$iQty = strlen($_POST["input_item_quantity"]) < 1  : 0 ? $_POST["input_item_quantity"];

$iSite = empty($_POST["site"]) ? "0" : $_POST["site"];
$iBuild = empty($_POST["build"]) ? "0" : $_POST["build"];
$iFloor = empty($_POST["floor"]) ? "0" : $_POST["floor"];
$iRoom = empty($_POST["room"]) ? "0" : $_POST["room"];
$iArea = empty($_POST["area"]) ? "0" : $_POST["area"];
$iRack = empty($_POST["rack"]) ? "0" : $_POST["rack"];
$iShelf = empty($_POST["shelf"]) ? "0" : $_POST["shelf"];
//$iLoc_sh = $_POST["ish_customer"].'-'.$_POST["ish_site"].'-'.$_POST["ish_bld"].'-'.$_POST["ish_flr"].'-'.$_POST["ish_room"].'-'.$_POST["ish_area"].'-'.$_POST["ish_rack"].'-'.$_POST["ish_shelf"];
$iLoc_sh = $_POST["ish_bld"].'-'.$_POST["ish_flr"].'-'.$_POST["ish_room"].'-'.$_POST["ish_area"].'-'.$_POST["ish_rack"].'-'.$_POST["ish_shelf"];
$iLocId = empty($_POST["iLocId"]) ? "0" : $_POST["iLocId"];

$iLocImgX = empty($_POST["loc_img"]) ? "placeholder.png" : $_POST["loc_img"];
$iLocImg = empty($_POST["iSiteImg"]) ? "" : $_POST["iSiteImg"];
				
if ($iId){
	//UPDATE record
	if($itype=='a'){//Update Asset type details
		//$update_type = "UPDATE asset_type SET description=:iDesc,finish=:iFinish,dimensions=:iDimensions,cost=:iCost,currency=:iCurrency,vendor_id=:iVendorId,`maunufacturer_id`=:iManuId WHERE id = :iId;";
		$update_type = "UPDATE asset_type SET description=:iDesc,finish=:iFinish,dimensions=:iDimensions,cost=:iCost,currency=:iCurrency,maunufacturer_id=:iManuId,owner_id=:iCltId,`name`=:iName,`barcode`=:iBarcode WHERE id = :iId;";
		try {
			$stmt = $conn->prepare($update_type);     
				$stmt->bindParam(':iDesc',trim($_POST['input_item_desc']), PDO::PARAM_STR);
				$stmt->bindParam(':iFinish', trim($_POST['input_item_finish']), PDO::PARAM_STR);
				$stmt->bindParam(':iDimensions', trim($_POST['input_item_dimensions']), PDO::PARAM_STR);
				$stmt->bindParam(':iCost', $iCost, PDO::PARAM_STR);
				$stmt->bindParam(':iCurrency', trim($_POST['input_item_currency']), PDO::PARAM_STR);
				$stmt->bindParam(':iName',trim($_POST['inm']), PDO::PARAM_STR);
				$stmt->bindParam(':iBarcode',trim($_POST['item_barcode']), PDO::PARAM_STR);
				//$stmt->bindParam(':iVendorId', $_POST['input_item_vendor'], PDO::PARAM_INT);
				$stmt->bindParam(':iManuId', $_POST['input_item_manu'], PDO::PARAM_INT);
				$stmt->bindParam(':iCltId', $_POST['input_item_owner'], PDO::PARAM_INT);
				$stmt->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);

				$stmt->execute();
				if($stmt){
					//echo 'Saved: ';
				}else{echo 'Error occurred updating asset type!';}
				$stmt = null;
		} catch (PDOException $e) {
			print $e->getMessage();
		}		
		
		//Update Asset table - condition and Status
		$update_asset = "UPDATE assets SET asset_condition_id=:iConditionId,asset_status_id=:iStatusId ,quantity=:iQuantity WHERE id =:assetId AND asset_type_id = :iId";
		try {
			$stmt2 = $conn->prepare($update_asset);     
				$stmt2->bindParam(':iConditionId', $_POST['input_item_condition'], PDO::PARAM_INT);
				$stmt2->bindParam(':iStatusId', $_POST['input_item_status'], PDO::PARAM_INT);
				$stmt2->bindParam(':assetId', $_POST['assetId'], PDO::PARAM_INT);
				$stmt2->bindParam(':iQuantity', $iQty, PDO::PARAM_STR);
				$stmt2->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);
				$stmt2->execute();
				if($stmt2){
					//echo 'Saved: ';
				}else{echo 'Error occurred updating asset!';}
		
				$stmt2 = null;
		
		} catch (PDOException $e) {
			print $e->getMessage();
		}	
		
		//Update Asset Loc Details
		$update_loc = "UPDATE asset_location SET loc_code=:iLocCode,site_id=:iSiteId,site_map_img=:iLocMap,building_id=:iBldId,floor_id=:iFloorId,room_id=:iRoomId,area_id=:iAreaId,rack_id=:iRackId,shelf_id=:iShelfId WHERE id =:locId AND asset_id =:assetId AND asset_type_id = :iId";
		try {
			$stmtLoc = $conn->prepare($update_loc);     
				$stmtLoc->bindParam(':iLocCode', $iLoc_sh, PDO::PARAM_STR);
				$stmtLoc->bindParam(':iLocMap', $iLocImg, PDO::PARAM_STR);
				$stmtLoc->bindParam(':iSiteId', $iSite, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iBldId', $iBuild, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iFloorId', $iFloor, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iRoomId', $iRoom, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iAreaId', $iArea, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iRackId', $iRack, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iShelfId', $iShelf, PDO::PARAM_INT);
				$stmtLoc->bindParam(':locId', $_POST['iLocId'], PDO::PARAM_INT);
				$stmtLoc->bindParam(':assetId', $_POST['assetId'], PDO::PARAM_INT);
				$stmtLoc->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);
				$stmtLoc->execute();
				if($stmtLoc){
					//echo 'Location Saved: ';
				}else{echo 'Error occurred updating asset location!';}
				$stmtLoc = null;
		
		} catch (PDOException $e) {
			print $e->getMessage();
		}				
		
	}else if($itype=='p'){
		
		//Update Product type details
		$update_type = "UPDATE product_type SET description=:iDesc,cost=:iCost,currency=:iCurrency,unit_amount=:iUAmt,unit_id=:iUId,maunufacturer_id=:iManuId,vendor_id=:iVendorId,`name`=:iName,`barcode`=:iBarcode  WHERE id = :iId;";
		try {
			$stmt = $conn->prepare($update_type);     
				$stmt->bindParam(':iDesc',trim($_POST['input_item_desc']), PDO::PARAM_STR);
				$stmt->bindParam(':iUAmt',$iUnitAmt, PDO::PARAM_STR);
				$stmt->bindParam(':iUId', $_POST['input_item_unit'], PDO::PARAM_INT);
				$stmt->bindParam(':iCost', $iCost, PDO::PARAM_STR);
				$stmt->bindParam(':iCurrency', trim($_POST['input_item_currency']), PDO::PARAM_STR);
				$stmt->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);
				$stmt->bindParam(':iName',trim($_POST['inm']), PDO::PARAM_STR);
				$stmt->bindParam(':iBarcode',trim($_POST['item_barcode']), PDO::PARAM_STR);
				$stmt->bindParam(':iVendorId', $_POST['input_item_vendor'], PDO::PARAM_INT);
				$stmt->bindParam(':iManuId', $_POST['input_item_manu'], PDO::PARAM_INT);
				
				
				$stmt->execute();
				if($stmt){
					//echo 'Saved: ';
				}else{echo 'Error occurred updating product type!';}
				$stmt = null;
		
		} catch (PDOException $e) {
			print $e->getMessage();
		}		
		//Update Products table - quantity
		$update_product = "UPDATE products SET quantity=:iQuantity WHERE id =:productId AND product_type_id = :iId";
		try {
			$stmt2 = $conn->prepare($update_product);     
				
				$stmt2->bindParam(':iQuantity', $iQty, PDO::PARAM_STR);
				$stmt2->bindParam(':productId', $_POST['productId'], PDO::PARAM_INT);
				$stmt2->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);
				$stmt2->execute();
				if($stmt2){
					//echo 'Saved: ';
				}else{echo 'Error occurred updating product!';}
				$stmt2 = null;
		} catch (PDOException $e) {
			print $e->getMessage();
		}
		//if ($_POST["iLocId"]>0){
		if ($iLocId>0){
			$p_loc = "UPDATE product_location SET site_id=:iSiteId, site_map_img=:iLocMap,building_id=:iBldId,floor_id=:iFloorId,room_id=:iRoomId,area_id=:iAreaId,rack_id=:iRackId,shelf_id=:iShelfId,loc_code=:iLocCode WHERE id =:locId  AND product_id =:productId AND product_type_id = :iId";
			try {
				$stmtLoc = $conn->prepare($p_loc);  
					$stmtLoc->bindParam(':iLocCode', $iLoc_sh, PDO::PARAM_STR);
					$stmtLoc->bindParam(':iSiteId', $iSite, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iLocMap', $iLocImg, PDO::PARAM_STR);
					$stmtLoc->bindParam(':iBldId', $iBuild, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iFloorId', $iFloor, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iRoomId', $iRoom, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iAreaId', $iArea, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iRackId', $iRack, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iShelfId', $iShelf, PDO::PARAM_INT);
					$stmtLoc->bindParam(':locId', $_POST['iLocId'], PDO::PARAM_INT);
					$stmtLoc->bindParam(':productId', $_POST['productId'], PDO::PARAM_INT);
					$stmtLoc->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);
					$stmtLoc->execute();
					if($stmtLoc){
						//echo 'Location Saved: ';
					}else{echo 'Error occurred updating product location!';}
					$stmtLoc = null;
			
			} catch (PDOException $e) {
				print $e->getMessage();
			}				
		
		
		}else{
			$p_loc = "INSERT INTO product_location (product_type_id,product_id,site_id,building_id,floor_id,room_id,area_id,rack_id,shelf_id,loc_code, site_map_img,last_updated) 
			VALUES (:iId,:productId,:iSiteId,:iBldId,:iFloorId,:iRoomId,:iAreaId,:iRackId,:iShelfId,:iLocCode,:iLocMap,now())";
			try {
				$stmtLoc = $conn->prepare($p_loc);  
					$stmtLoc->bindParam(':iLocCode', $iLoc_sh, PDO::PARAM_STR);
					$stmtLoc->bindParam(':iSiteId', $iSite, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iLocMap', $iLocImg, PDO::PARAM_STR);
					$stmtLoc->bindParam(':iBldId', $iBuild, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iFloorId', $iFloor, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iRoomId', $iRoom, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iAreaId', $iArea, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iRackId', $iRack, PDO::PARAM_INT);
					$stmtLoc->bindParam(':iShelfId', $iShelf, PDO::PARAM_INT);
					$stmtLoc->bindParam(':productId', $_POST['productId'], PDO::PARAM_INT);
					$stmtLoc->bindParam(':iId', $_POST['iId'], PDO::PARAM_INT);
					$stmtLoc->execute();
					if($stmtLoc){
						//echo 'Location Saved: ';
					}else{echo 'Error occurred inserting product location!';}
					$stmtLoc = null;
			} catch (PDOException $e) {
				print $e->getMessage();
			}	
		}
				
	}
	

}else{
	// INSERT new record
	if($itype=='a'){
		
		$insert_type = "INSERT INTO asset_type (maunufacturer_id,owner_id,name,dimensions,description,finish,currency,cost,customer_id,category_id,last_updated) 
		VALUES (:iManuId,:iCltId,:iName,:iDimensions,:iDesc,:iFinish,:iCurrency,:iCost,:iCustomerId,:iCategoryId,now())";
		try {  
			$stmt = $conn->prepare($insert_type);     
				$stmt->bindParam(':iName',trim($_POST['inm']), PDO::PARAM_STR);
				$stmt->bindParam(':iDesc',trim($_POST['input_item_desc']), PDO::PARAM_STR);
				$stmt->bindParam(':iFinish', trim($_POST['input_item_finish']), PDO::PARAM_STR);
				$stmt->bindParam(':iDimensions', trim($_POST['input_item_dimensions']), PDO::PARAM_STR);
				$stmt->bindParam(':iCost', $iCost, PDO::PARAM_STR);
				$stmt->bindParam(':iCurrency', trim($_POST['input_item_currency']), PDO::PARAM_STR);
				//$stmt->bindParam(':iVendorId', 0, PDO::PARAM_INT);
				$stmt->bindParam(':iManuId', $_POST['input_item_manu'], PDO::PARAM_INT);
				$stmt->bindParam(':iCltId', $_POST['input_item_owner'], PDO::PARAM_INT);
				$stmt->bindParam(':iCustomerId', $_POST['customer'], PDO::PARAM_INT);
				$stmt->bindParam(':iCategoryId', $_POST['iCatId'], PDO::PARAM_INT);
				$stmt->execute();
				$item_id = $conn->lastInsertId();
				if($stmt){ 
					//echo 'Saved: '.$item_id;
				}else{echo 'Error occurred inserting asset type!';}
				$stmt = null;
		} catch (PDOException $e) {
			print $e->getMessage();
		}		
		
		if($item_id>0){
			$insert_asset = "INSERT INTO assets (asset_type_id,asset_condition_id,asset_status_id, quantity, last_updated) VALUES (:iItemId,:iConditionId,:iStatusId, :iQuantity, now())";
			try {
				$stmt2 = $conn->prepare($insert_asset);     
					$stmt2->bindParam(':iConditionId', $_POST['input_item_condition'], PDO::PARAM_INT);
					$stmt2->bindParam(':iStatusId', $_POST['input_item_status'], PDO::PARAM_INT);
					$stmt2->bindParam(':iQuantity', $iQty, PDO::PARAM_STR);
					$stmt2->bindParam(':iItemId', $item_id, PDO::PARAM_INT);
					$stmt2->execute();
					$asset_id = $conn->lastInsertId();
					if($stmt2){
						//echo 'Saved: ';
					}else{echo 'Error occurred inserting asset!';}
					$stmt2 = null;
			} catch (PDOException $e) {
				print $e->getMessage();
			}
		}
		
		if($asset_id>0){
			$insert_asset_loc = "INSERT INTO asset_location (asset_type_id,asset_id,loc_code,site_map_img,site_id,building_id,floor_id,room_id,area_id,rack_id,shelf_id, last_updated) VALUES (:iItemId,:iAssetId,:iLocCode,:iLocMap,:iSiteId,:iBldId,:iFloorId,:iRoomId,:iArea,:iRackId,:iShelfId,now())";
			try {
				$stmt3 = $conn->prepare($insert_asset_loc); 
					$stmt3->bindParam(':iAssetId', $asset_id, PDO::PARAM_INT);
					$stmt3->bindParam(':iLocCode', $iLoc_sh, PDO::PARAM_STR);
					$stmt3->bindParam(':iLocMap', $iLocImg, PDO::PARAM_STR);
					$stmt3->bindParam(':iSiteId', $_POST['site'], PDO::PARAM_INT);
					$stmt3->bindParam(':iBldId', $_POST['build'], PDO::PARAM_INT);
					$stmt3->bindParam(':iFloorId', $_POST['floor'], PDO::PARAM_INT);
					$stmt3->bindParam(':iArea', $iArea, PDO::PARAM_INT);
					$stmt3->bindParam(':iRoomId', $_POST['room'], PDO::PARAM_INT);
					$stmt3->bindParam(':iRackId', $iRack, PDO::PARAM_INT);
					$stmt3->bindParam(':iShelfId', $iShelf, PDO::PARAM_INT);
					$stmt3->bindParam(':iItemId', $item_id, PDO::PARAM_INT);
					$stmt3->execute();
					$loc_id = $conn->lastInsertId();
					if($stmt3){
						//echo 'Saved: ';
					}else{echo 'Error occurred inserting asset location!';}
					$stmt3 = null;
			} catch (PDOException $e) {
				print $e->getMessage();
			}	
		}

		$iId = $item_id;
	}else if($itype=='p'){

		$insert_type = "INSERT INTO product_type (`vendor_id`, `maunufacturer_id`, `name`,  `description`, `barcode`, `currency`, `cost`,  `category_id`, `unit_amount`, `customer_id`, `unit_id`,  `last_updated`) VALUES (:iVendorId,:iManuId,:iName,:iDesc,:iBarcode,:iCurrency,:iCost,:iCategoryId,:iUAmt,:iCustomerId,:iUId,now())";
		try {  
			$stmt = $conn->prepare($insert_type);     
				$stmt->bindParam(':iName',trim($_POST['inm']), PDO::PARAM_STR);
				$stmt->bindParam(':iDesc',trim($_POST['input_item_desc']), PDO::PARAM_STR);
				$stmt->bindParam(':iBarcode',trim($_POST['item_barcode']), PDO::PARAM_STR);
				$stmt->bindParam(':iUAmt',$iUnitAmt, PDO::PARAM_STR);
				$stmt->bindParam(':iUId', $_POST['input_item_unit'], PDO::PARAM_INT);
				$stmt->bindParam(':iCost', $iCost, PDO::PARAM_STR);
				$stmt->bindParam(':iCurrency', trim($_POST['input_item_currency']), PDO::PARAM_STR);
				$stmt->bindParam(':iVendorId', $_POST['input_item_vendor'], PDO::PARAM_INT);
				$stmt->bindParam(':iManuId', $_POST['input_item_manu'], PDO::PARAM_INT);
				$stmt->bindParam(':iCustomerId', $_POST['customer'], PDO::PARAM_INT);
				$stmt->bindParam(':iCategoryId', $_POST['iCatId'], PDO::PARAM_INT);
				$stmt->execute();
				$item_p_id = $conn->lastInsertId();
				if($stmt){ 
					//echo 'Saved: '.$item_id;
				}else{echo 'Error occurred inserting product type!';}
				$stmt = null;
		} catch (PDOException $e) {
			print $e->getMessage();
		}
		if($item_p_id>0){
			$insert_asset = "INSERT INTO products (product_type_id,quantity, last_updated) VALUES (:iItemId,:iQuantity,now())";
			try {
				$stmt2 = $conn->prepare($insert_asset);     
					$stmt2->bindParam(':iQuantity', $iQty, PDO::PARAM_STR);
					$stmt2->bindParam(':iItemId', $item_p_id, PDO::PARAM_INT);
					$stmt2->execute();
					$product_id = $conn->lastInsertId();
					if($stmt2){
						//echo 'Saved: ';
					}else{echo 'Error occurred inserting product!';}
					$stmt2 = null;
			} catch (PDOException $e) {
				print $e->getMessage();
			}	
		}
	
		if($product_id>0){
			$p_loc = "INSERT INTO product_location (product_type_id,product_id,loc_code,site_map_img,site_id,building_id,floor_id,room_id,area_id,rack_id,shelf_id, last_updated) 
			VALUES (:iId,:productId,:iLocCode,:iLocMap,:iSiteId,:iBldId,:iFloorId,:iRoomId,:iAreaId,:iRackId,:iShelfId,now())";
			try {
				$stmtLoc = $conn->prepare($p_loc);     
				$stmtLoc->bindParam(':iLocCode', $iLoc_sh, PDO::PARAM_STR);
				$stmtLoc->bindParam(':iSiteId', $iSite, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iLocMap', $iLocImg, PDO::PARAM_STR);
				$stmtLoc->bindParam(':iBldId', $iBuild, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iFloorId', $iFloor, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iRoomId', $iRoom, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iAreaId', $iArea, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iRackId', $iRack, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iShelfId', $iShelf, PDO::PARAM_INT);
				$stmtLoc->bindParam(':productId', $product_id, PDO::PARAM_INT);
				$stmtLoc->bindParam(':iId', $item_p_id, PDO::PARAM_INT);
				$stmtLoc->execute();
				if($stmtLoc){
					//echo 'Location Saved: ';
				}else{echo 'Error occurred inserting product location!';}
				$stmtLoc = null;
			} catch (PDOException $e) {
				print $e->getMessage();
			}
		}
		$iId = $item_p_id;
		
	}

	
		
}

//ID needs to be echoed back to calling function to refresh page for newly inserted record
echo $iId;



?>