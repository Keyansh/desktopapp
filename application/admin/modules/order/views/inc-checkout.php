<div class="row text-center">
    <div class="col-sm-6 col-sm-offset-3">
        <br><br> <h2 style="color:#0fad00">Success</h2>
        <img src="http://osmhotels.com//assets/check-true.jpg">
        <p style="font-size:20px;color:#5C5C5C;">
            Quotation for <b><?= $customer['first_name'] . ' ' . $customer['last_name'] ?></b> is placed successfully under quotation number <b><?= $data['quotation_num']; ?></b> with total amount of <?= DWS_CURRENCY_SYMBOL . $data['quotation_total'] ?></b></p>
        <a href="<?= base_url(); ?>" class="btn btn-success">Ok</a>
        <br><br>
    </div>
</div>