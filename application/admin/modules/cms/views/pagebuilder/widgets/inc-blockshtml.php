<?php //e($elementData); 
?>
<?php $config = json_decode($elementData['config']); ?>
<?php //e($config)  
?>
<?php if ($elementData['element_alias'] == 'banner') { ?>
    <div class="col-xs-12 main-div-image">
        <div class="img-outer-div" style="margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;">
            <img src="<?php echo $this->config->item('BLOCK_IMAGE_URL') . $elementData['image']; ?>" alt="<?= $elementData['image_alt']  ?>" class="img-responsive" />
        </div>
    </div>
<?php } ?>
<?php if ($elementData['element_alias'] == 'heading') { ?>
    <div class="col-xs-12 main-div-heading">
        <?php if ($config->titletype == 'h1') { ?>
            <h1 style="text-align:<?= $config->position  ?>;margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;font-size:<?= $config->fontsize  ?>px;display:<?php echo  $config->displaytitle == 'no' ? 'none' : 'block' ?>"><?= $elementData['title']  ?></h1>
        <?php } ?>
        <?php if ($config->titletype == 'h2') { ?>
            <h2 style="text-align:<?= $config->position  ?>;margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;font-size:<?= $config->fontsize  ?>px;display:<?php echo  $config->displaytitle == 'no' ? 'none' : 'block' ?>"><?= $elementData['title']  ?></h2>
        <?php } ?>
        <?php if ($config->titletype == 'h3') { ?>
            <h3 style="text-align:<?= $config->position  ?>;margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;font-size:<?= $config->fontsize  ?>px;display:<?php echo  $config->displaytitle == 'no' ? 'none' : 'block' ?>"><?= $elementData['title']  ?></h3>
        <?php } ?>
        <?php if ($config->titletype == 'h4') { ?>
            <h4 style="text-align:<?= $config->position  ?>;margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;font-size:<?= $config->fontsize  ?>px;display:<?php echo  $config->displaytitle == 'no' ? 'none' : 'block' ?>"><?= $elementData['title']  ?></h4>
        <?php } ?>
        <?php if ($config->titletype == 'h5') { ?>
            <h5 style="text-align:<?= $config->position  ?>;margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;font-size:<?= $config->fontsize  ?>px;display:<?php echo  $config->displaytitle == 'no' ? 'none' : 'block' ?>"><?= $elementData['title']  ?></h5>
        <?php } ?>
        <?php if ($config->titletype == 'p') { ?>
            <p style="text-align:<?= $config->position  ?>;margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;font-size:<?= $config->fontsize  ?>px;display:<?php echo  $config->displaytitle == 'no' ? 'none' : 'block' ?>"><?= $elementData['title']  ?></p>
        <?php } ?>
    </div>
<?php } ?>
<?php if ($elementData['element_alias'] == 'text') { ?>
    <div class="col-xs-12 main-div-text ">
        <div class="col-xs-12 text-section" style="margin:<?php echo  $config->margin[0] == '' ? '0' : $config->margin[0] ?>px <?php echo  $config->margin[1] == '' ? '0' : $config->margin[1] ?>px <?php echo  $config->margin[2] == '' ? '0' : $config->margin[2] ?>px <?php echo  $config->margin[3] == '' ? '0' : $config->margin[3] ?>px;padding:<?php echo  $config->padding[0] == '' ? '0' : $config->padding[0] ?>px <?php echo  $config->padding[1] == '' ? '0' : $config->padding[1] ?>px <?php echo  $config->padding[2] == '' ? '0' : $config->padding[2] ?>px <?php echo  $config->padding[3] == '' ? '0' : $config->padding[3] ?>px;">
            <?php echo $elementData['description']; ?>
        </div>
    </div>
<?php } ?>