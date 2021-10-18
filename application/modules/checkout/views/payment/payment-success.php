<section id="single_product_col">
    <div class="container-fluid null-padding">
        <div class="col-xs-12 product_main_div null-padding">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Order Placed</a></li>
            </ul>
        </div>
        <div class="col-xs-12 about_us_content">
            <p class="about_heading">Your order has been placed successfully</p>
            <p>More items in your mind?</p>
            <p><a style="background-color:#c4016a;border:none;" href="<?= base_url(); ?>" class="btn btn-info">Start Shopping Again</a></p>
        </div>
    </div>
</section>
<section id="newsletter">
    <?php $this->load->view('themes/' . THEME . '/layout/inc-newsletter'); ?>
</section>
<script>
gtag('event', 'purchase', {
      "transaction_id": "<?php echo $orderDetail['order_num']; ?>",
      "affiliation": "Regentclean",
      "value": <?php echo $orderDetail['order_total']; ?>,
      "currency": "GBP",
      "tax": <?php echo $orderDetail['vat']; ?>,
      "shipping": <?php echo $orderDetail['shipping']; ?>,
      "items": <?php echo $jsonitems; ?>
    });
</script>