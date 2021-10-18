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

<body>



    <section id="main-form">
        <div class="container">
            <div class="row form-content ">
                <div class="col-12 col-md-8 form-row1">
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
                            <tr>
                                <td>1</td>
                                <td><input type="text" placeholder="Name"></td>
                                <td><input type="text" placeholder="Quantity"></td>
                                <td><input type="text" placeholder="MRP"></td>
                                <td><input type="text" placeholder="MRP"></td>
                                <td><button type="button">+</button></td>
                                <td><button type="button">-</button></td>
                                <td><span class="recyclebin"><i class="fas fa-trash-alt"></i></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-6 col-md-2 form-row2">
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
            console.log(id);
            $.ajax({
                url: "cms/projects",
                type: 'POST',
                data: {
                    id: id,
                },
                success: function(data) {
                    const obj = JSON.parse(data);
                    console.log(obj);
                    $('.item-list-display').html('');
                    $('.item-list-display').html(obj['html']);

                }
            });
        });
    </script>
</body>

</html>