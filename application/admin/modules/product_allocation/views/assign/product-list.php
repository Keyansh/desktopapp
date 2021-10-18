<?php 
?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    var select_all_products = [];
    $(document).ready(function () {
        // $('#datatable-example').dataTable();
        $('#datatable-example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "product_allocation/assign/customPagination/<?=$user_id?>/<?=$subCategory?>/<?=$assigned?>",
                "type": "POST",
            },
            "columnDefs": [
                {
                    "targets" : 6,
                    "orderable": false,
                    render:function(data,type,row,meta) {
                        return '<input type="text" name="discount['+row.pid+']" value="'+ ((row.dis == null)?"":row.dis) +'" old-value="'+ ((row.dis == null)?"":row.dis) +'" style="width:40px;">  %';
                    }
                },
            ],
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
                { "data": "type" },
                { "data": "pprice" },
                { "data": "dis" },
                // {
                //     "data": "dis",
                //     render:function(data,type,row,meta) {
                //         return '<input type="text" name="discount['+row.pid+']" value="'+ ((row.dis == null)?"":row.dis) +'" old-value="'+ ((row.dis == null)?"":row.dis) +'" style="width:40px;">  %';
                //     }
                // },
                {
                    "data": "sp",
                    render:function(data,type,row,meta) {
                        return '<input type="text" name="specialprice['+row.pid+']" value="'+ ((row.sp == null)?"":row.sp) +'" style="width:50px;">';
                    }
                },
                { 
                    "data": "",
                    render:function(data,type,row,meta) {
                        var tmp = parseInt(row.pid),
                            checked = ''
                            ;
                        if(select_all_products.indexOf(tmp) != -1) {
                            checked = 'checked="true"';
                        }
                        if(checked == '' && select_all_products.length) {
                            select_all_products = [];
                        }
                        return '<input '+checked+' type="checkbox" name="select['+row.pid+']" value="'+row.pid+'" class="btn" '+ ((row.active ==1)?"checked":"")+' ><input type="hidden" name="pid['+row.pid+']" value="'+row.pid+'" style="width:40px;"><input type="hidden" name="cid['+row.pid+']" value="'+row.cid+'" style="width:40px;"><input type="hidden" name="sku['+row.pid+']" value="'+row.sku+'" style="width:40px;">';
                    }
                },
            ]
        });
    });
</script>
<?php 
$form_attr  =
array(
  'name'    =>  'productform',
  "id"    =>  "productform",
  'method'  =>  'post',
  'onsubmit' => 'return formSubmit(this)',
  'role'  =>'form'
  );

echo form_open('',$form_attr); ?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group pull-right">
            <input type="submit" name="submit-products" value="Update" class="btn btn-primary">
            <input type="hidden" name="hiddUserID" value="<?php echo $user_id;?>">
            <?php if($assigned): ?>
            <a href="<?= base_url().'product_allocation/assign/product/'.$user_id.'/'.$subCategory ?>" class="btn btn-primary">All</a>
            <?php endif ?>
            <?php if($assigned != 1): ?>
            <a href="<?= base_url().'product_allocation/assign/product/'.$user_id.'/'.$subCategory.'/1' ?>" class="btn btn-primary">Assigned</a>
            <?php endif ?>
            <?php if($assigned != 2): ?>
            <a href="<?= base_url().'product_allocation/assign/product/'.$user_id.'/'.$subCategory.'/2' ?>" class="btn btn-primary">Un Assigned</a>
            <?php endif ?>
            <a href="user" class="btn btn-primary">Manage User</a>
            <input type="checkbox" name="all" id="productCategory" class="btn btn-primary"> Select All
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
    <?php 
        if(!empty($existAssignedCategory)){
        
            foreach ($existAssignedCategory as $existAssCat) {
                ?>    <div class="alert alert-danger">
                    <?php 
                        echo 'Product Already assigned to this Category <strong>'.$existAssCat['name'].'.</strong> <strong>Category</strong> Will be overwritten after submittion.';
                    ?>
                    </div>
                <?php 
            }

        }
    ?>
       
    </div>

</div>


<div class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12"> 
            <?php 
                if(!empty($product_heading[0]['cname']))
                {
            ?>
                <h3><?php echo ucfirst($product_heading[0]['cname']) ?></h3>
            <?php
                }
            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <table class="table table-bordered table-responsive" id="datatable-example" class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th style="color:black;">Sr.no.</th>
                        <th style="color:black;">SKU</th>
                        <th style="color:black;">Product Name</th>
                        <th style="color:black;">Category</th>
                        <th style="color:black;">Type</th>
                        <th style="color:black;">Price</th>
                        <th style="color:black;" disabled="true">Discount <input type="text" name="discountAll" value="" style="width:40px;">%</th>
                        <th style="color:black;">Special Price</th>
                        <th style="color:black;">Select</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
       
    </div>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
function formSubmit(formId){
    var theForm = document.getElementById(formId); // get the form
    //alert(formId);
    var cb = formId.getElementsByTagName('input'); // get the inputs
    for(var i=0;i<cb.length;i++){ 
        if(cb[i].type=='checkbox' && !cb[i].checked)  // if this is an unchecked checkbox
        {
           cb[i].value = 0; // set the value to "off"
           cb[i].checked = true; // make sure it submits
        }
    }
    return true;
}
$(document).ready(function(){
    $("#productCategory").change(function () {
        $("input:checkbox").each(function() {
            var tmp = parseInt(this.value);
            if($(this).is(':checked') && tmp) {
                select_all_products.splice(select_all_products.indexOf(tmp),1);
            }
            else if(tmp) {
                select_all_products.push(tmp);
            }
        });
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    $(document).on('change','[name="discountAll"]',function(){
        var value = $(this).val();
        if(!$.isNumeric(value)) {
            return;
        }
        value = +value;
        $('[name^="discount"]').each(function(){
            if(value){
                $(this).val(value);
            }
            else {
                $(this).val($(this).attr('old-value'));
            }
        });
    });
})
</script>
