<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
    <?php $this->load->view('themes/' . THEME . '/layout/inc-analytic.php'); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo cms_meta_tags(); ?>
    <?php $this->load->view('themes/' . THEME . '/meta/meta_index.php'); ?>
    <base href="<?php echo cms_base_url(); ?>" />
    <?php
    $this->load->view('themes/' . THEME . '/headers/global.php');
    echo cms_head();
    echo cms_css();
    echo cms_js();
    $this->load->view('themes/' . THEME . '/layout/inc-before-head-close.php');
    ?>
</head>
<style>
    #main-form {
        margin-top: 20px;
    }
</style>

<body>
    <section id="main-form">
        <div class="container-fluid">
            <div class="col-xs-12 form-content ">
                <div class="col-xs-12">
                    <input type="text" class="date-input" value="<?= date('d-m-Y') ?>" placeholder="">
                </div>
                <div class="col-xs-12 col-md-8 form-row1">
                    <form id="main-form">
                        <table class="table form-table">
                            <thead>
                                <tr>
                                    <th scope="col">Sr. No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">MRP</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col" colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="first-row">
                                    <td colspan="7" style="text-align: center;color: red;">No item Selected</td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-default-nk">submit</button>
                    </form>
                </div>
                <div class="col-6 col-md-2 form-row2">
                    <p class="items">Items</p>
                    <ol type="1" class="list item-list-display">
                    </ol>
                </div>
                <div class="col-6 col-md-2 form-row3">
                    <?php foreach ($projectsTypes as $value) : ?>
                        <div class="btn1"><button type="button" class="submit-sub-cat" data-id="<?= $value['id']  ?>"> <?= $value['name']  ?></button></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).on('click', '.submit-sub-cat', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var thisval = $(this);
            $.ajax({
                url: "cms/projects",
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    const obj = JSON.parse(data);
                    thisval.parents('.form-row3').find('.active').removeClass('active');
                    thisval.addClass('active');
                    $('.item-list-display').html('');
                    $('.item-list-display').html(obj['html']);

                }
            });
        });

        $(document).on('click', '.list-items', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            $.ajax({
                url: "cms/projectData",
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    const obj = JSON.parse(data);
                    $('.first-row').remove();
                    $('.form-table tbody').append(obj['html']);
                    $('.dynamic').each(function(idx, elem) {
                        $(elem).text(idx + 1);
                    });
                }
            });
        });
        $(document).on('click', '.recyclebin', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });

        $(document).on('submit', '#main-form', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var formData = $(this).serialize();
            $.ajax({
                url: "cms/csvExport",
                type: 'POST',
                data: formData,
                success: function(data) {
                    alert('Csv created');
                    location.reload();
                }
            });
        });

        $(document).on('click', '.cart-qty-plus', function(e) {
            var $n = $(this)
                .parents(".container-qty")
                .find(".qty");
            $n.val(Number($n.val()) + 1);
        });
        $(document).on('click', '.cart-qty-minus', function(e) {
            var $n = $(this)
                .parents(".container-qty")
                .find(".qty");
            var amount = Number($n.val());
            if (amount > 1) {
                $n.val(amount - 1);
            }
        });
    </script>

</body>

</html>