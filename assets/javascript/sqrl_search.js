/*****Search Page Functions : START *****/

function srchCustChange(vCId){
	
	$('#vw_srch_tbl').empty();
	$('.asset_div').hide();
	$('.product_div').hide();
	$('.showSrchSite').hide();
	$('.showSrchBrand').hide();
	$('#srch_results_div').hide();
	$('#item_details').hide();
	var userId = document.getElementById('session_user_id').value ;	
	
	
	if(vCId>0){


		getSrchSite(vCId,userId);
		getSrchCategory(vCId);

	}		
		
}
function getSrchCustomer(vDivId){
	
	
	if(vDivId > 0){
		
		
		$.ajax({
		  type:'POST',
		  url:'srch_division_customers.php',
		  data:{division_id:vDivId},
		  cache:false,
		  success:function(data){
			  
			
			
			
			  
			$('.showSrchDivCustomer').show();
			$('.showSrchDivCustomer').html(data);
			
			
			//$('#site').find('option[value="'+site+'"]').prop('selected', true);
		  }
		});
	}
	
	
}

function getSrchSite(vId, uId){
	

	
	//var divId = $( "#srch_division option:selected" ).val();
	//document.getElementById('srchDivId').value = vId;
	
	
	if(vId==0 || vId == null){
		
		$('.showSrchSite').hide();
		$('.showSrchCat').hide();
		$('.showSrchBrand').hide();
		//document.getElementById('srchCatType').value = "";
		
	}else{
		
		$.ajax({
		  type:'POST',
		  url:'srch_division_site.php',
		  data:{div_id:vId, user_id:uId},
		  cache:false,
		  success:function(data){
			$('.showSrchSite').show();
			$('.showSrchSite').html(data);
			//$('#site').find('option[value="'+site+'"]').prop('selected', true);
			
			
		  }
		});
	}
}
function getSrchCategory(vId){
	
	
	//var custId = $( "#srch_customer option:selected" ).val();
	//document.getElementById('srchCustId').value = custId;
	
	if(vId==0 || vId == null){
		
		$('.showSrchCat').hide();
		$('.showSrchBrand').hide();
		//document.getElementById('srchCatType').value = "";
		
	}else{
		
		$.ajax({
		  type:'POST',
		  url:'srch_division_category.php',
		  data:{division_id:vId},
		  cache:false,
		  success:function(data){
			  
			  

 
			$('.showSrchCat').show('slow');
			$('.showSrchCat').html(data);
			//$('#site').find('option[value="'+site+'"]').prop('selected', true);
			
			
			
			
			
		  }
		});
	}
}

function srchCatType(val) {

	var catArr = val;
	
	
	if(catArr=='a'){//asset only elements
		$('.asset_div').show('fast');
		$('.product_div').hide('fast');
		//getSrchBrand();	
	}else if(catArr=='p'){
		
		$('.asset_div').hide('fast');
		$('.product_div').show('fast');
		//getSrchBrand();	
	} else{
		//alert('no category');
		
	}
	
	return false;
}


function getSrchBrand(){
	
	//var custId = $( "#srch_customer option:selected" ).val();
	var vId = $( "#srch_division option:selected" ).val();
	var catType = $( "#srch_category option:selected" ).val();
	var catId = $( "#srch_category option:selected" ).data('id');

	$.ajax({
	  type:'POST',
	  url:'srch_division_brand.php',
	  data:{division_id :vId, catType :catType, catId :catId},
	  cache:false,
	  success:function(data){
		$('.showSrchBrand').show();
		$('.showSrchBrand').html(data);
		
	  }
	});
}
/*****Search Page Functions : END *****/