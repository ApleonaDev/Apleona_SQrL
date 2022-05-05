<?php 
//Connect to server
require('../getSQL.php');

$customer_nm = $_POST["customer_nm"];
$site_nm = $_POST["site_nm"];
$customer_id = $_POST["customer_id"];
$site_id = $_POST["site_id"];



$sql = "";
$item_str = "";

 
	  
$sr_sql = "SELECT 'a' as itype, ac.category_name,ac.id as categoryid,ast.asset_status as item_status, acd.asset_condition as item_condition, al.id as locId,  al.loc_code as loc_code, a.quantity as amt, at.name as item_name
, at.id as item_type_id, at.currency as curr_id, at.cost, 'NA' as unit_amt, '' as unit_id, m.name as brand_name
			FROM `asset_type` as at, asset_location as al, maunufacturer m, `asset_category` as ac, `asset_condition` as acd, assets as a LEFT JOIN asset_status as ast ON (ast.id = a.asset_status_id)
            
			WHERE at.category_id = ac.id AND at.id = a.asset_type_id AND a.asset_condition_id = acd.id AND at.id = al.asset_type_id AND at.maunufacturer_id = m.id
			AND at.customer_id =".$_POST['customer_id']." AND al.site_id =".$_POST['site_id']." 
			
			UNION
			
			SELECT 'p' as itype, pc.category_name,pc.id as categoryid, 'NA' as item_status, 'NA' as item_condition, pl.id as locId,  pl.loc_code as loc_code, p.quantity as amt, pt.name as item_name,
			pt.id as item_type_id, pt.currency as curr_id, pt.cost,pt.unit_amount as unit_amt, unit.type as unit_id, m.name as brand_name
			FROM product_category as pc, product_type as pt LEFT JOIN unit ON (pt.unit_id = unit.id), product_location pl, products p, maunufacturer m
			WHERE pt.category_id = pc.id AND p.product_type_id = pt.id AND pt.id = pl.product_type_id AND pt.maunufacturer_id = m.id
			AND pt.customer_id =".$_POST['customer_id']." AND pl.site_id =".$_POST['site_id']." 
			
			ORDER BY category_name,item_name, amt;";
	  


  $asset_col = "";
  $product_col = "";
?>
<!-- REQUIRED JS SCRIPTS -->
	
<!--<link rel="stylesheet" href="../plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="../plugins/datatables.net-buttons/css/buttons.dataTables.min.css">
<script src="../plugins/datatables/jquery.dataTables1.10.7.min.js"></script>-->


<link rel="stylesheet" href="../assets/vendors/datatables/extensions/buttons/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/vendors/datatables/extensions/buttons/dataTables.buttons.min.js">
<link rel="stylesheet" href="../assets/vendors/datatables/extensions/responsive/dataTables.responsive.min.js">
<script src="../assets/vendors/datatables/jquery.dataTables.min.js"></script>


 <div class="row table-responsive">

  <table id="rpt_results_tbl" class="table table-hover table-sm " cellspacing="0" width="100%">
  <thead class="" style="background-color:#ADC0BC;">

	<tr>
      
      <th class="th-sm">Category</th>
      <th class="th-sm">Name</th>
      <th class="th-sm">Brand</th>
      <th class="th-sm">Quantity</th>
      <th class="th-sm">Location Code </th>
      <th class="th-sm"  <?php echo $asset_col;?> >Status </th>
      <th class="th-sm"  <?php echo $asset_col;?> >Condition</th>
	  <th class="th-sm">Cost</th>
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

		?>
				<tr class="compact open_item" id="<?php echo $resultrow['item_type_id'];?>" data-type ="<?php echo $resultrow['itype']?>" data-categoryid ="<?php echo $resultrow['categoryid']?>" data-nm ="<?php echo $resultrow['item_name'];?>">
					
					
					
					<td><?php echo $resultrow['category_name'];?></td>
					<td><?php echo $resultrow['item_name'];?></td>
					<td><?php echo $resultrow['brand_name'];?></td>
					<td><?php echo $resultrow['amt'];?></td>
					<td><?php echo $locSH;?></td>
					
					<td <?php echo $asset_col;?> ><?php echo $resultrow['item_status'];?></td>
					<td <?php echo $asset_col;?> ><?php echo $resultrow['item_condition'];?></td>
					<td><?php echo $curr_symbl.$resultrow['cost'];?></td>
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



<script type="text/javascript" src="../plugins/datatables/Buttons/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../plugins/datatables/JSZip/jszip.min.js"></script>
<script type="text/javascript" src="../plugins/datatables/Buttons/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../js/sqrl_app.js"></script>



<script type="text/javascript">

	
	jQuery.noConflict()(function ($) { // this was missing for me
    $(document).ready(function() { 

	
		  $('#rpt_results_tbl').DataTable({

			  dom: 'Bfrtip',
			  
			  buttons: ['copy','csv',
					{
						extend: 'excelHtml5',
						title: '<?php echo $site_nm; ?>'
					}
					
				]
		
		
			  
			});
			
			
		
      
		
      

    });
});
$(".open_item").click(function() {
			
	
	//var iId = $(this).data('id');
	var iId = this.id;
	
	
	var nm = $(this).data('nm');
	var type = $(this).data('type');
	var categoryid = $(this).data('categoryid');
	var custId = $( "#rpt_customer option:selected" ).val();
	
	openSrchItemR(iId, nm, type, categoryid,custId, 'rpt_results_tbl');
	//location.href='item.php?iId='+iId+'&inm='+nm+'&itype='+type+'&custId='+custId+'&categoryid='+categoryid;
	
	//e.preventDefault();
	//return false;
});
	
		
		
	
	</script>