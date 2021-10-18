<style>
    .custom-input {
        padding: 0;
    }
    .custom-input input{
        width: auto !important;
        display: none;
    }
    .custom-input input:checked ~ span:before{
        opacity: 1;
    }
    .custom-input span::before {
        content: "\f00c";
        font-family: FontAwesome;
        left: 50%;
        position: absolute;
        top: 6px;
        transform: translate(-50%);
        color: white;
        opacity: 0;
    }
    .custom-input span {
        position: relative;
        display: table;
    }
</style>
<?php if ($tier_price): ?>
    <div class="price-tabs">
        <ul class="nav nav-tabs price-tabs">
            <li class="active"><a data-toggle="tab" href="#pricing">Pricing</a></li>
            <li class="call-list">Ordering more than 100 items? Call us on 0121 247 0020</li>
        </ul>

        <div class="tab-content">
            <div id="pricing" class="tab-pane fade in active">
                <ul class="list-inline items-price-list">
                    <?php foreach ($tier_price as $tier_pric) { ?>
                        <li>
                            <p class="items"><?= $tier_pric['tier_qty'] ?> + item</p>
                            <p class="items-price">&pound;<?= $tier_pric['tier_price'] ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php
$counter = 0;
$available_attributes_values = isset($available_attributes_values) ? $available_attributes_values : false;
// e($available_attributes_values);
// e($attributesIDs,0);
// e($attrArray);

if ($attributesIDs) {
    foreach ($attributesIDs as $keyAt => $attrValArr) {
        ?>
        <div class="product-filters attribute rp8si-info-div product-<?php echo lcfirst($attrValArr['label']); ?>-selection">
            <ul class="list-inline filter-head-ul <?php echo $attrValArr['clas']; ?>-filter-ul">
                <li class="list-inline-item"><span><?php echo $attrValArr['label']; ?></span></li>
                <li class="prod-detail list-inline-item">
                    <?php
                    if ($attrValArr['type'] != "radio") {
                        ?>
                        <select name="attributes[]" class="attr-<?php echo $attrValArr['attr_id']; ?> abc" data-blank-string="Select <?php echo $attrValArr['label']; ?>" data-attr-id="<?php echo $attrValArr['attr_id']; ?>"
                                data-attr-type="Attribute" is-main="<?= $attrValArr['is_main'] ?>">
                                    <?php
                                    if (count($attributesIDs) > 1) {
                                        $kounter = 0;
                                        if ($attrValArr['is_main'] == 1) {
                                            foreach ($attrArray as $x) {
                                                if ($x['attr_id'] == $keyAt) {
                                                    $kounter++;
                                                }
                                            }
                                            $kounter--;
                                        }
                                    }
                                    if ($attrArray) {
                                        ?>
                                <option selected="selected">Select option</option>
                                <?php
                                foreach ($attrArray as $attrVa) {
                                    $disable_flag = FALSE;
                                    if ($keyAt == $attrVa['attr_id']) {
                                        ?>
                                        <option
                                            is-main="<?= $attrValArr['is_main'] ?>" name="<?php echo lcfirst($attrValArr['label']); ?>-selection" class="<?php echo lcfirst($attrValArr['label']); ?> attributes"
                                            id="<?php echo lcfirst($attrValArr['label']); ?>-selection" data-attrid="<?php echo $attrValArr['attr_id']; ?>"
                                            data-parid="<?php echo $pid; ?>" value="<?php echo $attrVa['value'] ?>"
                                            <?php
                                            if ($post_attributes) {
                                                foreach ($post_attributes as $v) {
                                                    if ($attrVa['value'] == $v['value']) {
                                                        ?>selected="selected"<?php
                                                    }
                                                }
                                            }
                                            if (count($attributesIDs) > 1) {
                                                if ($counter > $kounter) {
                                                    if ($available_attributes_values) {
                                                        foreach ($available_attributes_values as $k => $v) {
                                                            if ($v == $attrVa['value']) {
                                                                $disable_flag = 1;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    if ($disable_flag != 1) {
                                                        ?>
                                                        disabled="disabled"
                                                        <?php
                                                    }
                                                }
                                            }
                                            $counter++
                                            ?>
                                            >
                                                <?php echo $attrVa['option']; ?>
                                        </option>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                    <?php } else {
                        ?>
                        <span name="attributes[]" class="attr-<?php echo $attrValArr['attr_id']; ?>" data-blank-string="Select <?php echo $attrValArr['label']; ?>" data-attr-id="<?php echo $attrValArr['attr_id']; ?>"
                              data-attr-type="Attribute" is-main="<?= $attrValArr['is_main'] ?>">
                                  <?php
                                  if (count($attributesIDs) > 1) {
                                      $kounter = 0;
                                      if ($attrValArr['is_main'] == 1) {
                                          foreach ($attrArray as $x) {
                                              if ($x['attr_id'] == $keyAt) {
                                                  $kounter++;
                                              }
                                          }
                                          $kounter--;
                                      }
                                  }
                                  if ($attrArray) {
                                      ?>
                                      <?php
                                      foreach ($attrArray as $attrVa) {
                                          $disable_flag = FALSE;
                                          if ($keyAt == $attrVa['attr_id']) {
                                              ?>
                                        <label class="radio-inline custom-input">
                                            <input type="radio" name="atrributeCheck"
                                                   is-main="<?= $attrValArr['is_main'] ?>" data-name="<?php echo lcfirst($attrValArr['label']); ?>-selection" class="<?php echo lcfirst($attrValArr['label']); ?> abcradion"
                                                   id="<?php echo lcfirst($attrValArr['label']); ?>-selection" data-attrid="<?php echo $attrValArr['attr_id']; ?>"
                                                   data-parid="<?php echo $pid; ?>" value="<?php echo $attrVa['value'] ?>"
                                                   <?php
                                                   if ($post_attributes) {
                                                       foreach ($post_attributes as $v) {
                                                           if ($attrVa['value'] == $v['value']) {
                                                               ?> checked="checked"<?php
                                                           }
                                                       }
                                                   }
                                                   if (count($attributesIDs) > 1) {
                                                       if ($counter > $kounter) {
                                                           if ($available_attributes_values) {
                                                               foreach ($available_attributes_values as $k => $v) {
                                                                   if ($v == $attrVa['value']) {
                                                                       $disable_flag = 1;
                                                                       break;
                                                                   }
                                                               }
                                                           }
                                                           if ($disable_flag != 1) {
                                                               ?>
                                                               disabled="disabled"
                                                               <?php
                                                           }
                                                       }
                                                   }
                                                   $counter++
                                                   ?>>
                                                   <?php
                                                   $Icon_Img = $this->config->item('ATTRIBUTE_OPTION_ICON_PATH') . $attrVa['icon'];
                                                   $title = $attrVa['option'];
                                                   if ($attrVa['icon'] && file_exists($Icon_Img)) {
                                                       $iMAge = $this->config->item('ATTRIBUTE_OPTION_ICON_URL') . $attrVa['icon'];
                                                   } else {
                                                       $iMAge = base_url() . "images/default-icon.jpg";
                                                   }
                                                   ?>
                                            <span><img src="<?php echo $iMAge; ?>" class="img-responsive" title="<?php echo $title; ?>" data-toggle="tooltip" data-placement="top" ></span>
                                        </label>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </span>
                    <?php } ?>
                </li>
            </ul>
        </div>
    <?php }
    ?>
    <div class="">
        <?php
        if ($accessories) {
            ?>
            <p>Optional Accessories</p>
            <?php
            foreach ($accessories as $item) {
                ?>
                <input class='accessory' type="checkbox" name="accessories[]" value="<?php echo $item['id'] ?>"> <?php echo $item['quantity'] . ' * ' . $item['name'] . ' + ' . $item['quantity'] * $item['price'] . ' Ex VAT' ?>
                <br>
                <?php
            }
        }
        ?>
    </div>
    <?php
}
?>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>