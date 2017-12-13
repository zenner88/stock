<script src="<?php echo $this->config->base_url(); ?>assets/js/validation.js"></script>
<script type="text/javascript">
$(function() {
	$('form').form();
});
</script>

<?php if($message) { echo "<div class=\"alert alert-error\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>"; } ?>


	<h3 class="title"><?php echo $page_title; ?></h3>
	<p><?php echo $this->lang->line("enter_info"); ?></p>

   	<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=waiters&view=add", $attrib);?>

<div class="control-group">
  <label class="control-label" for="name"><?php echo $this->lang->line("name"); ?></label>
  <div class="controls"> <?php echo form_input($name, '', 'class="span4" id="name" pattern=".{2,55}" required="required" data-error="'.$this->lang->line("name").' '.$this->lang->line("is_required").'"');?>
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="phone"><?php echo $this->lang->line("phone"); ?></label>
  <div class="controls"> <input type="tel" name="phone" class="span4" pattern="[0-9]{7,15}" required="required" data-error="<?php echo $this->lang->line("phone").' '.$this->lang->line("is_required"); ?>" />
  </div>
</div> 
<div class="control-group">
  <label class="control-label" for="address"><?php echo $this->lang->line("address"); ?></label>
  <div class="controls"> <?php echo form_input($address, '', 'class="span4" id="address" pattern=".{2,255}" required="required" data-error="'.$this->lang->line("address").' '.$this->lang->line("is_required").'"');?>
  </div>
</div>  

<div class="control-group">
  <div class="controls"> <?php echo form_submit('submit', 'Tambahkan Waiters', 'class="btn btn-primary"');?> </div>
</div>
<?php echo form_close();?> 
   