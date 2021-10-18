<h1>Casestudies</h1>
<?php if(count($casestudies) == 0) { $this->load->view('inc-norecords'); return; }?>
<?php foreach($casestudies as $casestudy) { ?>
<div style="float:left">
        <p style="float:left;margin-right: 20px "><img src="<?php echo ar($this->config->item('CASESTUDY_URL').$casestudy['image'], 190, 134,'casestudy');?>" width="190" /></p>
        <p><strong><?php echo $casestudy['title'];?></strong></p>
          <?php echo word_limiter($casestudy['contents'], 40);?>
          <p style="float:right"><a href="casestudy/details/<?php echo $casestudy['url_alias'];?>">[read more]</a></p>
     
</div>

<?php } ?>
 
<p style="text-align:center"><?php echo $pagination;?></p>