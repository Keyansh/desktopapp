<style>
    @media(min-width: 1650px) {
        #subscriber-area {
            display: none;
        }

        #footer {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
    }
</style>
<section id="single_product_col">
    <div class="container-fluid site-container">
        <div class="col-xs-12 product_main_div">
            <ul class="breadcrumb about_page">
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li class="active"><a href="javascript:void(0)">Forgot Password</a></li>
            </ul>
        </div>
    </div>
</section>
<div id="contents" class="container">
    <div id="returning_customer">
        <!--<h2>Existing Customers</h2>-->
        <?php $this->load->view('inc-messages'); ?>
        <form id="form1" name="form1" method="post" action="customer/forgotpass" class="forgotpassword">
            <div class="form-group clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 forget-pass">
                    <div class="forget-pass-inner">
                        <p class="forget-pass-p1">Forgot Password</p>
                        <div class="input-fp"><input name="email" type="text" class="form-control" id="email" placeholder="Enter Email"></div>
                        <div class="form-group clearfix">
                            <div class="col-lg-12 col-xs-12 fp-btn">
                                <input type="submit" class="btn btn-primary pull-right" value="Submit" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!--            <table width="415" border="0" cellpadding="0" cellspacing="0">
     <tr>
         <td width="82" align="right"></td>
         <td width="333"></td>
     </tr>                
     <tr>
         <td align="right">&nbsp;</td>
         <td>
             <a style='float:left;' href="customer/password"><input type="image" src="images/btn-submit.png"></a>						
         </td>
     </tr>
 </table>-->
        </form>
    </div>
    <div style="clear:both"></div>
</div>