<?php 
/*echo "<pre>";
print_r($categories); 
echo "</pre>";*/
?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable();
    });
</script>

<div class="row">
    <div class="col-md-12">
        <div class="form-group pull-right">
            <a href="product_allocation/assign/product_list" class="btn btn-primary">Manage Assign</a>
        </div>

        <div class="form-group pull-right">
            <a href="product_allocation/assign/assigned_category" class="btn btn-primary">Assigned</a>
        </div>
        <div class="form-group pull-right">
            <a href="user" class="btn btn-primary">Manage User</a>
        </div>
    </div>

</div>


<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-responsive" id="datatable-example">
                <thead>
                    <tr>
                        <th style="color:black;">Sr.no.</th>
                        <th style="color:black;">Category Name</th>
                        <th style="color:black;">Type</th>
                        <th style="color:black;">Discount %</th>
                        <th style="color:black;">Special Price</th>
                        <th style="color:black;">Status</th>
                    </tr>
                </thead>
                <tbody>

                    
                    <?php 
                    if(isset($categories))
                    {
                        $i = 1;
                        foreach ($categories as $category) 
                        {
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $category['name']?></td>
                                <td><?php echo $category['assign_type']?></td>
                                <td><?php echo $category['discount']?></td>
                                <td><?php echo $category['special_price']?></td>
                                <td><?php echo $category['active']?'Active':'Inactive'; ?></td>
                            </tr>

                            <?php
                            $i++;

                        }
                    }
                    
                    ?>
                </tbody>
            </table>

            </div>
        </div>
       
    </div>
</div>