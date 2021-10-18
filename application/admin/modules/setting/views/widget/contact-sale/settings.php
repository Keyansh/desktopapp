<h1>Edit Page</h1>
<?php $this->load->view('inc-messages'); ?>
<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data" name="regFrm" id="regFrm">
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="formtable">
	<tr>
	  <th>Area Of Inquiry</th>
	  <td><?php echo form_dropdown('enq_id', $form_emails, set_value('enq_id', $settings['enq_id']), ' class="textfield width_30"'); ?></td>
	</tr>
	<tr>
</tr>
</table>
<p style="text-align:center"><input type="submit" name="button" id="button" value="Save"></p>
</form>