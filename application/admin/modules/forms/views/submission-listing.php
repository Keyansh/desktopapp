<link rel="stylesheet" type="text/css" href="<?=base_url();?>css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/widgets/datatable/datatable.css">
<script type="text/javascript" src="<?=base_url();?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/widgets/datatable/datatable-tabletools.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('.form-submissions').DataTable({
            autoWidth: true,
            bSort: false,
            columnDefs: [{
                targets: [0, 1, 2, 3],
                orderable: false
            }, ],
            pageLength: 20
        });

    });
</script>

<style>
    .tab-content {
        padding: 20px 0 0 0;
    }
</style>

<h3 class="title-hero clearfix">
    Manage Forms
</h3>

<?php
$this->load->view('inc-messages');
if (count($submissions) == 0) {
    $this->load->view('inc-norecords');
    echo "</div>";
    return;
}
?>

<?php if(isset($forms) && $forms){ ?>
    <ul class="nav nav-tabs">
        <?php
        $j = 1;
         foreach($forms as $form){ ?>
            <li class="<?php echo $j == 1 ? 'active' : ''; ?>"><a data-toggle="tab" href="#<?php echo $form['form_alias']; ?>"><?php echo $form['form_title']; ?></a></li>
        <?php $j++; } ?>
    </ul>
<?php } ?>

<?php if(isset($forms) && $forms){ ?>
    <div class="tab-content">
        <?php
        $i = 1; 
        foreach($forms as $form){ ?>
            <div id="<?php echo $form['form_alias']; ?>" class="tab-pane fade <?php echo $i == 1 ? 'in active' : ''; ?>">
            <table id="example" class="form-submissions" width="100%" cellspacing="0">
                <thead>
                    <?php
                    
                    foreach ($submissions as $submission) {
                        if($submission['form_id'] == $form['id']){
                            $a = 0; 
                            $submission_data = json_decode($submission['form_data'], true);
                            unset($submission_data['form_json']);
                            $table_headers = array_keys($submission_data);
                        ?>
                        <tr>
                            <?php foreach($table_headers as $table_header){ ?>
                                <th>
                                    <?php echo ucfirst(str_replace("_"," ",$table_header)); ?>
                                </th>
                            <?php } ?>
                        </tr>
                    <?php 
                        }
                        $a++;
                        if($a == 1){
                            break;
                        }
                    }?>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $submission) {
                        if($submission['form_id'] == $form['id']){
                            $submission_data = json_decode($submission['form_data'], true);
                            unset($submission_data['form_json']);
                            $table_values = array_values($submission_data);
                        ?>
                        <tr>
                            <?php foreach($table_values as $table_value){ ?>
                                <td>
                                    <?php echo $table_value; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php 
                        }
                    }?>
                </tbody>
            </table>
            </div>
        <?php $i++; } ?>
    </div>
<?php } ?>

