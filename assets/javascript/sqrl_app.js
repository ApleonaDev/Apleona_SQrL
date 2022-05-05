function saveItemDetailsT(vId){
	
	var itmId=0;
	var iTypeId;
	
	var id_result;
	//$('#info').append('<img src="images/ajax-loaderII.gif" alt="Currently Loading" id="loading"/>'); 
	var validateV = validateFormData('item_form');
	
	if(validateV==true){
		
		var data = $('form#item_form').serializeArray();
		
		$.ajax({
			url: 'save_item.php',
			type: 'POST',
			async: false,
			data: data,
			success: function(result){
				
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
		
		
		return 0;
	}
}

function getLifeCycle(vId, vItemType){
	
	$('#displayLC').empty();
	var dataString = '& vId=' + vId+ '& vItemType=' + vItemType;
	//alert(dataString);
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	
	
	
	$.ajax({
		url: 'get_lifecycle_tbl.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			//alert(data);
			$("#LCModal").modal('show');
			$('#displayLC').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
	
				
}


function saveItemDetails(vId){
	
	var itmId=0;
	var iTypeId;
	
	var id_result;
	//$('#info').append('<img src="images/ajax-loaderII.gif" alt="Currently Loading" id="loading"/>'); 
	var validateV = validateFormData('item_form');
	
	if(validateV==true){
	//Required data present...so save record
		var data = $('form#item_form').serializeArray();
		
		$.ajax({
			url: 'save_item.php',
			type: 'POST',
			async: false,
			data: data,
			success: function(result){
				
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

function getLifeCycle(vId, vItemType){
	
	$('#displayLC').empty();
	var dataString = '& vId=' + vId+ '& vItemType=' + vItemType;
	//alert(dataString);
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	
	
	
	$.ajax({
		url: 'get_lifecycle_tbl.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			//alert(data);
			$("#LCModal").modal('show');
			$('#displayLC').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
	
				
}


//Location Cascading Dropdowns: START





/*****Item Modal Page Functions : START *****/





function getupdtCategoryBrands(val){


	//Get list of item names available for category choosen
	var customer = $('#customer').val();
	var category_id = $( "#input_category option:selected" ).val();
	

	
	
	const catArr = category_id.split(",");
	category_id = catArr[1];

	var itype = document.getElementById('itypeS').value;
	
	$.ajax({
	  type:'POST',
	  url:'get_category_brands.php',
	  data:{itypeS :itype, inm :'', customer_id :customer, category_id :category_id},
	  cache:false,
	  success:function(data){
		  
		
		$('.showNamesList').show('slow');
		$('.showNamesList').html(data);
		
	  }
	});
}



function getCustOwners(){

	//Get list of item names available for category choosen
	var customer = $('#customer').val();
	var owner_id = $('#iowner_id').val();


	/*$.ajax({
	  type:'POST',
	  url:'get_customer_owners.php',
	  data:{ customer_id :customer, owner_id :owner_id},
	  cache:false,
	  success:function(data){

		$('.showOwnerList').show('slow');
		$('.showOwnerList').html(data);
		
	  }
	});*/
}


function getCustManufacturers(){


	//Get list of item names available for category choosen
	var customer = $('#customer').val();
	var manu_id = $('#imanu_id').val();

	$.ajax({
	  type:'POST',
	  url:'get_customer_manufacturers.php',
	  data:{ customer_id :customer, manu_id :manu_id},
	  cache:false,
	  success:function(data){

		$('.showManuList').show('slow');
		$('.showManuList').html(data);
		
	  }
	});
}





/*****Report Page Functions : START *****/
function getRptSite(uId){
	
	var custId = $( "#rpt_customer option:selected" ).val();
	document.getElementById('rptCustId').value = custId;
	
	if(custId==0 || custId == null){
		$('.showRptSite').hide();
		
		//document.getElementById('srchCatType').value = "";
		
	}else{
		
		$.ajax({
		  type:'POST',
		  url:'srch_customer_site.php',
		  data:{customer_id:custId, user_id:uId},
		  cache:false,
		  success:function(data){
			$('.showRptSite').show();
			$('.showRptSite').html(data);
			//$('#site').find('option[value="'+site+'"]').prop('selected', true);
		  }
		});
	}
}








function openItemDetails(vId, vNm, vType, vCatId, vDivId, vCustId, vTblNm){

	
	var dataString = 'vNm=' + vNm + '& vId=' + vId+ '& vType=' + vType+ '& vCatId=' + vCatId+ '& vDivId=' + vDivId+ '& vCustId=' + vCustId+ '& vTblNm=' + vTblNm;
	
	
	$('#displayAJAXResults_QV').empty();
	$('#showQVInfo').empty();
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	
	
	$.ajax({
		url: 'newitem.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			$('#showQVInfo').empty();
			$("#ItemQVModal").modal('show');
			$('#showQVInfo').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
}

function vwSrchItem(vId, vNm, vType, vCatId, vCustId, vTblNm){

	
	var dataString = 'vNm=' + vNm + '& vId=' + vId+ '& vType=' + vType+ '& vCatId=' + vCatId+ '& vCustId=' + vCustId+ '& vTblNm=' + vTblNm;
	//alert(dataString);
	
	//$('#displayAJAXResults_QV').empty();
	$('#item_details').empty();
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	
	
	$.ajax({
		url: 'item_details.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			//alert(data);
			
			$('#item_details').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
}
function openSrchItemT(vId, vNm, vType, vCatId, vCustId, vTblNm){

	
	var dataString = 'vNm=' + vNm + '& vId=' + vId+ '& vType=' + vType+ '& vCatId=' + vCatId+ '& vCustId=' + vCustId+ '& vTblNm=' + vTblNm;
	
	
	$('#displayAJAXResults_QV').empty();
	$('#showQVInfo').empty();
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	
	
	$.ajax({
		url: 'item.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			$('#showQVInfo').empty();
			$("#ItemQVModal").modal('show');
			$('#showQVInfo').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
}
function openSrchItemR(vId, vNm, vType, vCatId, vCustId, vTblNm){

	
	var dataString = 'vNm=' + vNm + '& vId=' + vId+ '& vType=' + vType+ '& vCatId=' + vCatId+ '& vCustId=' + vCustId+ '& vTblNm=' + vTblNm;
	
	
	
	$('#displayAJAXResults_QV').empty();
	$('#showQVInfo').empty();
	//$('#showQVInfo').append('<img src="../images/ajax_loader.gif" alt="loading..." id="ivovinfoloading"/>');	

	
	$.ajax({
		url: 'item.php',
		type: 'POST',
		data:dataString,
		async: false,
		success: function(data)
		{
			$('#showQVInfo').empty();
			$("#ItemQVModal").modal('show');
			$('#showQVInfo').append(data);	
			//$('#ivovinfoloading').fadeOut(300, function(){$(this).remove();});
		}
	});
	
	
	
	}
	

/*****Search Page Functions : END *****/

function fn_view_report(){
	
		var validateV = validateFormData('site_report_form');
		
		
		if(validateV==true){
			var customer_id = $( "#rpt_customer option:selected" ).val();
			var customer_nm = $( "#rpt_customer option:selected" ).text();
			var site_id = $( "#srch_site option:selected" ).val();
			var site_nm = $( "#srch_site option:selected" ).text();
			
			
			$('#rpt_results_div').show();
			var dataString = 'customer_id=' + customer_id+ '& site_id=' + site_id+ '& customer_nm=' + customer_nm+ '& site_nm=' + site_nm;
			
			
			if(site_id!==''){
				
				$.ajax({
					type: "POST",
					url: "rpt_site_tbl.php",
					data: dataString,
					async: false,
					success: function(data){
						
						
						$('#vw_site_rpt_tbl').append(data);	
					},
					error: function() {
						$("#displayRptErr").html('<div class="alert alert-warning" role="alert">  Report Error...!! </div>');
						$("#displayRptErr").fadeIn('slow').animate({opacity: 1.0}, 2500).fadeOut('slow');
						
					},
					complete: function() {
						
					
						
						
					} //END complete
				});
				
			}
		}
		//l.stop();
	}



/**** Common Functions : START ****/
function validateFormData(formStr){

	if(formStr=='srch_form'){
	
		//Required: Customer
		var subStr = $( "#srch_customer option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			//alert('error: '+subStr);
			//$("#displaySrchCat").html('<div alert alert-secondary fade in" role="alert"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong> Error! </strong> Please select a category! </div>');
			$("#displaySrchCat").html('<div class="alert alert-warning" role="alert">  Please select a customer!! </div>');
			$("#displaySrchCat").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.srch_form.srch_customer.focus() ;
			return false;
		}
		var subStr = $( "#srch_site option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			//alert('error: '+subStr);
			//$("#displaySrchCat").html('<div alert alert-secondary fade in" role="alert"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong> Error! </strong> Please select a category! </div>');
			$("#displaySrchCat").html('<div class="alert alert-warning" role="alert">  Please select a site!! </div>');
			$("#displaySrchCat").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.srch_form.srch_site.focus() ;
			return false;
		}
		//Required: Category
		var subStr = $( "#srch_category option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			//alert('error: '+subStr);
			//$("#displaySrchCat").html('<div alert alert-secondary fade in" role="alert"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong> Error! </strong> Please select a category! </div>');
			$("#displaySrchCat").html('<div class="alert alert-warning" role="alert">  Please select a category!! </div>');
			$("#displaySrchCat").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.srch_form.srch_category.focus() ;
			return false;
		}
		
		return( true );
	
	}
	if(formStr=='site_report_form'){
	
		//Required: Customer
		var subStr = $( "#rpt_customer option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#displayRptErr").html('<div class="alert alert-warning" role="alert">  Please select a customer!! </div>');
			$("#displayRptErr").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.site_report_form.rpt_customer.focus() ;
			return false;
		}
		var subStr = $( "#srch_site option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			//alert('error: '+subStr);
			//$("#displaySrchCat").html('<div alert alert-secondary fade in" role="alert"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong> Error! </strong> Please select a category! </div>');
			$("#displayRptErr").html('<div class="alert alert-warning" role="alert">  Please select a site!! </div>');
			$("#displayRptErr").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.site_report_form.srch_site.focus() ;
			return false;
		}
		
		
		return( true );
	
	}
	
	if(formStr=='item_form'){
	
		//Required: Customer
		var subStr = $( "#customer option:selected" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a customer!! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.customer.focus() ;
			return false;
		}
		
		//Required: Category
		var subStr = $( "#input_category option:selected" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a category!! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.input_category.focus() ;
			return false;
		}
		
		//Required: Product
		var subStr = $("#input_item_quantity").val();
		
		if( typeof subStr === "undefined" || subStr == "")
		{
			
				
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please enter a quantity!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_quantity.focus() ;
				return false;

			
			
			
		}
		var subStr = $( "#input_item_name option:selected" ).val();
		var subStr2 = $( "#inm" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0 )
		{
			if(subStr2==""){
				
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select/enter a brand name!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_name.focus() ;
				return false;

			
			}
			
		}
		
		//Required: manufacturer
		var subStr = $( "#input_item_manu option:selected" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a manufacturer!! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.input_item_manu.focus() ;
			return false;
		}
		
		if($("#itypeS").val() == 'p' ){
			
			//Product Required: Vendor
			var subStr = $( "#input_item_vendor option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a vendor!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_vendor.focus() ;
				return false;
			}
		}
		
		if($("#itypeS").val() == 'a' ){
			//Product Required: Owner / Client
			var subStr = $( "#input_item_owner option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a client!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_owner.focus() ;
				return false;
			}
			
			//Required: Status
			var subStr = $( "#input_item_status option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a status!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_status.focus() ;
				return false;
			}
			
			
			//Required: Condition
			var subStr = $( "#input_item_condition option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a condition!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_condition.focus() ;
				return false;
			}
			
			
			
			
		}
		
		
		
		//Required: Location Details
		var subStr = $( "#site option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a site! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.site.focus() ;
			return false;
		
		}
		var subStr = $( "#build option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a building! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.build.focus() ;
			return false;
		
		}
		
		var subStr = $( "#floor option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a floor! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.floor.focus() ;
			return false;
		
		}
		
		var subStr = $( "#room option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a room! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.room.focus() ;
			return false;
		
		}
		
		var subStr = $( "#area option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select an area! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.area.focus() ;
			return false;
		
		}
		var subStr = $( "#rack option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a rack! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.rack.focus() ;
			return false;
		
		}
		
		var subStr = $( "#shelf option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a shelf! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.item_form.shelf.focus() ;
			return false;
		
		}
		
		
		
		return( true );
	
	}
	
	
}


/**** Create item ****/

