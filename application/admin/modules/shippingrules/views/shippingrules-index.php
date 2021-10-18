<?php  $this->load->view('inc-messages'); ?>
<div class="">
    <h2 style="text-align:center;color:black;">Manage Shipping Rules</h2>

    <table class="rules-table table border-table " border="" style="margin-top:20px;">
        <tr>
            <td>
                <div>
                    <label for="">Order MIN Weight In Grams</label>
                </div>
                <div>
                    <input id='order-min-weight' type="number"  min="0" >
                </div>
            </td>
            <td>
                <div>
                    <label for=""> Order MAX Weight In Grams</label>
                </div>
                <div>
                    <input id='order-max-weight' type="number"  min="0"  >
                </div>
            </td>
            <td>
                <div>
                    <label for="">2days Postage</label>
                </div>
                <div>
                    <input id='2days-postage' type="number"  step="0.01" min="0" placeholder="0.00" > + VAT
                </div>
            </td>
            <td>
                <div>
                    <label for="">Next Day Delivery</label>
                </div>
                <div>
                    <input id='next-day-delivery' type="number"  step="0.01" min="0" placeholder="0.00"> + VAT
                </div>
            </td>
            <td>
                <div>
                    <label for=""> </label>
                </div>
                <div>
                    <button id='save-rule-btn' type="button" style="background: #495d80;border: none;color: black;padding: 6px 15px;">Add</button>
                </div>
            </td>

        </tr>
    </table>

    <div id="rules-div">
        <table class="rules-table table border-table " style="margin-top:20px;">
            <tr>
                <th style="color:black;">Rule</th>
                <th style="color:black;">Order MIN Weight In Grams</th>
                <th style="color:black;">Order MAX Weight In Grams</th>
                <th style="color:black;">2days Postage</th>
                <th style="color:black;"> Next Day Delivery</th>
                <th style="color:black;">Action</th>
            </tr>
            <?php
                if ($rules) {
                    $sn = 1;
                    foreach ($rules as $item) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo $sn++; ?>
                                </td>
                                <td>
                                    <?php echo $item['order_min_weight'] ?>
                                </td>
                                <td>
                                    <?php echo $item['order_max_weight'] ?>
                                </td>
                                <td>
                                    <?php echo DWS_CURRENCY_SYMBOL . $item['2days_postage'] ?>
                                </td>
                                <td>
                                    <?php echo DWS_CURRENCY_SYMBOL . $item['next_day_delivery'] ?>
                                </td>
                                <td>
                                    <span id="<?php echo $item['id'] ?>" class="remove-rule">Remove</span>
                                </td>
                            </tr>
                        <?php
                    }
                }
            ?>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#save-rule-btn').click(function() {
            var order_min_weight = 0;
            var order_max_weight = 0;
            var two_days_postage = 0;
            var next_day_delivery = 0;

             order_min_weight = $('#order-min-weight').val();
             order_max_weight = $('#order-max-weight').val();
            two_days_postage = $('#2days-postage').val();
            next_day_delivery = $('#next-day-delivery').val();
            if(order_min_weight  == '' || order_min_weight == 0){
                alert('0 not allowed in Order Min Weight!'); 
            }


            if(two_days_postage  == '' || two_days_postage == 0){
                alert('0 not allowed in 2days Postage!');
            }

          
            if (order_min_weight && two_days_postage) {
                $.post('shippingrules/add',
                {
                    order_min_weight : order_min_weight,
                    order_max_weight : order_max_weight,
                    two_days_postage : two_days_postage,
                    next_day_delivery: next_day_delivery
                },
                function(data, status) {
                    if (data) {
                        if (data == 'not-done') {
                            alert('Sorry record not added.')
                        } else if(data == 'duplicate') {
                            alert('There already exist a shipping rule with same weight !');
                        } else {
                            location.reload()
                        }
                    }
                });
            } 
        });

        $('.remove-rule').click(function() {
            var ele = $(this);

            if (confirm('Are you sure to remove this rule ?')) {
                var rule_id = $(this).attr('id');
                $.post('shippingrules/remove',
                {
                    id : rule_id
                },
                function(data, status) {
                    if (data == 'not-done') {
                        alert('Sorry ! Could not process request try later.');
                    } else {
                        $(ele).closest('tr').remove();
                    }
                });
            }
        });
    });
</script>