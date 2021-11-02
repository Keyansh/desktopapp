<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
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
    ?>
</head>
<style>
   #main-form {
	max-width: 70%;
	margin: auto;
	margin-top: 20px;
}
   .form-row1 {
	padding-bottom: 80px;
}
#submitBtnhold {
	left: 140px;
}

.inner-1-order {
	text-align: right;
	margin-bottom: 10px;
}
.test-first {
	font-size: 17px;
	font-weight: bold;
	width: 200px;
	display: inline-block;
}
.inner-1-order span {
	min-width: 50px;
	display: inline-block;
}
.list {
	padding-left: 0;
	padding-top: 0px;
}

.form-row2 .list .list-items {
	font-weight: 500;
	cursor: pointer;
	list-style: none;
	padding: 5px 15px;
	width: 100%;
	background-color: #2d4779;
	border-radius: 7px;
	color: white;
	transition: 0.2s;
	border: 1px solid #2d4779;
    margin-bottom:10px
}
</style>

<body>
    <section id="main-form">
        <div class="container-fluid">
            <div class="col-xs-12 form-content ">
                <div class="col-xs-12" style="display: flex;align-items: center;justify-content: space-between;">
                    <input type="text" class="date-input" value="<?= date('d-m-Y') ?>" placeholder="">
                    <a href="downloads" class="btn-default-nk" style="max-width: 130px;">Hold Order List</a>
                </div>
                <div class="col-xs-12 col-md-8 form-row1">
                    <form id="mainForm" action="">
                        <table class="table form-table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 60px;">Sr. No.</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col" style="width: 60px;">Qty</th>
                                    <th scope="col" style="width: 60px;">MRP</th>
                                    <th scope="col" style="width: 60px;">Discount</th>
                                    <th scope="col" style="width: 60px;">Amount</th>
                                    <th scope="col" colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="first-row">
                                    <td colspan="7" style="text-align: center;color: red;">No item Selected</td>
                                </tr>
                            </tbody>
                        </table>
                        <button  id="submitBtn" class="btn btn-default-nk">Finish Order</button>
                        <button  id="submitBtnhold" class="btn btn-default-nk">Hold Order</button>
                    </form>
                    <div class="col-xs-12 totle-order">
                        <div class="col-xs-12 inner-1-order">
                            <span class="test-first">Total</span>
                            <span id="amountotal">0</span>
                        </div>
                        <div class="col-xs-12 inner-1-order">
                            <span class="test-first">Discount</span>
                            <span id="discountamount">0</span>
                        </div>
                        <div class="col-xs-12 inner-1-order">
                            <span class="test-first">Payable Amount</span>
                            <span id="nettoalofdw">0</span>
                        </div>
                    </div>
                    
                </div>
                <div class="col-6 col-md-2 form-row2">
                    <p class="items">Items</p>
                    <ul  class="list item-list-display">
                    </ul>
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
                    totalfunction();
                }
            });
        });
        $(document).on('click', '.recyclebin', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
            totalfunction();
        });

        $(document).on('click', '#submitBtn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var formData = $('#mainForm').serialize();
            $.ajax({
                url: "cms/csvExport",
                type: 'POST',
                data: formData,
                success: function(data) {
                    // alert('Csv created');
                    // location.reload();
                }
            });
        });
        $(document).on('click', '#submitBtnhold', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var formData = $('#mainForm').serialize();
            $.ajax({
                url: "cms/insertHold",
                type: 'POST',
                data: formData,
                success: function(data) {
                    alert('Csv created');
                    location.reload();
                }
            });
        }); 

        function totalfunction(){
          var  total = 0;
            $('.amount').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
             $('#nettoalofdw').html(total);
          var  total1 = 0;
            $('.mrp').each(function() {
                total1 += parseFloat($(this).val()) || 0;
            });
             $('#amountotal').html(total1);
          var  total2 = 0;
            $('.discount').each(function() {
                total2 += parseFloat($(this).val()) || 0;
            });
             $('#discountamount').html(total2);
        }

        $(document).on('click', '.cart-qty-plus', function(e) {
            var $n = $(this)
                .parents(".container-qty")
                .find(".qty");
            $n.val(Number($n.val()) + 1);


            var mrp = $(this).parents('.container-qty').find('.mrp').val();
            var discount = $(this).parents('.container-qty').find('.discount').val();
            var qty = $(this).parents('.container-qty').find('.qty').val();
            var rowTotle = qty * mrp - discount;
            var amount = $(this).parents('.container-qty').find('.amount').val(rowTotle);
            totalfunction();
        });

        $(document).on('click', '.cart-qty-minus', function(e) {
            var $n = $(this)
                .parents(".container-qty")
                .find(".qty");
            var amount = Number($n.val());
            if (amount > 1) {
                $n.val(amount - 1);
            }
            var mrp = $(this).parents('.container-qty').find('.mrp').val();
            var discount = $(this).parents('.container-qty').find('.discount').val();
            var qty = $(this).parents('.container-qty').find('.qty').val();
            var rowTotle = qty * mrp - discount;
            var amount = $(this).parents('.container-qty').find('.amount').val(rowTotle);
            totalfunction();
        });



        $(document).on('blur', '.qty', function() {
            var qty = $(this).val();
            var mrp = $(this).parents('.container-qty').find('.mrp').val();
            var discount = $(this).parents('.container-qty').find('.discount').val();
            var rowTotle = qty * mrp - discount;
            var amount = $(this).parents('.container-qty').find('.amount').val(rowTotle);
            totalfunction();
        });
        $(document).on('blur', '.discount', function() {
            var discount = $(this).val();
            var mrp = $(this).parents('.container-qty').find('.mrp').val();
            var qty = $(this).parents('.container-qty').find('.qty').val();
            var rowTotle = qty * mrp - discount;
            var amount = $(this).parents('.container-qty').find('.amount').val(rowTotle);
            totalfunction();
        });
        $(document).on('blur', '.mrp', function() {
            var mrp = $(this).val();
            var qty = $(this).parents('.container-qty').find('.qty').val();
            var discount = $(this).parents('.container-qty').find('.discount').val();
            var rowTotle = qty * mrp - discount;
            var amount = $(this).parents('.container-qty').find('.amount').val(rowTotle);
            var total = 0;
            totalfunction();
        });

        
    </script>

</body>

</html>