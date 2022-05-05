<?php 
//Connect to server
require('../getSQL.php');

$division_id = trim($_POST["division_id"]);
$customer_id = trim($_POST["customer_id"]);
$site_id = trim($_POST["site_id"]);
$catId = trim($_POST["catId"]);
$catNm = empty($_POST["catNm"]) ? "" : trim($_POST["catNm"]);
$statusId = $_POST["statusId"]==0 ? "" : $_POST["statusId"];
$itemNm = empty($_POST["itemNm"]) ? "" : trim($_POST["itemNm"]);


$sql = "";
$item_str = "";

  if($catId=='a'){
	  //AND at.customer_id =".$_POST['customer_id']." 
	  $sr_sql = "SELECT 'a' as itype, ac.category_name,ac.id as categoryid,ast.asset_status as item_status, acd.asset_condition as item_condition, al.id as locId,  al.loc_code as loc_code, a.quantity as amt, 
			at.name as item_name, at.id as item_type_id, c.name as customer_nm, o.name as owner_nm
			FROM `asset_type` as at LEFT JOIN customer as c ON (c.id = at.customer_id) LEFT JOIN owner as o ON (o.id = at.owner_id), asset_location as al, `asset_category` as ac, `asset_condition` as acd, assets as a LEFT JOIN asset_status as ast ON (ast.id = a.asset_status_id)
            
			WHERE at.category_id = ac.id AND at.id = a.asset_type_id AND a.asset_condition_id = acd.id AND at.id = al.asset_type_id
			
			
			AND at.division_id =".$_POST['division_id']." 
			
			AND al.site_id =".$_POST['site_id']." 
			AND ac.category_name LIKE '$catNm'
			AND ast.id like '%$statusId%'
			AND at.name like '%$itemNm%'
			ORDER BY at.name;";
	  
	  $asset_col = "style=''";
  }else if( $catId =='p'){
	   //AND pt.customer_id =".$_POST['customer_id']."
			
		$sr_sql = "SELECT 'p' as itype, pc.category_name,pc.id as categoryid, 'NA' as item_status, 'NA' as item_condition, pl.id as locId,  pl.loc_code as loc_code, p.quantity as amt, 
			pt.name as item_name, pt.id as item_type_id, c.name as customer_nm, '' as owner_nm
			FROM product_category as pc , product_type as pt LEFT JOIN customer as c ON (c.id = pt.customer_id), product_location as pl, products as p WHERE pt.category_id = pc.id AND p.product_type_id = pt.id AND pt.id = pl.product_type_id
			 
			AND pt.division_id =".$_POST['division_id']." 
			AND pl.site_id =".$_POST['site_id']." AND pc.category_name LIKE '%$catNm%' AND pt.name like '%$itemNm%' ORDER BY pt.name, amt;";
  
		$asset_col = "style='display:none;'";
  }
  
?>



 <div class="row table-responsive">
  <table id="srch_results_tbl" class="table dt-responsive nowrap dataTable" role="grid" aria-describedby="dt-responsive_info" role="grid">
	<thead>
	<tr role="row">
	<th width="20%" class="sorting"> Client </th>
	<th width="20%" class="sorting"> Owner </th>
	<th style="width:50px" class="sorting_asc" > Name </th>
	<th width="20%" class="sorting"> Quantity </th>
	<th width="20%" class="sorting"> Location </th>
	
	<th width="20%" class="sorting" <?php echo $asset_col;?> > Status </th>
	<th width="20%" class="sorting" <?php echo $asset_col;?> > Condition </th>
	
	</tr>
  </thead>
                      
  
  
  <tbody>
  
  <?php


	try {
		$stmt_results = $conn->prepare($sr_sql); 
		$stmt_results->execute(); 
		if ($stmt_results->rowCount()){
			while ($resultrow = $stmt_results->fetch(PDO::FETCH_ASSOC)) {
				$locSh = '';
				$itemnm = $resultrow['item_name'];
				$locSH = is_null($resultrow['loc_code']) ? "" : $resultrow['loc_code'];
		?>
				<tr class="open_item" id="<?php echo $resultrow['item_type_id'];?>" data-type ="<?php echo $resultrow['itype']?>" data-categoryid ="<?php echo $resultrow['categoryid']?>" data-nm ="<?php echo $resultrow['item_name'];?>">
					
					<td><?php echo $resultrow['customer_nm'];?></td>
					<td><?php echo $resultrow['owner_nm'];?></td>
					<td><?php echo $itemnm;?></td>
					<td><?php echo $resultrow['amt'];?></td>
					<td><?php echo $locSH;?></td>
					
					<td <?php echo $asset_col;?> ><?php echo $resultrow['item_status'];?></td>
					<td <?php echo $asset_col;?> ><?php echo $resultrow['item_condition'];?></td>
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

<script src="../assets/vendor/jquery/jquery.min.js"></script>
-->


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

<script src="../assets/javascript/sqrl_item.js"></script>






<script>
	$(document).ready(function () {	
	
		$('#srch_results_tbl').DataTable(
		{
		
		"searching": true,
		pageLength : 5,
		lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']],
		
		dom: 'Bfrtip'
        

		});
		//$('.dataTables_length').addClass('bs-select');
		
	});
	$(".open_item").click(function(e) {
			//e.preventDefault();
		
			//var iId = $(this).data('id');
			var iId = this.id;
			
			
			var nm = $(this).data('nm');
			var type = $(this).data('type');
			var categoryid = $(this).data('categoryid');
			//var custId = $( "#srch_customer option:selected" ).val();
			var divId = $( "#srch_division option:selected" ).val();
			//alert(nm);
			vwSrchItem(iId, nm, type, categoryid,divId, 'get_search_tbl');
			
			//return false;
			
			
	});
	
		
	
</script>