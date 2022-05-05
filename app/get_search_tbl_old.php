<?php 
//Connect to server
require('../getSQL.php');

$customer_id = trim($_POST["customer_id"]);
$site_id = trim($_POST["site_id"]);
$catId = trim($_POST["catId"]);
$catNm = empty($_POST["catNm"]) ? "" : trim($_POST["catNm"]);
$statusId = $_POST["statusId"]==0 ? "" : $_POST["statusId"];
$itemNm = empty($_POST["itemNm"]) ? "" : trim($_POST["itemNm"]);


$sql = "";
$item_str = "";

  if($catId=='a'){
	  
	  $sr_sql = "SELECT 'a' as itype, ac.category_name,ac.id as categoryid,ast.asset_status as item_status, acd.asset_condition as item_condition, al.id as locId,  al.loc_code as loc_code, 1 as amt, at.name as item_name, at.id as item_type_id
			FROM `asset_type` as at, asset_location as al, `asset_category` as ac, `asset_condition` as acd, assets as a LEFT JOIN asset_status as ast ON (ast.id = a.asset_status_id)
            
			WHERE at.category_id = ac.id AND at.id = a.asset_type_id AND a.asset_condition_id = acd.id AND at.id = al.asset_type_id
			AND at.customer_id =".$_POST['customer_id']." AND al.site_id =".$_POST['site_id']." 
			AND ac.category_name LIKE '$catNm'
			AND ast.id like '%$statusId%'
			AND at.name like '%$itemNm%'
			ORDER BY at.name;";
	  
	  $asset_col = "style=''";
  }else if( $catId =='p'){
	  
	   $sr_sqlx = "SELECT 'p' as itype, pc.category_name,pc.id as categoryid, 'NA' as item_status, 'NA' as item_condition, pl.id as locId,  pl.loc_code as loc_code, p.quantity as amt, pt.name as item_name, pt.id as item_type_id
			FROM product_category as pc, product_type as pt LEFT JOIN product_location as pl ON (pt.id = pl.product_type_id), products as p
			WHERE pt.category_id = pc.id AND p.product_type_id = pt.id 
			AND pt.customer_id =".$_POST['customer_id']." AND pc.category_name LIKE '$catNm' AND pt.name like '%$itemNm%' ORDER BY category_name;";
			//site_id
			
		$sr_sql = "SELECT 'p' as itype, pc.category_name,pc.id as categoryid, 'NA' as item_status, 'NA' as item_condition, pl.id as locId,  pl.loc_code as loc_code, p.quantity as amt, pt.name as item_name, pt.id as item_type_id
			FROM product_category as pc, product_type as pt, product_location as pl, products as p WHERE pt.category_id = pc.id AND p.product_type_id = pt.id AND pt.id = pl.product_type_id
			AND pt.customer_id =".$_POST['customer_id']." AND pl.site_id =".$_POST['site_id']." AND pc.category_name LIKE '%$catNm%' AND pt.name like '%$itemNm%' ORDER BY pt.name, amt;";
  
		$asset_col = "style='display:none;'";
  }
  
?>



 <div class="row table-responsive">
 
  <table id="srch_results_tbl" class="table table-hover table-sm row-border table-striped compact" cellspacing="0" width="100%">
  <thead class="" >
    <tr>
      
     <!-- <th class="th-sm">Category</th>-->
      <th width='20%' class="">Name</th>
      <th width='5%'  class="th-sm">Quantity</th>
      <th width='20%'  class="th-sm">Location Code </th>
      <th width='10%'  class="th-sm"  <?php echo $asset_col;?> >Status </th>
      <th width='10%'  class="th-sm"  <?php echo $asset_col;?> >Condition</th>
    </tr>
  </thead>
  <tbody class="table-active">
  
  <?php
  //var dataString = 'catId=' + catId + ' &catNm=' + catNm + '& statusId=' + statusId + '& itemNm=' + itemNm.trim();
  
  
  

  //echo  $sr_sql;

	try {
		$stmt_results = $conn->prepare($sr_sql); 
		$stmt_results->execute(); 
		if ($stmt_results->rowCount()){
			while ($resultrow = $stmt_results->fetch(PDO::FETCH_ASSOC)) {
				$locSh = '';
				$itemnm = $resultrow['item_name'];
				$locSH = is_null($resultrow['loc_code']) ? "" : $resultrow['loc_code'];
		?>
				<tr class="compact open_item" id="<?php echo $resultrow['item_type_id'];?>" data-type ="<?php echo $resultrow['itype']?>" data-categoryid ="<?php echo $resultrow['categoryid']?>" data-nm ="<?php echo $resultrow['item_name'];?>">
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

<link rel="stylesheet" href="../plugins/datatables/jquery.dataTables.min.css">
<link rel="stylesheet" href="../plugins/datatables.net-buttons/css/buttons.dataTables.min.css">
<script src="../plugins/datatables/jquery.dataTables1.10.7.min.js"></script>
<script>
	$(document).ready(function () {	
	
		$('#srch_results_tbl').DataTable();
		$('.dataTables_length').addClass('bs-select');
		
		
		
	
		$(".open_itemX").click(function(e) {
			
		
			//var iId = $(this).data('id');
			var iId = this.id;
			
			
			var nm = $(this).data('nm');
			var type = $(this).data('type');
			var categoryid = $(this).data('categoryid');
			var custId = $( "#srch_customer option:selected" ).val();
			
			openSrchItemT(iId, nm, type, categoryid,custId, 'get_search_tbl');
			//location.href='item.php?iId='+iId+'&inm='+nm+'&itype='+type+'&custId='+custId+'&categoryid='+categoryid;
			
			//e.preventDefault();
			//return false;
		});
		
	
		$(".open_item").click(function(e) {
			
		
			//var iId = $(this).data('id');
			var iId = this.id;
			
			
			var nm = $(this).data('nm');
			var type = $(this).data('type');
			var categoryid = $(this).data('categoryid');
			var custId = $( "#srch_customer option:selected" ).val();
			//alert(nm);
			vwSrchItem(iId, nm, type, categoryid,custId, 'get_search_tbl');
			//openSrchItemT(iId, nm, type, categoryid,custId, 'get_search_tbl');
			//location.href='item.php?iId='+iId+'&inm='+nm+'&itype='+type+'&custId='+custId+'&categoryid='+categoryid;
			
			//e.preventDefault();
			//return false;
		});
		
		
		$(".qvResultRecord").click(function(e) {
		
			var nm = $(this).data('nm');
			var type = $(this).data('type');
			//openQVItem(this.id, nm, type);
		});
		
	});
	
	
		
	
</script>