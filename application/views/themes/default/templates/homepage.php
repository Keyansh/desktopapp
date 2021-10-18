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
                    $('.item-list-display').html('');
                    $('.item-list-display').html(obj['html']);

                }
            });
        });
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
                    $('.item-list-display').html('');
                    $('.item-list-display').html(obj['html']);

                }
            });
        });
    </script>
</body>

</html>







<!DOCTYPE html>
<html>

<head>
    <title>Save form Data in a Text File using JavaScript</title>
    <style>
        * {
            box-sizing: border-box;
        }

        div {
            padding: 10px;
            background-color: #f6f6f6;
            overflow: hidden;
        }

        input[type=text],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type=button] {
            width: auto;
            float: right;
            cursor: pointer;
            padding: 7px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <div>
        <form>
            <!--Add few elements to the form-->

            <div>
                <input type="text" name="txtName" id="txtName" placeholder="Enter your name" />
            </div>
            <div>
                <input type="text" name="txtAge" id="txtAge" placeholder="Enter your age" />
            </div>
            <div>
                <input type="text" name="txtEmail" id="txtEmail" placeholder="Enter your email address" />
            </div>
            <div>
                <select id="selCountry" name="selCountry">
                    <option selected value="">-- Choose the country --</option>
                    <option value="India">India</option>
                    <option value="Japan">Japan</option>
                    <option value="USA">USA</option>
                </select>
            </div>
            <div>
                <textarea id="msg" name="msg" placeholder="Write some message ..." style="height:100px"></textarea>
            </div>

            <!--Add to button to save the data.-->
            <div>
                <input type="button" id="bt" value="Save data to file" onclick="download_csv()" />
            </div>
        </form>
    </div>
</body>
<script>
    let saveFile = () => {
        var formData = $('form').serializeArray();
        console.log(formData);
        // Get the data from each element on the form.
        const name = document.getElementById('txtName');
        const age = document.getElementById('txtAge');
        const email = document.getElementById('txtEmail');
        const country = document.getElementById('selCountry');
        const msg = document.getElementById('msg');

        // This variable stores all the data.
        let data =
            '\r Name: ' + name.value + ' \r\n ' +
            'Age: ' + age.value + ' \r\n ' +
            'Email: ' + email.value + ' \r\n ' +
            'Country: ' + country.value + ' \r\n ' +
            'Message: ' + msg.value;

        // Convert the text to BLOB.
        const textToBLOB = new Blob([formData], {
            type: 'text/csv'
        });
        const sFileName = 'formData.csv'; // The file to save the data.

        let newLink = document.createElement("a");
        newLink.download = sFileName;

        if (window.webkitURL != null) {
            newLink.href = window.webkitURL.createObjectURL(textToBLOB);
        } else {
            newLink.href = window.URL.createObjectURL(textToBLOB);
            newLink.style.display = "none";
            document.body.appendChild(newLink);
        }

        newLink.click();
    }
</script>

<script>
    function download_csv() {

        var formData = $('form').serialize();
        var formArr = formData.split("&");
        var csvValue = [];
        var csvHeader = [];

        formArr.forEach(function(row) {
            var formArrInner = row.split("=");
            csvHeader.push(formArrInner['0']);
            csvValue.push(formArrInner['1']);
        });
        console.log(csvHeader);
        var csv = csvHeader + '\n';
        csv += csvValue + '\n';
        var hiddenElement = document.createElement('a');
        hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
        hiddenElement.target = '_blank';
        hiddenElement.download = 'people.csv';
        hiddenElement.click();
    }
</script>


</html>