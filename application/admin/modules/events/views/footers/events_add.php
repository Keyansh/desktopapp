<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/timepicker/timepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/widgets/datepicker/datepicker.js"></script>
<script type="text/javascript">
    $(function () {
        "use strict";
        $('.bootstrap-datepicker').bsdatepicker({
            format: 'dd-mm-yyyy'
        });
    });

    $(function () {
        "use strict";
        $('.timepicker-example').timepicker();
    });
</script>