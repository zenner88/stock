<html lang="en">
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
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>  
</head>
<body>

<?php $attrib = array('class' => 'form-horizontal'); echo form_open("module=pos&view=today_sale", $attrib); ?>

<div class="container" style="margin-left: 20px ; margin-top: 20px">
    <div style="position: relative; width: 200px">
       <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Awal">
       s/d
       <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Tanggal Awal">
    </div>
</div>
<div class="container" style="margin-top: 20px; margin-left: 160px">
<div style="position: relative; width: 200px">
<?php echo form_submit('submit', $this->lang->line("submit"), 'class="btn btn-primary"');?>
</div>
</div>

<?php echo form_close();?>

<script>
    $('#end_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
        
    });
    
    $('#start_date').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });
</script>
<table width="100%" class="stable">
<tr>
<td colspan="2"><h4><?php if (isset($totalsales->date)) { echo $totalsales->date; } else { echo date('l, F j, Y'); } ?></h4></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #EEE;"><h4><?php echo $this->lang->line('cash_sale'); ?>:</h4></td>



<td style="text-align:right; border-bottom: 1px solid #EEE;"><h4><span><?php echo "Rp " . number_format($cashsales,2,',','.'); ?></span></h4></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #EEE;"><h4><?php echo $this->lang->line('ch_sale'); ?>:</h4></td>
<td style="text-align:right;border-bottom: 1px solid #EEE;"><h4><span><?php echo "Rp " . number_format($chsales,2,',','.'); ?></span></h4></td>
</tr>
<tr>
<td style="border-bottom: 1px solid #DDD;"><h4><?php echo $this->lang->line('cc_sale'); ?>:</h4></td>
<td style="text-align:right;border-bottom: 1px solid #DDD;"><h4><span><?php echo "Rp " . number_format($ccsales,2,',','.'); ?></span></h4></td>
</tr>
<tr>
<td width="300px;" style="font-weight:bold;"><h4><?php echo $this->lang->line('total'); ?>:</h4></td>
<td width="200px;" style="font-weight:bold;text-align:right;"><h4><span><?php if(isset($totalsales->total)) { echo "Rp " . number_format($totalsales->total,2,',','.');} else { echo "Rp 0.00"; } ?></span></h4></td>
</tr>
</table>

</body>
</html>



