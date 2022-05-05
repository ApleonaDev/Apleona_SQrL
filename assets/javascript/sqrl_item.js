function setCurrency(vCurr){

	
	document.getElementById('isite_currency').value = vCurr;
	
	document.getElementById('input_item_currency').value = vCurr;
	document.getElementById('input_tc_currency').value = vCurr;
	
	document.getElementById('input_sp_currency').value = vCurr;
	document.getElementById('input_spv_currency').value = vCurr;
	
	document.getElementById('input_asp_currency').value = vCurr;
	document.getElementById('input_aspv_currency').value = vCurr;
	
	document.getElementById('input_bn_currency').value = vCurr;
	document.getElementById('input_bnv_currency').value = vCurr;
	

}
function getValueAnalysis(){
	
	var vQuantity = Number(document.getElementById('input_item_quantity').value);
	var vCost = Number(document.getElementById('input_item_cost').value);
	var vUSP = Number(document.getElementById('input_selling_price').value);
	
	var vASP = Number(document.getElementById('input_alt_selling_price').value);
	var vBN = Number(document.getElementById('input_bn_price').value);
	

	
	
	var vStockValue = Number(vQuantity) * Number(vUSP);
	var vCostValue = Number(vQuantity) * Number(vCost);
	
	var vASPValue = Number(vQuantity) * Number(vASP);
	var vBNValue = Number(vQuantity) * Number(vBN);
	
	
	document.getElementById('input_tc_value').value = vCostValue;
	document.getElementById('input_sp_value').value = vStockValue;
	document.getElementById('input_asp_value').value = vASPValue;
	document.getElementById('input_bn_value').value = vBNValue;
}
function tabCostings(uType, iType){

	var retV;
	const adminUserType = ['0', '2', '4'];
	retV = adminUserType.includes(uType);
	//alert(uType + ' - '+iType + ' - retV: '+retV);
	
	if(iType=='a' && retV == true){
		$('.tab-costings').show();
	}else {
		$('.tab-costings').hide();
		
	}
	
	
	
	
}
function vwSrchItem(vId, vNm, vType, vCatId, vDivId, vTblNm){

	
	var dataString = 'vNm=' + vNm + '& vId=' + vId+ '& vType=' + vType+ '& vCatId=' + vCatId+ '& vDivId=' + vDivId+ '& vTblNm=' + vTblNm;
	//alert(dataString);
	
	//$('#displayAJAXResults_QV').empty();
	$('#item_details').empty();
	$('#item_details').show();
	
	
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	
	
	$.ajax({
		url: 'item_details.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			$('#item_details').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
}

function getCategoryType(val) {

	if(val=="" || val==0){
		
		
		$('.item_div').hide('fast');
		$('.asset_div').hide('fast');
		$('.product_div').hide('fast');
			
	}else{
		
		const catArr = val.split(",");
		$('.item_div').show('fast');
		
		document.getElementById('itypeS').value = catArr[0];
		document.getElementById('iCatId').value = catArr[1];
		document.getElementById('icategoryid').value = catArr[1];	
		if(catArr[0]=='a'){//asset only elements
			$('.asset_div').show('fast');
			$('.product_div').hide('fast');
			
		}else{
			
			$('.asset_div').hide('fast');
			$('.product_div').show('fast');
		}
	}
	return false;
}

function getCategoryList(divId, categoryId, categoryType){
	
	var categoryIdV = $( "#icategoryid" ).val();
	var categoryTypeV = $( "#itypeS" ).val();

	$.ajax({
	  type:'POST',
	  url:'get_division_category.php',
	  data:{division_id :divId, category_id :categoryId, category_type :categoryType},
	  cache:false,
	  success:function(data){
		$('.showCategoryList').show();
		$('.showCategoryList').html(data);
		
	  }
	});
}

function getCategoryBrands(val,divId,catId){

	//Get list of item names available for category choosen
	//var customer = $('#customer').val();

	//var category_id = $('#icategoryid').val();

	
	//const catArr = val.split(",");
	var catArr = val;
	//var inm = $('#inm').val();
	var inm = document.getElementById('inm').value;
	var itype = document.getElementById('itypeS').value;
	
	$.ajax({
	  type:'POST',
	  url:'get_division_brands.php',
	  data:{itypeS :itype, inm :inm, division_id :divId, category_id :catId},
	  cache:false,
	  success:function(data){
		//alert('data: '+data);		
		$('.showNamesList').show('slow');
		$('.showNamesList').html(data);
		
	  }
	});
}

function getDivisionConditions(){


	//Get list of item names available for category choosen
	var division = document.getElementById('division').value;
	//var customer = $('#customer').val();
	var condition_id = document.getElementById('input_item_condition').value;
	var c_id = document.getElementById('icondition').value;
	
	$.ajax({
	  type:'POST',
	  url:'get_division_conditions.php',
	  data:{ division_id :division, condition_id :c_id},
	  cache:false,
	  success:function(data){

		$('.showConditionList').show('slow');
		$('.showConditionList').html(data);
		
	  }
	});
}
function getDivisionCustomers(custId){


	//Get list of item names available for category choosen
	var division = $('#division').val();
	//var customer = $('#customer').val();

	$.ajax({
	  type:'POST',
	  url:'get_division_customers.php',
	  data:{ division_id :division, customer_id :custId},
	  cache:false,
	  success:function(data){

		$('.showDivCustomer').show('slow');
		$('.showDivCustomer').html(data);
		
	  }
	});
}
function getDivisionClients(){


	//Get list of item names available for category choosen
	var division = $('#division').val();
	var customer = $('#customer').val();
	var client = $('#client').val();
	
	$.ajax({
	  type:'POST',
	  url:'get_division_clients.php',
	  data:{ division_id :division, client_id :client},
	  cache:false,
	  success:function(data){

		$('.showClientList').show('slow');
		$('.showClientList').html(data);
		
	  }
	});
}
function getDivisionOwners(ownerid){

	//Get list of item names available for category choosen
	var division = $('#division').val();
	//var customer = $('#customer').val();
	//var owner_id = $('#iowner_id').val();

	$.ajax({
	  type:'POST',
	  url:'get_division_owners.php',
	  data:{ division_id :division, owner_id :ownerid},
	  cache:false,
	  success:function(data){

		$('.showOwnerList').show('slow');
		$('.showOwnerList').html(data);
		
	  }
	});
}
function getDivisionManufacturers(){


	//Get list of item names available for category choosen
	var division = $('#division').val();
	var customer = $('#customer').val();
	var manu_id = $('#imanu_id').val();

	$.ajax({
	  type:'POST',
	  url:'get_division_manufacturers.php',
	  data:{ division_id :division, manu_id :manu_id},
	  cache:false,
	  success:function(data){

		$('.showManuList').show('slow');
		$('.showManuList').html(data);
		
	  }
	});
}

function getVendors(divId){


	//Get list of item names available for category choosen
	//var customer = $('#customer').val();
	var vendor_id = $('#ivendor_id').val();

	$.ajax({
	  type:'POST',
	  url:'get_vendors.php',
	  data:{ division_id :divId, vendor_id :vendor_id},
	  cache:false,
	  success:function(data){

		$('.showVendorList').show('slow');
		$('.showVendorList').html(data);
		
	  }
	});
}
function getCustVendors(custId){


	//Get list of item names available for category choosen
	//var customer = $('#customer').val();
	var vendor_id = $('#ivendor_id').val();

	$.ajax({
	  type:'POST',
	  url:'get_customer_vendors.php',
	  data:{ customer_id :custId, vendor_id :vendor_id},
	  cache:false,
	  success:function(data){

		$('.showVendorList').show('slow');
		$('.showVendorList').html(data);
		
	  }
	});
}


function saveItemDetails(vId){
	
	//alert(vId);
	//alert('Crate save: '+ document.getElementById('input_crate_number').value );
	var itmId=0;
	var iTypeId;
	
	var id_result;
	//$('#info').append('<img src="images/ajax-loaderII.gif" alt="Currently Loading" id="loading"/>'); 
	var validateV = validateFormData('item_form');
	
	if(validateV==true){
	//Required data present...so save record
		var data = $('form#item_form').serializeArray();
		//alert(data);
		$.ajax({
			url: 'save_item.php',
			type: 'POST',
			async: false,
			data: data,
			success: function(result){
				//alert(result);
				itmId = result;
				
				
			},
			error: function() {
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Error occurred!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			}
			//,complete: function() {}
		});
		return itmId;
	
	}else{
		
		return false;
	}

}
