<?php
/*echo "<pre>";
print_r($this->session->userdata('assignment'));
//print_r($subCategory);
echo "</pre>";*/
?>

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-example').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "product_allocation/assign/customAssignedPagination",
                "type": "POST"
            },
            "columns": [
                {
                    "data": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { "data": "sku" },
                { "data": "pname" },
                { "data": "cname"},
                { "data": "pprice" },
                { "data": "dis" },
                { "data": "sp"},
                { "data": "active",
                    render: function (data, type, row, meta) {
                        return ((row.active)?"Active":"");
                    }}
            ]
        });
    });
</script>
<div class="row">
    <div class="col-md-12">
        <div class="form-group pull-right">
            <a href="product_allocation/assign/product_list" class="btn btn-primary">Manage Assign</a>
            
            <a href="product_allocation/assign/assigned_products" class="btn btn-primary">Assigned</a>

            <a href="user" class="btn btn-primary">Manage User</a>
        </div>
    </div>

</div>
<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12"> 
            <?php 
                if(isset($product_heading[0]['cname']))
                {
            ?>
                <h3><?php echo ucfirst($product_heading[0]['cname']) ?></h3>
            <?php
                }   
            ?>            
                
                <?php 
               
                ?>
                <p>
                <?php  
                if(isset($products)){
                    $categoryName = $products;
                    $catArray = array();
                    foreach ($categoryName as $categoryList) 
                    {
                        foreach ($categoryList as $category) 
                        {
                            $catArray[] = $category['cname'];
                        }
                    }
                    $catArray = array_unique($catArray);
                    function myfunction($a){
                        return ucfirst($a);
                    }
                    $resultArray = array_map('myfunction', $catArray);
                    print_r(implode(',', $resultArray));
                }
                else{
                    ?>
                    <p class="text-danger">Please select category!</p>
                    <?php
                }
                
                ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-responsive" id="datatable-example">
                <thead>
                    <tr>
                        <th style="color:black;">Sr.no.</th>
                        <th style="color:black;">SKU</th>
                        <th style="color:black;">Product Name</th>
                        <th style="bcolor:black;">Category</th>
                        <th style="color:black;">Price</th>
                        <th style="color:black;">Discount (%)</th>
                        <th style="color:black;">Special Price</th>
                        <th style="color:black;">Status</th>
                    </tr>
                </thead>
                <!-- <tbody>

                    
                    <?php 
                    if(isset($products))
                    {
                        $i = 1;
                        foreach ($products as $product) 
                        {
                            foreach ($product as $pro) 
                            {

                            ?>
                            <tr>
                                <td><?php echo $i; ?>
                                <td><?php echo $pro['sku']; ?></td>
                                <td><?php echo $pro['pname']; ?></td>
                                <td>
                                    <?php echo $pro['cname']; ?>
                                </td>
                                <td><?php echo $pro['pprice']; ?></td>
                                <td><?php echo $pro['dis']; ?> %</td>
                                <td><?php echo $pro['sp']; ?></td>
                                <td><?php echo $pro['active']?'Active':'Inactive'; ?></td>
                            </tr>
                                
                            <?php
                            $i++; 
                            } 
                            
                        }
                    }
                    
                    ?>
                </tbody> -->
            </table>

            </div>
        </div>
       
    </div>
</div>