

/*****Report Page Functions : START *****/
function getRptSite(uId){
	
	//var divId = $( "#rpt_division option:selected" ).val();
	var divId = document.getElementById('rpt_division').value;
	document.getElementById('rptDivId').value = divId;
	
	if(divId==0 || divId == null){
		
		$('.showRptSite').hide();
		
		//document.getElementById('srchCatType').value = "";
		
	}else{
		
		$.ajax({
		  type:'POST',
		  url:'srch_division_site.php',
		  data:{div_id:divId, user_id:uId},
		  cache:false,
		  success:function(data){
			  
			
			$('.showRptSite').show();
			$('.showRptSite').html(data);
			//$('#site').find('option[value="'+site+'"]').prop('selected', true);
		  }
		});
	}
}

function fn_view_report(){
	
	var validateV = validateFormData('site_report_form');
	if(validateV==true){
		var division_id = $( "#rpt_division option:selected" ).val();
		var div_nm = $( "#rpt_division option:selected" ).text();
		var site_id = $( "#srch_site option:selected" ).val();
		var site_nm = $( "#srch_site option:selected" ).text();
		
		$('#rpt_results_div').show();
		var dataString = 'division_id=' + division_id+ '& site_id=' + site_id+ '& div_nm=' + div_nm+ '& site_nm=' + site_nm;
		
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

