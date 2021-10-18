<h1><?php echo $casestudy['title'];?></h1>
<p style="float:left;margin-right: 20px"><a href="<?php echo $this->config->item('CASESTUDY_URL').$casestudy['image'];?>" class="thickbox"><img src="<?php echo ar($this->config->item('CASESTUDY_PATH').$casestudy['image'], 190, 134,'casestudy');?>" width="190" /></a></p>
<?php echo $casestudy['contents'];?>
