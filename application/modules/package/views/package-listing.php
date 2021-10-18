<h1>Packages for <?php echo $show['show_name'];?> Show</h1>
<?php if(count($packages) == 0) { $this->load->view('inc-norecords'); return; }?>
<?php $counter = 0;
foreach($packages as $item) {$counter++;
	?>
        <p><strong><?php echo $item['product_name'];?></strong><br/>
          <?php echo word_limiter($item['product_desc'], 40);?>
           <p align="right"><a href="package/index/<?php echo $item['product_alias'];?>">[more details]</a></p>
        <?php if($counter != count($packages)){ ?>
           <div class="hr_dotted"></div>
      <?php } ?>
<?php } ?>