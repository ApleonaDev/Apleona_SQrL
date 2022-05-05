function initLocationData(vId){
	
	

	$('.showBld').hide();	
	$('.showFloor').hide();
	$('.showRoom').hide();
	$('.showArea').hide();
	$('.showRack').hide();
	$('.showShelf').hide();
	$('.showMap').hide();
	$('.crate_div').hide();
	
	

	if(vId>0){

		getSite(vId);
		getBld(document.getElementById('iSite').value);
		getFloor(document.getElementById('iBld').value);
		getRoom(document.getElementById('iFloor').value);
		
		
		
		getArea(document.getElementById('iRoom').value);
		getRack(document.getElementById('iArea').value);
		getShelf(document.getElementById('iRack').value);
//Crate System
		var str = $( "#room option:selected" ).text();
		if(str.indexOf("Crate") >= 0){
			$('.crate_div').show();
		}else{
			$('.crate_div').hide();
		}
	}
}

function getSite(vCId){
//alert('vCId'+vCId);
	if(vCId>0){
		
		
		var site = $('#iSite').val();
		
	

		$.ajax({
		  type:'POST',
		  url:'get_sites.php',
		  data:{division_id:vCId, site_id :site},
		  cache:false,
		  success:function(data){
			$('.showSite').show();
			$('.showMap').show();
			$('.showSite').html(data);
			//$('#site').find('option[value="'+site+'"]').prop('selected', true);
		  },
		  complete: function(data) {
			  
			  document.getElementById('sh_site').innerHTML = typeof  $( "#site option:selected" ).data('siteshnm') == "undefined" ? "" : $( "#site option:selected" ).data('siteshnm'); 
			  document.getElementById('ish_site').value = $( "#site option:selected" ).data('siteshnm');
		  }
		});
		
	}else{
		
		
		$.ajax({
		  type:'POST',
		  url:'get_division_sites.php',
		  data:{division_id:0, site_id :0},
		  cache:false,
		  success:function(data){
			  
			  
			$('.showSite').hide();
			$('.showMap').show();
			$('.showSite').html(data);
			
		  },
		  complete: function(data) {
			  
			  document.getElementById('sh_site').innerHTML = "-";
			  document.getElementById('ish_site').value = $( "#site option:selected" ).data('siteshnm');
		  }
		});
	}
	
	
}

/**** Location ****/


function getBld(vSite){
	
	//$('.showFloor').hide('slow');
	//$('.showRoom').hide('slow');
	//$('.showArea').hide('slow');
	//$('.showRack').hide('slow');
	//$('.showShelf').hide('slow');
	if(vSite>0){
		var build = $('#iBld').val();
		$.ajax({
		  type:'POST',
		  url:'get_site_bld.php',
		  data:{site_id :vSite,build_id:build},
		  cache:false,
		  success:function(data){
			$('.showBld').show('slow');
			$('.showBld').html(data);
		  },
		  complete: function(data) {
			  document.getElementById('sh_bld').innerHTML = typeof  $( "#build option:selected" ).data('bldshnm') == "undefined" ? "" : $( "#build option:selected" ).data('bldshnm');
			  document.getElementById('ish_bld').value = $( "#build option:selected" ).data('bldshnm'); 
		  }
		}); 
	}else{
		$.ajax({
		  type:'POST',
		  url:'get_site_bld.php',
		  data:{site_id :0,build_id:0},
		  cache:false,
		  success:function(data){
			$('.showBld').hide('slow');
			$('.showBld').html(data);
		  },
		  complete: function(data) {
			  
			  document.getElementById('sh_bld').innerHTML = "-";
			  document.getElementById('ish_bld').value = $( "#build option:selected" ).data('bldshnm');
			  
			  
		  }
		}); 
	}		
	
	
}

function getFloor(vBld){
	
	
	//$('.showRoom').hide('slow');
	//$('.showArea').hide('slow');
	//$('.showRack').hide('slow');
	//$('.showShelf').hide('slow');
	if(vBld>0){
		var floor = $('#iFloor').val();
		$.ajax({
		  type:'POST',
		  url:'get_bld_flr.php',
		  data:{ build_id :vBld, floor_id :floor},
		  cache:false,
		  success:function(data){
			$('.showFloor').show('slow');
			$('.showFloor').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_flr').innerHTML = typeof  $( "#floor option:selected" ).data('flrshnm') == "undefined" ? "" : $( "#floor option:selected" ).data('flrshnm'); 
			document.getElementById('ish_flr').value = $( "#floor option:selected" ).data('flrshnm');  
			
		  }
		}); 
	}else{
		$.ajax({
		  type:'POST',
		  url:'get_bld_flr.php',
		  data:{ build_id :0, floor_id :0},
		  cache:false,
		  success:function(data){
			$('.showFloor').hide('slow');
			$('.showFloor').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_flr').innerHTML = "-";  
			document.getElementById('ish_flr').value = $( "#floor option:selected" ).data('flrshnm');  
			
		  }
		}); 
	}
	
	
}

