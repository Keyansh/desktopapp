<style media="screen">
    table, tr, td {
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
    }

    .show-on-span {
        cursor: pointer;
    }
</style>

<div class="">
    <h2>
        Import/Export >> Export Stock
    </h2>
    <br><br>
    <?php $this->load->view('inc-messages'); ?>

    <p>Products = <?php echo $total_products; ?></p>
    <br><br>
    <button id='export-products' type="button" name="button">Export Products</button>
    <button id='export-products-cats' type="button" name="button">Export Product with assigned categories</button>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#export-products').click(function () {
            window.location.href = 'import/export_products/1';
        });
        $('#export-products-cats').click(function () {
            window.location.href = 'import/export_product_cats/1';
        });
    });
</script>
