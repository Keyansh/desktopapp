<style media="screen">
    table, tr, td {
        border-collapse: collapse;
    }

    th, td {
        border-style: none;
        padding: 10px;
    }

    .show-on-span {
        cursor: pointer;
    }
</style>

<div class="">
    <h2>
        <strong>Import/Export >> Delete Products</strong>
    </h2>
    <br><br>

    <?php $this->load->view('inc-messages'); ?>

    <div class="" style="float:left;">
        <form action="import/delete_sku" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <input type="file" name="csv" required="required">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br>
                        <input type="submit" value="Submit">
                        <br>
                        <p><?php if ($response) echo $response; ?></p>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
