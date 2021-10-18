    <div id="dvContainer">
        <table cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="width:100%;border-spacing: 0px !important;border-collapse: collapse;">
            <tbody><tr>
                <td>
                   <table cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="width:875px;border:0;cellspacing:0;cellpadding:0;bgcolor:#FFFFFF;padding:10px;">
                    <tbody><tr>
                        <td><table cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="width:100%; border:0; cellspacing:0; cellpadding:0;">
                            <tbody><tr>
                                <td width=""><a href="#" target="_blank"><img src="<?= base_url() ?>images/logo.png" border="0" alt=""></a></td>
                                <td width="250">
                                    <table cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="width:100%;">
                                        <tbody><tr>
                                            <td style="height:46px;align:'right';" valign="middle">
                                                <table cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="width:100%;border:0;cellspacing:0; cellpadding:0;">
                                                    <tbody><tr>
                                                        <td style="width:67%;align:'right'" ;="">
                                                            <font style="font-family:'open sans';color:#0087d4;font-size:21.5px;text-transform:uppercase;float: right;">
                                                                <strong>Address: </strong>
                                                            </font>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="67%" align="right">
                                                            <font style="font-family: 'Arial' , sans-serif; color:#68696a; font-size:11.5px;font-weight: 100;">
                                                            <span><?= DWS_ADDRESS; ?></span><br/>
                                                            <span style="font-weight:600; color:#000;">Call us : <?= DWS_TELLNO; ?></span><br/>
                                                            <span style="font-weight:600;color:#000;">Email : <?= DWS_EMAIL_ADMIN; ?></span><br/>
                                                          </font>
                                                      </td>
                                                  </tr>
                                              </tbody></table></td>
                                          </tr>

                                      </tbody></table></td>
                                  </tr>
                              </tbody></table></td>
                          </tr>

                          <tr>
                            <td align="center" valign="middle">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                    <tbody><tr>
                                        <td width="25%" align="left" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">
                                                <span style="font-size:19px;font-weight: bold;color: #414141;">Invoice To</span>
                                            </font>
                                        </td>
                                        <td width="25%" align="right" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">
                                                <span style="font-size:19px;font-weight: 900;color: #000;">&nbsp;</span>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="left" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">
                                                <span><?= $fullOrderDetail['detail']['s_first_name'].' '.$fullOrderDetail['detail']['s_last_name']  ?></span>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="left" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">
                                                <span><?= $fullOrderDetail['detail']['s_address1'].' '.$fullOrderDetail['detail']['s_address2'] ?> 
                                                    <br><?= $fullOrderDetail['detail']['s_city'].' '.$fullOrderDetail['detail']['s_county'].' '.$fullOrderDetail['detail']['s_postcode'] ?>
                                                </span>
                                            </font>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%" align="left" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">

                                                <span></span>
                                            </font>
                                        </td>
                                        <td width="25%" align="right" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">
                                            </font>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="25%" align="left" style="line-height: 22px">
                                            <font style="font-family:'open sans'; color:#68696a; font-size:13px; text-transform:uppercase;">
                                            </font>
                                        </td>
                                        <td width="25%" align="right" style="line-height: 22px">
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>    
                        </tr>
                        <tr>
                            <td align="center" valign="middle">
                                <br/>
                                <input type="hidden" name="invoice_id" value="1">
                                <table class="billing-detail toptable" cellspacing="0" cellpadding="0" border="1" border-spacing="0">
                                    <thead class="tdstyle3">
                                        <tr>
                                            <th width="10%" class="thstyle1">Sr no.</th>
                                            <th width="75%" class="thstyle1">Name</th>
                                            <th width="75%" class="thstyle1">Sku</th>
                                            <th width="75%" class="thstyle1">Quantity</th>
                                            <th width="15%" class="thstyle1">Price(£)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach($fullOrderDetail['items'] as $item): ?>
                                            <tr style="font-family:'open sans'; color:#68696a;font-size:16px;text-align: center;height:70px;">
                                                <td style="">
                                                    <span> <?= $i ?>. </span>
                                                </td>
                                                <td style=""><?= $item['order_item_name'] ?></td>
                                                <td style=""><?= $item['product_sku'] ?></td>
                                                <td style=""><?= $item['order_item_qty'] ?></td>
                                                <td style=""><?= number_format($item['order_item_price'],2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>    

                        <tr>
                            <td align="center" valign="middle">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="">
                                    <tbody><tr>
                                        <td align="center" valign="middle" style="">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" border-spacing="0">
                                                <tr style="font-family:'open sans'; color:#68696a; font-size:16px;text-align: left; ">
                                                    <td></td>
                                                    <th width="14.2%" align="center"  style="background:#e3e3e3 none repeat scroll 0 0;color: #000;text-align: right;  padding-right: 10px !important;line-height: 40px;">Subtotal : </th>
                                                    <td width="14.2%" align="center"  style="color: #000;font-weight: 900;">&pound;<?= $fullOrderDetail['subtotal'] ?> </td>
                                                </tr>
                                                <tr style="font-family:'open sans'; color:#68696a; font-size:16px;text-align: left; ">
                                                    <td></td>
                                                    <th width="14.2%" align="center"  style="background:#e3e3e3 none repeat scroll 0 0;color: #000;text-align: right;  padding-right: 10px !important;line-height: 40px;">Vat : </th>
                                                    <td width="14.2%" align="center"  style="color: #000;font-weight: 900;">&pound;<?= $fullOrderDetail['vat'] ?> </td>
                                                </tr>
                                                <tr style="font-family:'open sans'; color:#68696a; font-size:16px;text-align: left; ">
                                                    <td></td>
                                                    <th width="14.2%" align="center"  style="background:#e3e3e3 none repeat scroll 0 0;color: #000;text-align: right;  padding-right: 10px !important;line-height: 40px;">Shipping <?= $fullOrderDetail['shipping_label']?> : </th>
                                                    <td width="14.2%" align="center"  style="color: #000;font-weight: 900;">&pound;<?= $fullOrderDetail['shipping'] ?> </td>
                                                </tr>
                                                <tr style="font-family:'open sans'; color:#68696a; font-size:16px;text-align: left; ">
                                                    <td></td>
                                                    <th width="14.2%" align="center"  style="background:#e3e3e3 none repeat scroll 0 0;color: #000;text-align: right;  padding-right: 10px !important;line-height: 40px;">Order Total : </th>
                                                    <td width="14.2%" align="center"  style="color: #000;font-weight: 900;">&pound;<?= $fullOrderDetail['order_total'] ?> </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="middle" style="padding-top: 50px;">
                                            <table width="100%" cellspacing="0" cellpadding="0" border="0" border-spacing="0" style="margin-top: 80px !important;">
                                                <tbody><tr style="font-family:'open sans'; color:#68696a; font-size:16px;text-align: left;">
                                                    <td width="100%" align="left" style="padding: 10px 0px 0px 10px;">
                                                        <span style="color:#444;font-size:13px;"> Our Terms and Condition Policy  </span></td>    
                                                    </tr> 
                                                    <tr style="font-family:'open sans'; color:#666; font-size:16px;text-align: left;">
                                                        <td width="100%" align="left" style="">
                                                            <span style="color:#666;font-size:11px;">* &nbsp; All Payments can be made to: Name Here and mailed to the address above</span><br>
                                                            <span style="color:#666;font-size:11px;">* &nbsp; Have questions, need another copy of the work, estimate, or invoice? </span><br>
                                                            <span style="color:#666;font-size:11px;">* &nbsp; Please contact me to address any concerns!</span><br>
                                                        </td>    
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>

                                    </tbody></table>

                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>




        </div>