<?php 
//Connect to server
require('../getSQL.php');

$div_nm = $_POST["div_nm"];
$site_nm = $_POST["site_nm"];
$division_id = $_POST["division_id"];
$site_id = $_POST["site_id"];



$sql = "";
$item_str = "";

 
	  
$sr_sql = "SELECT 'a' as itype, ac.category_name,ac.id as categoryid,ast.asset_status as item_status, acd.asset_condition as item_condition, al.id as locId,  al.loc_code as loc_code, a.quantity as amt, at.name as item_name
, at.id as item_type_id, at.currency as curr_id, at.cost, 'NA' as unit_amt, '' as unit_id, m.name as brand_name, c.name as customer_nm, o.name as owner_nm, at.selling_price as usprice
			FROM `asset_type` as at LEFT JOIN customer as c ON (c.id = at.customer_id) LEFT JOIN owner as o ON (o.id = at.owner_id), asset_location as al, maunufacturer m, `asset_category` as ac, `asset_condition` as acd, assets as a LEFT JOIN asset_status as ast ON (ast.id = a.asset_status_id)
            
			WHERE at.category_id = ac.id AND at.id = a.asset_type_id AND a.asset_condition_id = acd.id AND at.id = al.asset_type_id AND at.maunufacturer_id = m.id
			AND at.division_id =".$_POST['division_id']." AND al.site_id =".$_POST['site_id']." 
			
			UNION
			
			SELECT 'p' as itype, pc.category_name,pc.id as categoryid, 'NA' as item_status, 'NA' as item_condition, pl.id as locId,  pl.loc_code as loc_code, p.quantity as amt, pt.name as item_name,
			pt.id as item_type_id, pt.currency as curr_id, pt.cost,pt.unit_amount as unit_amt, unit.type as unit_id, m.name as brand_name,'' as customer_nm,'' as owner_nm, '-' as usprice
			FROM product_category as pc, product_type as pt LEFT JOIN unit ON (pt.unit_id = unit.id), product_location pl, products p, maunufacturer m
			WHERE pt.category_id = pc.id AND p.product_type_id = pt.id AND pt.id = pl.product_type_id AND pt.maunufacturer_id = m.id
			AND pt.division_id =".$_POST['division_id']." AND pl.site_id =".$_POST['site_id']." 
			
			ORDER BY category_name,item_name, amt;";
	  


  $asset_col = "";
  $product_col = "";
?>
  

 <div class="row table-responsive">
<table id="rpt_results_tbl" class="table table-striped table-bordered display nowrap  dataTable no-footer"  aria-describedby="rpt_results_tbl_info" role="grid">

               
  <thead class="">

	<tr>
  
	  <th class="hide_column sorting" tabindex="0" aria-controls="rpt_results_tbl" rowspan="1" colspan="1" aria-label="Client: activate to sort column ascending">Client</th>
	  <th class="hide_column sorting" tabindex="0" aria-controls="rpt_results_tbl" rowspan="1" colspan="1" aria-label="Owner: activate to sort column ascending">Owner</th>
	  <th class="hide_column sorting" tabindex="0" aria-controls="rpt_results_tbl" rowspan="1" colspan="1" aria-label="Category: activate to sort column ascending">Category</th>
     <th class="th-sm">Name</th>
      <th class="th-sm">Brand</th>
      
      <th class="th-sm">Location</th>
     <th class="th-sm">Qty</th> 
	 
	<!-- <th class="th-sm" title="Unit Stock Value">Unit SV</th>-->
	 <th class="th-sm" title="Stock Value">SV</th>
	 
	 <th class="th-sm">Unit Cost</th>
      <th class="th-sm"  <?php echo $asset_col;?> >Condition</th>
	  <th class="th-sm"  <?php echo $asset_col;?> >Status </th>
	 
	  <th class="th-sm"  <?php echo $product_col;?>>Unit Amt</th>
	  
    </tr>
  </thead>
  <tbody class="">
  
  <?php


	try {
		$stmt_results = $conn->prepare($sr_sql); 
		$stmt_results->execute(); 
		if ($stmt_results->rowCount()){
			while ($resultrow = $stmt_results->fetch(PDO::FETCH_ASSOC)) {
				$locSh = '';
				$locSH = is_null($resultrow['loc_code']) ? "" : $resultrow['loc_code'];
				$curr_symbl = $resultrow['curr_id']==2 ? "&pound;" : "&euro;";
				$unit_id = $resultrow['unit_id'];
				//$amt = $resultrow['amt'];
				$TSVamt = (float) $resultrow['amt'] * (float) $resultrow['usprice'] ;

		?>
				<tr class="open_rpt_item" id="<?php echo $resultrow['item_type_id'];?>" data-type ="<?php echo $resultrow['itype']?>" data-categoryid ="<?php echo $resultrow['categoryid']?>" data-nm ="<?php echo $resultrow['item_name'];?>">
					
					
					
					<td><?php echo $resultrow['customer_nm'];?></td>
					<td><?php echo $resultrow['owner_nm'];?></td>
					
					<td><?php echo $resultrow['category_name'];?></td>
					<td><?php echo $resultrow['item_name'];?></td>
					<td><?php echo $resultrow['brand_name'];?></td>
					
					<td><?php echo $locSH;?></td>
					<td><?php echo $resultrow['amt'];?></td>
					
					<!--<td><?php echo $curr_symbl.$resultrow['usprice'];?></td>-->
					
					<td><?php echo $curr_symbl.' '.$TSVamt;?></td>
					<td><?php echo $curr_symbl.' '.$resultrow['cost'];?></td>
					
					<td <?php echo $asset_col;?> ><?php echo $resultrow['item_condition'];?></td>
					<td <?php echo $asset_col;?> ><?php echo $resultrow['item_status'];?></td>
					
					
					<td <?php echo $product_col;?> ><?php echo $resultrow['unit_amt'].' '.$unit_id;?></td>
					
				</tr>
			
					
			
		<?php
			}
	}
			
	$stmt_results = null; }
	catch (PDOException $e) {
	print $e->getMessage();
	}

  ?>
  </tbody>
 
