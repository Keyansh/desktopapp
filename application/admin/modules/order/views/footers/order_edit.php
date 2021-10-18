<script type="text/javascript">
    var DWS_PRODUCT = <?php echo $product['id']; ?>;
    var DWS_CATEGORY = <?php echo $procat['cid']; ?>;
    $(window).load(function () {
        attributes(DWS_CATEGORY, DWS_PRODUCT);
    });
</script>
<?php $this->load->view('footers/product_add'); ?>
