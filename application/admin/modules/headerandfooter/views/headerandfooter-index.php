<style>
    .headerandfooter-content-div {
        padding: 0 10px;
    }

    .headerandfooter-title-p {
        font-size: 22px;
        margin-bottom: 30px;
        border-bottom: 1px solid #ff6600;
        padding-bottom: 10px;
    }

    .col-xs-12.main-div-headerandfooter {
        padding: 0;
    }

    .col-xs-12.headerandfooter-title-div {
        margin-bottom: 20px;
    }

    .headerandfooter-view-ul li {
        padding: 0;
        margin-left: 0px;
        margin-bottom: 35px;
        position: relative;
        width: 49%;
    }

    .custom-check-field-label input {
        display: none;
    }

    .custom-radio-check-nk .box {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: transparent;
        border: 2px solid lightgray;
    }

    .headerandfooter-view-ul.list-inline {
        display: flex;
        flex-wrap: wrap;
        margin: 0;
        justify-content: space-between;
        list-style: unset;
    }

    .custom-radio-check-nk input:checked~.box {
        border-color: #ff6600;
        background-color: transparent;
    }

    .checkbox-tick {
        position: absolute;
        top: -16px;
        right: -11px;
        background: #f60;
        border-radius: 50%;
        height: 35px;
        width: 35px;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        display: none;
    }

    .custom-radio-check-nk input:checked~.checkbox-tick {
        display: flex;
    }
</style>
<h3 class="title-hero clearfix">
    Manage Header and Footer
</h3>
<?php $this->load->view('inc-messages'); ?>
<form action="headerandfooter/update/<?php echo $headerandfooterlist['id']; ?>" method="post" enctype="multipart/form-data" name="add_frm" id="add_frm">
    <div class="col-xs-12 main-div-headerandfooter">
        <div class="col-xs-12 headerandfooter-title-div">
            <p class="headerandfooter-title-p">
                Manage Header
            </p>
            <div class="col-xs-12 headerandfooter-content-div">
                <ul class="headerandfooter-view-ul list-inline">
                    <li>
                        <label class="custom-check-field-label custom-radio-check-nk">
                            <input type="radio" name="header_style" value="1" <?php echo  $headerandfooterlist['header_style'] == '1' ? 'checked' : '' ?>>
                            <span class="box">
                            </span>
                            <span class="checkbox-tick">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>
                                <img src="./images/header1.JPG" alt="" class="img-responsive">
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-check-field-label custom-radio-check-nk">
                            <input type="radio" name="header_style" value="2" <?php echo  $headerandfooterlist['header_style'] == '2' ? 'checked' : '' ?>>
                            <span class="box">
                            </span>
                            <span class="checkbox-tick">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>
                                <img src="./images/header3.JPG" alt="" class="img-responsive">
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-check-field-label custom-radio-check-nk">
                            <input type="radio" name="header_style" value="3" <?php echo  $headerandfooterlist['header_style'] == '3' ? 'checked' : '' ?>>
                            <span class="box">
                            </span>
                            <span class="checkbox-tick">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>
                                <img src="./images/header-4.jpg" alt="" class="img-responsive">
                            </span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-xs-12 headerandfooter-title-div">
            <p class="headerandfooter-title-p">
                Manage Footer
            </p>
            <div class="col-xs-12 headerandfooter-content-div">
                <ul class="headerandfooter-view-ul list-inline">
                    <li>
                        <label class="custom-check-field-label custom-radio-check-nk">
                            <input type="radio" name="footer_style" value="1" <?php echo  $headerandfooterlist['footer_style'] == '1' ? 'checked' : '' ?>>
                            <span class="box">
                            </span>
                            <span class="checkbox-tick">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>
                                <img src="./images/footer-1.jpg" alt="" class="img-responsive">
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-check-field-label custom-radio-check-nk">
                            <input type="radio" name="footer_style" value="2" <?php echo  $headerandfooterlist['footer_style'] == '2' ? 'checked' : '' ?>>
                            <span class="box">
                            </span>
                            <span class="checkbox-tick">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>
                                <img src="./images/footer-3.jpg" alt="" class="img-responsive">
                            </span>
                        </label>
                    </li>
                    <li>
                        <label class="custom-check-field-label custom-radio-check-nk">
                            <input type="radio" name="footer_style" value="3" <?php echo  $headerandfooterlist['footer_style'] == '3' ? 'checked' : '' ?>>
                            <span class="box">
                            </span>
                            <span class="checkbox-tick">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </span>
                            <span>
                                <img src="./images/footer-4.JPG" alt="" class="img-responsive">
                            </span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>
        <p align="center"><input type="submit" name="button" id="button" value="Update" class="btn btn-lg btn-primary"></p>
    </div>

</form>