</table>
</div>


<!--<link rel="stylesheet" href="../plugins/datatables/jquery.dataTables.min.css">

<link rel="stylesheet" href="../assets/vendors/datatables/extensions/buttons/buttons.bootstrap4.min.css">

<link rel="stylesheet" href="../assets/vendors/datatables/extensions/responsive/dataTables.responsive.min.js">
<script src="../assets/bootstrap/js/popper.min.js"></script>
<script src="../assets/vendors/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" src="../assets/vendor/jszip/jszip.min.js"></script>
<script type="text/javascript" src="../assets/vendor/datatables/extensions/buttons/buttons.html5.min.js"></script>


-->



<script src="../assets/javascript/sqrl_item.js"></script>
<script src="../assets/vendor/jquery/jquery.min.js"></script>
<script src="../assets/vendor/bootstrap/js/popper.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.min.js"></script>



<script src="../assets/vendor/pace/pace.min.js"></script>
<script src="../assets/vendor/stacked-menu/stacked-menu.min.js"></script>
<script src="../assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/dataTables.buttons.min.js"></script>

<script src="../assets/vendor/datatables/extensions/buttons/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/buttons.html5.min.js"></script>
<script src="../assets/vendor/datatables/extensions/buttons/buttons.print.min.js"></script>

<script src="../assets/javascript/theme.min.js"></script>

<script src="../assets/javascript/pages/dataTables.bootstrap.js"></script>
<script src="../assets/javascript/pages/datatables-demo.js"></script>




<script type="text/javascript">

	
jQuery.noConflict()(function ($) { 

    $(document).ready(function() { 
		
		
		$('#rpt_results_tbl').DataTable({
		
		"searching": true,
		pageLength : 5,
		lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
		
		dom: 'Bfrtip'

		});
		
		
		//$('.dataTables_length').addClass('bs-select');
		 
  
	
		
	
	
	});
	
	
});

/*,
		
					  
		  buttons: ['copy','csv',
				{
					extend: 'excelHtml5',
					title: '<?php echo $site_nm; ?>'
				}
				
			]*/
			
			
	$(".open_rpt_item").click(function(e) {

		var iId = this.id;
		var nm = $(this).data('nm');
		var type = $(this).data('type');
		var categoryid = $(this).data('categoryid');
		var divId = $( "#rpt_division option:selected" ).val();
		
		
		vwSrchItem(iId, nm, type, categoryid,divId, 'rpt_results_tbl');
		
		//e.preventDefault();
		//return false;
	});
	
	
	
</script>