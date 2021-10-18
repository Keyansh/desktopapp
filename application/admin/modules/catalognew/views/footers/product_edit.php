<script type="text/javascript">
	
    var DWS_PRODUCT = <?php echo $product['id']; ?>;
    var DWS_CATEGORY = <?= ($product['attr_set_id'])? $product['attr_set_id'] : 0; ?>;
    $(window).load(function () {
       	
        attributes(DWS_CATEGORY, DWS_PRODUCT);
        $('#attribute_set').trigger('change');
    });
    
</script>
<?php $this->load->view('footers/product_add'); ?>