function getRoom(vFlr){
	//$('.showArea').hide('fast');
	//$('.showRack').hide('fast');
	//$('.showShelf').hide('fast');
	if(vFlr>0){
		var room = $('#iRoom').val();
		
		
		$.ajax({
		  type:'POST',
		  url:'get_flr_rm.php',
		  data:{ floor_id :vFlr, room_id :room},
		  cache:false,
		  success:function(data){
			$('.showRoom').show('slow');
			$('.showRoom').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_room').innerHTML = typeof  $( "#room option:selected" ).data('rmshnm') == "undefined" ? "" : $( "#room option:selected" ).data('rmshnm'); 
			document.getElementById('ish_room').value = $( "#room option:selected" ).data('rmshnm');
			
		  }
		}); 
		
	}else{
		
		$.ajax({
		  type:'POST',
		  url:'get_flr_rm.php',
		  data:{ floor_id :0, room_id :0},
		  cache:false,
		  success:function(data){
			$('.showRoom').hide('slow');
			$('.showRoom').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_room').innerHTML = "";
			document.getElementById('ish_room').value = $( "#room option:selected" ).data('rmshnm');
			
		  }
		}); 
		
		
	}
}

function getArea(vRm){
	
	var areaV;
	
	//$('.showRack').hide('fast');
	//$('.showShelf').hide('fast');
	
	
	if(vRm>0){
		areaV = $('#iArea').val();
		$.ajax({
		  type:'POST',
		  url:'get_rm_area.php',
		  data:{ room_id :vRm, area_id :areaV},
		  cache:false,
		  success:function(data){
			$('.showArea').show('slow');
			$('.showArea').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_area').innerHTML = typeof  $( "#area option:selected" ).data('areashnm') == "undefined" ? "" : $( "#area option:selected" ).data('areashnm'); 
			document.getElementById('ish_area').value = $( "#area option:selected" ).data('areashnm');
			
		  }
		}); 
		
	}else{
		
		
		$.ajax({
		  type:'POST',
		  url:'get_rm_area.php',
		  data:{ room_id :0, area_id :0},
		  cache:false,
		  success:function(data){
			$('.showArea').hide('slow');
			$('.showArea').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_area').innerHTML = "";
			document.getElementById('ish_area').value = $( "#area option:selected" ).data('areashnm');
			
		  }
		}); 
	}

	

	
	
}

function getRack(vArea){
	
	var rack;
	
	//$('.showShelf').hide('fast');
	if(vArea>0){
		rack = $('#iRack').val();
		
		$.ajax({
		  type:'POST',
		  url:'get_area_rack.php',
		  data:{ area_id :vArea,rack_id :rack},
		  cache:false,
		  success:function(data){
			$('.showRack').show('slow');
			$('.showRack').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_rack').innerHTML = typeof  $( "#rack option:selected" ).data('rackshnm') == "undefined" ? "" : $( "#rack option:selected" ).data('rackshnm'); 
			document.getElementById('ish_rack').value = $( "#rack option:selected" ).data('rackshnm');  
			
		  }
		}); 
	
	 }else{
		$.ajax({
		  type:'POST',
		  url:'get_area_rack.php',
		  data:{ area_id :0,rack_id :0},
		  cache:false,
		  success:function(data){
			$('.showRack').hide('slow');
			$('.showRack').html(data);
		  },
		  complete: function(data) {
			document.getElementById('sh_rack').innerHTML = "";  
			document.getElementById('ish_rack').value = $( "#rack option:selected" ).data('rackshnm');  
			
			$('.showRack').hide('slow');
		  }
		}); 
	
	}
}

function getShelf(vRk){
	
	
	
	var shelf;
	
	
	if(vRk>0){
		
		shelf = $('#iShelf').val();
		
		
		$.ajax({
		  type:'POST',
		  url:'get_rack_shlf.php',
		  data:{ rack_id :vRk,shelf_id :shelf},
		  cache:false,
		  success:function(data){
			$('.showShelf').show('slow');
			$('.showShelf').html(data);
		  },
		  complete: function(data) {
			  
			document.getElementById('sh_shelf').innerHTML = typeof  $( "#shelf option:selected" ).data('shlfshnm') == "undefined" ? "" : $( "#shelf option:selected" ).data('shlfshnm'); 
			document.getElementById('ish_shelf').value = $( "#shelf option:selected" ).data('shlfshnm'); 
			
		  }
		}); 
		
	}else{

		
		
		$.ajax({
		  type:'POST',
		  url:'get_rack_shlf.php',
		  data:{ rack_id :0,shelf_id :0},
		  cache:false,
		  success:function(data){
			//$('.showShelf').show('slow');
			$('.showShelf').html(data);
		  },
		  complete: function(data) {
			  
			
			document.getElementById('sh_shelf').innerHTML = ""; 
			document.getElementById('ish_shelf').value = $( "#shelf option:selected" ).data('shlfshnm'); 
			
			$('.showShelf').hide('fast');
			
			
		  }
		}); 
		
		
	}
	
 
}	
//** Location Cascading Dropdowns: END **//