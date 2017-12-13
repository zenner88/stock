<?php $name = array(
              'name'        => 'name',
              'id'          => 'name',
              'value'       => $customer->nama,
              'class'       => 'span4',
			  'required'	=> 'required',
			  'data-error'	=> $this->lang->line("name").' '.$this->lang->line("is_required")
            );
			$address = array(
              'name'        => 'address',
              'id'          => 'address',
              'value'       => $customer->alamat,
              'class'       => 'span4',
			  'required'	=> 'required',
			  'data-error'	=> $this->lang->line("address").' '.$this->lang->line("is_required")
            );
			$phone = array(
              'name'        => 'phone',
              'id'          => 'phone',
              'value'       => $customer->kontak,
              'class'       => 'span4',
			  'required'	=> 'required',
			  'data-error'	=> $this->lang->line("phone").' '.$this->lang->line("is_required")
            );
			
		?>
<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(function() {
	$('form').form();
});
</script>
        
<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>


	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>

   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=waiters&view=edit&id=".$id, $attrib);?>

<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("name"); ?></label>
  <div class="controls"> <?php echo form_input($name);?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <?php echo form_input($phone);?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_input($address);?>
  </div>
</div>  
 

<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', $this->lang->line("update_customer"), 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
 