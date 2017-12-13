<style type="text/css">
.loader { background-color: #CF4342; color: white; top: 30%; left: 50%; margin-left: -50px; position: fixed; padding: 3px; width:100px;	height:100px; background:url('<?php echo $this->config->base_url(); ?>assets/img/wheel.gif') no-repeat center; }
.blackbg { z-index: 5000; background-color: #666; -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)"; filter: alpha(opacity=20); opacity: 0.2; width:100%; height:100%; top:0; left:0; position:absolute;}
</style>
<link href="<?php echo $this->config->base_url(); ?>assets/css/bootstrap-fileupload.css" rel="stylesheet">
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
						// form_dropdown('tax_rate', $tr, (isset($_POST['tax_rate']) ? $_POST['tax_rate'] : DEFAULT_TAX), 'id="tax_rate" name="test[]" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("product_tax").'" required="required" data-error="'.$this->lang->line("product_tax").' '.$this->lang->line("is_required").'"');
            // $(wrapper).form_dropdown('tax_rate', $tr, (isset($_POST['tax_rate']) ? $_POST['tax_rate'] : DEFAULT_TAX), 'id="tax_rate" name="test[]" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("product_tax").'" required="required" data-error="'.$this->lang->line("product_tax").' '.$this->lang->line("is_required").'"'); //add input box
            
						$(wrapper).append('<div><select name="test[]"><?php foreach($pororos as $pororo){echo '<option value="'.$pororo->code.'">'.$pororo->name.'</option>';} ?></select><input type="text" name="jml[]" placeholder="Jumlah"><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

$(document).ready(function(){
	$('form').form();
		$('#category').change(function() {
			var v = $(this).val();
			$('#loading').show();
					$.ajax({
					  type: "get",
					  async: false,
					  url: "index.php?module=products&view=getSubCategories",
					  data: { <?php echo $this->security->get_csrf_token_name(); ?>: "<?php echo $this->security->get_csrf_hash() ?>", category_id: v },
					  dataType: "html",
					  success: function(data) {
						if(data != "") {
							$('#subcat_data').empty();
							$('#subcat_data').html(data);
						} else {
							$('#subcat_data').empty();
							var default_data = '<select name="subcategory" class="span4" id="subcategory" data-placeholder="<?php echo $this->lang->line("select_category_to_load"); ?>"></select>';
							$('#subcat_data').html(default_data);
							bootbox.alert('<?php echo $this->lang->line('no_subcategory'); ?>');
						}
					  },
					  error: function(){
       					bootbox.alert('<?php echo $this->lang->line('ajax_error'); ?>');
						$('#loading').hide();
    				  }
					  
					});
					$("form select").chosen({no_results_text: "No results matched", disable_search_threshold: 5, allow_single_deselect:true });
					$('#loading').hide();
		});
	});

</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>

	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_product_info"); ?></p>
    
	<?php $attrib = array('class' => 'form-horizontal'); echo form_open_multipart("module=products&view=edit&id=".$id, $attrib); ?>

<div class="control-group">
  <label class="control-label" for="code"><?php echo $this->lang->line("product_code"); ?></label>
  <div class="controls"> <?php echo form_input('code', $product->code, 'class="span4 tip" id="code" title="'.$this->lang->line("pr_code_tip").'" required="required" data-error="'.$this->lang->line("product_code").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("product_name"); ?></label>
  <div class="controls"> <?php echo form_input('name', $product->name, 'class="span4 tip" id="name" title="'.$this->lang->line("pr_name_tip").'" required="required" data-error="'.$this->lang->line("product_name").' '.$this->lang->line("is_required").'"');?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="category"><?php echo $this->lang->line("category"); ?></label>
  <div class="controls">  <?php 
	  $cat[''] = "";
	  	foreach($categories as $category) {
    		$cat[$category->id] = $category->name;
		}
		echo form_dropdown('category', $cat, $product->category_id, 'class="tip chzn-select span4" id="category" data-placeholder="'.$this->lang->line("select")." ".$this->lang->line("category").'" title="'.$this->lang->line("pr_category_tip").'" required="required" data-error="'.$this->lang->line("category").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="subcategory"><?php echo $this->lang->line("subcategory"); ?></label>
  <div class="controls" id="subcat_data"> <?php 
	   	$sct[""] = '';
	   	foreach($subcategories as $subcategory) {
    		$sct[$subcategory->id] = $subcategory->name;
		}
			echo form_dropdown('subcategory', $sct, $product->subcategory_id, 'class="span4" id="subcategory"  data-placeholder="'.$this->lang->line("select_category_to_load").'"');  ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="unit"><?php echo $this->lang->line("product_unit"); ?></label>
  <div class="controls"> <?php echo form_input('unit', $product->unit, 'class="span4 tip" id="unit" title="'.$this->lang->line("pr_unit_tip").'" required="required" data-error="'.$this->lang->line("product_unit").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="size"><?php echo $this->lang->line("size"); ?></label>
  <div class="controls"> <?php echo form_input('size', $product->size, 'class="span4 tip" id="size" title="'.$this->lang->line("pr_size_tip").'"'); ?> </div>
</div>

<div class="control-group">
  <label class="control-label" for="cost"><?php echo $this->lang->line("product_cost"); ?></label>
  <div class="controls"> <?php echo form_input('cost', $product->cost, 'class="span4 tip" id="cost" title="'.$this->lang->line("pr_cost_tip").'" required="required" data-error="'.$this->lang->line("product_cost").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="price"><?php echo $this->lang->line("product_price"); ?></label>
  <div class="controls"> <?php echo form_input('price', $product->price, 'class="span4 tip" id="price" title="'.$this->lang->line("pr_price_tip").'" required="required" data-error="'.$this->lang->line("product_price").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="alert_quantity"><?php echo $this->lang->line("alert_quantity"); ?></label>
  <div class="controls"> <div class=" span4 input-prepend">
          <span class="add-on" style="padding:1px 5px 7px;"><input type="checkbox" name="track_quantity" id="inlineCheckbox1" value="1" <?php echo $product->track_quantity ? 'checked="checked"' : ''; ?>></span>
    <?php echo form_input('alert_quantity', (isset($_POST['alert_quantity']) ? $_POST['alert_quantity'] : $product->alert_quantity), 'class="input-block-level" id="alert_quantity" required="required" data-error="'.$this->lang->line("alert_quantity").' '.$this->lang->line("is_required").'" onClick="this.select();"'); ?>
    
    </div>
</div>
</div>
<div class="control-group">
  <label class="control-label" id="tax_rate"><?php echo $this->lang->line("product_tax"); ?></label>
  <div class="controls">  <?php 
	  $tr[""] = "";
	   		foreach($tax_rates as $tax){
				$tr[$tax->id] = $tax->name;
			}
		echo form_dropdown('tax_rate', $tr, (isset($_POST['tax_rate']) ? $_POST['tax_rate'] : $product->tax_rate), 'id="tax_rate" data-placeholder="'.$this->lang->line("select").' '.$this->lang->line("product_tax").'" required="required" data-error="'.$this->lang->line("product_tax").' '.$this->lang->line("is_required").'"'); ?> </div>
</div>
<div class="control-group">
  <label class="control-label" for="product_image"><?php echo $this->lang->line("product_image"); ?></label>
  <div class="controls">
<div class="fileupload fileupload-new" data-provides="fileupload">
<span class="btn btn-file"><span class="fileupload-new"><?php echo $this->lang->line("select_image"); ?></span><span class="fileupload-exists"><?php echo $this->lang->line("change"); ?></span><input type="file" name="userfile" id="product_image" /></span>
<span class="fileupload-preview"></span>
<a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
</div>
  </div>
</div>
<div class="control-group">
  <label class="control-label" for="cf1">Menu Resto</label>
  <div class="controls"> <?php 
	   	$menu[1] = YA;
			$menu[0] = TIDAK; 
echo form_dropdown('menu', $menu, $product->menu, 'class="span4" id="menu"  data-placeholder="Menu Resto ?"');  ?> 
  </div>
</div> 
<div class="control-group">
<label class="control-label" for="cf1"><?php echo $this->lang->line("pcf1"); ?></label>
    <div class="controls">
		<div class="input_fields_wrap">
    <button class="add_field_button">Add More Fields</button>
    <div>


			<?php //echo $bom->idBahanBaku;?>
			<?php //echo count($bom);?>
		<!-- <select name="test[]"> -->
    
		
		<!--  -->
		<?php
/*
$value=$_POST ["valuelist"];
$con = mysql_connect("localhost","root","") or die('Could not connect:'.mysql_error());
mysql_select_db("stockmanager", $con) or die('Could not select database.');

$fetch_nurse_name = mysql_query("select b.idProduk, b.idBahanBaku, p.name from bom b left join products p on p.code = b.idBahanBaku WHERE b.idProduk = 'M001'");


while($throw_nurse_name = mysql_fetch_array($fetch_nurse_name)) {
echo '<option   value="'.$throw_nurse_name['idBahanBaku'].'">'.$throw_nurse_name['name'].'</option>';
}
echo "</select>";

for ($i= 0; $i <= count($bom)-1; $i++)
{
	 echo '<div><select name="test[]"><option value="'.$bom->idBahanBaku.'">'.$bom->name.'</option></select><input type="text" name="jml[]" placeholder="Jumlah"><a href="#" class="remove_field">Remove</a></div>';
}
*/

?>				
<?php


	/*		
for ($i= 0; $i <= count($bom); $i++)
{
	 echo '<option value="'.$bom->idBahanBaku.'">'.$bom->name.'</option>';
}
*/

$bom_isi=$pororos;
foreach($bom as $row){
	echo '	<div>
						<select name="test[]">';
							foreach($bom_isi as $row_isi){
	echo'							<option value="'.$row_isi->code.'"  ';
	if($row->idBahanBaku==$row_isi->code){
		echo ' selected ';
	}
	echo'>'.$row_isi->name.'</option>';
							}
	echo'</select><input type="text" name="jml[]" placeholder="Jumlah" ';
	
		echo 'value="'.$row->qty.'"';
	
	echo'><a href="#" class="remove_field">Remove</a></div>';
}

?>

				</select>
<!-- <label class="control-label" for="note">Test</label> -->
</div>
</div>
</div>

<div class="control-group">
<label class="control-label" for="note"><?php echo $this->lang->line("product_details_for_invoice"); ?></label>
  <div class="controls">
  <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : html_entity_decode($product->details)), 'class="input-block-level" id="note" style="margin-top: 10px; height: 100px;"');?> 
 </div>
</div>
        
<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_product"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
<div id="loading" style="display: none;">
<div class="blackbg"></div><div class="loader"></div>
</div>
