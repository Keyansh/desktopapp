<section id="cart-section">
    <div class="container">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cart-main-col">
            <h2>Quotation already confirmed.</h2>
            <p>
                Dear <b><?= $quotation['first_name'] . ' ' . $quotation['last_name'] ?>,</b> <br />
                Your quotation with quotation number <b><?= $quotation['quotation_num'] ?></b> already confirmed. Please call on <b><?= DWS_TELLNO; ?></b> or email on <b><?= DWS_EMAIL_ADMIN; ?></b> for further information.
            </p>
        </div>
    </div>
</section>