function validateFormData(formStr){

	if(formStr=='srch_form'){
	
		//Required: Customer
		/*var subStr = $( "#srch_customer option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			//alert('error: '+subStr);
			//$("#displaySrchCat").html('<div alert alert-secondary fade in" role="alert"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong> Error! </strong> Please select a category! </div>');
			$("#displaySrchCat").html('<div class="alert alert-warning" role="alert">  Please select a customer!! </div>');
			$("#displaySrchCat").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.srch_form.srch_customer.focus() ;
			return false;
		}*/
		
		var subStr = $( "#srch_division option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			//alert('error: '+subStr);
			//$("#displaySrchCat").html('<div alert alert-secondary fade in" role="alert"><button data-dismiss="alert" class="close">&times;</button><i class="fa fa-times-circle"></i><strong> Error! </strong> Please select a category! </div>');
			$("#displaySrchCat").html('<div class="alert alert-warning" role="alert">  Please select a division!! </div>');
			$("#displaySrchCat").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.srch_form.srch_division.focus() ;
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
		var subStr = $( "#rpt_division option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#displayRptErr").html('<div class="alert alert-warning" role="alert">  Please select a division!! </div>');
			$("#displayRptErr").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			document.site_report_form.rpt_division.focus() ;
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
		var subStr = $( "#division option:selected" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a division!! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			
			$('.nav-tabs a[href="#what"]').tab('show');
			document.item_form.division.focus() ;
			return false;
		}
		
		//Required: Category
		var subStr = $( "#input_category option:selected" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a category!! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			
			$('.nav-tabs a[href="#what"]').tab('show');
			document.item_form.input_category.focus() ;
			return false;
		}
		var subStr = $( "#input_item_name option:selected" ).val();
		var subStr2 = $( "#inm" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0 )
		{
			if(subStr2==""){
				
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select/enter a brand name!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				
				$('.nav-tabs a[href="#what"]').tab('show');
				document.item_form.input_item_name.focus() ;
				return false;

			
			}
		}
		
		//Required: Product
		var subStr = $("#input_item_quantity").val();
		if( typeof subStr === "undefined" || subStr == "")
		{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please enter a quantity!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				
				$('.nav-tabs a[href="#what"]').tab('show');
				document.item_form.input_item_quantity.focus() ;
				return false;
		}
		
		
		
		
		
		
		
		if($("#itypeS").val() == 'a' ){
			
			
			//Required: Condition
			var subStr = $( "#input_item_condition option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a condition!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				
				$('.nav-tabs a[href="#what"]').tab('show');
				document.item_form.input_item_condition.focus() ;
				return false;
			}
			//Required: Status
			var subStr = $( "#input_item_status option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a status!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				$('.nav-tabs a[href="#what"]').tab('show');
				document.item_form.input_item_status.focus() ;
				return false;
			}
			
			var subStr = $( "#customer option:selected" ).val();
		
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a client!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				$('.nav-tabs a[href="#who"]').tab('show');
				document.item_form.customer.focus() ;
				return false;
			}
			
			
			
		
			
			
			
		
		
		
			//Product Required: Owner / Client
			/*var subStr = $( "#input_item_owner option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a client!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				document.item_form.input_item_owner.focus() ;
				return false;
			}*/
		
		}
		
		if($("#itypeS").val() == 'p' ){
			
			//Product Required: Vendor
			var subStr = $( "#input_item_vendor option:selected" ).val();
			
			if( typeof subStr === "undefined" || subStr == 0)
			{
				$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a vendor!! </div>');
				$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
				
				$('.nav-tabs a[href="#who"]').tab('show');
				document.item_form.input_item_vendor.focus() ;
				return false;
			}
		}
		
		//Required: manufacturer
		var subStr = $( "#input_item_manu option:selected" ).val();
		
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a manufacturer!! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#who"]').tab('show');
			document.item_form.input_item_manu.focus() ;
			return false;
		}
		
		
		//Required: Location Details
		var subStr = $( "#site option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a site! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.site.focus() ;
			return false;
		
		}
		var subStr = $( "#build option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a building! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.build.focus() ;
			return false;
		
		}
		
		var subStr = $( "#floor option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a floor! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.floor.focus() ;
			return false;
		
		}
		
		var subStr = $( "#room option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a room! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.room.focus() ;
			return false;
		
		}
		
		var subStr = $( "#area option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select an area! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.area.focus() ;
			return false;
		
		}
		var subStr = $( "#rack option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a rack! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.rack.focus() ;
			return false;
		
		}
		
		var subStr = $( "#shelf option:selected" ).val();
		if( typeof subStr === "undefined" || subStr == 0)
		{
			$("#errSaveitem").html('<div class="alert alert-warning" role="alert">  Please select a shelf! </div>');
			$("#errSaveitem").fadeIn('fast').animate({opacity: 1.0}, 2000).fadeOut('fast');
			$('.nav-tabs a[href="#where"]').tab('show');
			document.item_form.shelf.focus() ;
			return false;
		
		}
		
		
		
		return( true );
	
	}
	
	
}

