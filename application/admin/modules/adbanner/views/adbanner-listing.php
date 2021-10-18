<h3 class="title-hero clearfix">
    Manage Ad Banners
    <a href="adbanner/add" class="pull-right btn btn-primary">Add Banner</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($banners) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display pad-table border-table" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="20%">Image</th>
            <th width="60%">Heading</th>
            <th width="20%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($banners) {
                foreach ($banners as $item) {
                    ?>
                        <tr style="height:50px;">
                            <td>
                                <img src="<?php echo $this->config->item('AD_BANNER_URL') . $item['image'] ?>" alt="" style="width:25%">
                            </td>
                            <td>
                                <?php echo $item['heading'] ?>
                            </td>
                            <td>
                                <?php
                                    if ($item['active']) {
                                        ?>
                                            <span id="<?php echo $item['id'] ?>" class="toggle-item" style="color:#333333;cursor:pointer;">Disable</span> |
                                        <?php
                                    } else {
                                        ?>
                                            <span id="<?php echo $item['id'] ?>" class="toggle-item" style="color:#333333;cursor:pointer;">Enable</span> |
                                        <?php
                                    }
                                ?>
                                <a href="<?php echo base_url() . 'adbanner/edit/' . $item['id'] ?>">Edit</a> |
                                <a href="<?php echo base_url() . 'adbanner/delete/' . $item['id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php
                }
            }
        ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('.toggle-item').click(function() {
            var current_element = $(this);

            $.post('<?php echo base_url() ?>adbanner/toggle',
            {
                id : current_element.attr('id')
            },
            function (data, status) {
                if (data == 'done') {
                    if (current_element.text() == 'Enable') {
                        current_element.text('Disable');
                    } else {
                        current_element.text('Enable');
                    }
                }
            });
        });
    });
</script>
