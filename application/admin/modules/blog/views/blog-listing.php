<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable({
            autoWidth: true,
            bSort: false,
            columnDefs: [
                {
                    targets: [0, 1, 2, 3],
                    orderable: false
                },
            ],
            pageLength: 20
        });

    });</script>
<h3 class="title-hero clearfix">
    Manage Blog
    <a href="blog/add" class="pull-right btn btn-primary">Add Blog</a>
</h3>
<?php
$this->load->view('inc-messages');
if (count($blog) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="color: black;" width="10%">#</th>
            <th style="color: black;" width="20%">Blog Title</th>
            <th style="color: black;">Content</th>            
            <th  style="color: black;" width="10%">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($blog as $item) { ?>
            <tr>
                <td><img src="<?php echo $this->config->item('BLOG_THUMBNAIL_URL') . $item['blog_image']; ?>" width="75"/></td>
                <td><?php echo $item['blog_title']; ?></td>
                <td><?php echo character_limiter(strip_tags($item['blog_contents']), 250); ?></td>
                <td>
                    <a href="blog/edit/<?php echo $item['blog_id']; ?>"class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Edit'><i class="glyph-icon icon-linecons-pencil"></i></a>
                    | <a href="blog/delete/<?php echo $item['blog_id']; ?>" onclick="return confirm('Are you sure you want to delete this Blog?');"  class='tooltip-button' data-toggle='tooltip' data-placement='top' title='Delete'><i class="glyph-icon icon-linecons-trash red-color"></i></a>
                </td>
            <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Blog Title</th>
            <th>Content</th>            
            <th width="10%">Actions</th>
        </tr>
    </tfoot>
</table>