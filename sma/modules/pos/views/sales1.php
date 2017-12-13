<?php
if($this->input->post('submit')) {
		   
		  $v = "";
		  /*if($this->input->post('name')){
			   $v .= "&name=".$this->input->post('name');
		   }*/ 
		  
		   if($this->input->post('start_date')){
			   $v .= "&start_date=".$this->input->post('start_date');
		   }
		   if($this->input->post('end_date')) {
			    $v .= "&end_date=".$this->input->post('end_date');
		   }
    
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#end_date" ).datepicker();
    $( "#start_date" ).datepicker();
  } );
  </script>
</head>
<body>
<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=pos&view=today_sale", $attrib); ?>

<p><input type="text" id="start_date" name="start_date" placeholder="Tanggal Awal">S/d<input type="text" id="end_date" name="end_date" placeholder="Tanggal Akhir"></p>
<?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?>
<?php echo form_close();?>
<table width="100%" class="stable">
<tr>
<td colspan="2"><h4><?php if (isset($totalsales->date)) { echo $totalsales->date; } else { echo date('l, F j, Y'); } ?></h4></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #EEE;"><h4><?php echo $this->lang->line('cash_sale'); ?>:</h4></td>
<td style="text-align:right; border-bottom: 1px solid #EEE;"><h4><span><?php echo $cashsales; ?></span></h4></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #EEE;"><h4><?php echo $this->lang->line('ch_sale'); ?>:</h4></td>
<td style="text-align:right;border-bottom: 1px solid #EEE;"><h4><span><?php echo $chsales; ?></span></h4></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #DDD;"><h4><?php echo $this->lang->line('cc_sale'); ?>:</h4></td>
<td style="text-align:right;border-bottom: 1px solid #DDD;"><h4><span><?php echo $ccsales; ?></span></h4></td>
</tr>
<tr>
<td width="300px;" style="font-weight:bold;"><h4><?php echo $this->lang->line('total'); ?>:</h4></td>
<td width="200px;" style="font-weight:bold;text-align:right;"><h4><span><?php if(isset($totalsales->total)) { echo $totalsales->total; } else { echo "0.00"; } ?></span></h4></td>
</tr>
</table>

