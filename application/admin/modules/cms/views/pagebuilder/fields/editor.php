<textarea class="block_contents" id="" cols="30" rows="10" name="<?php echo $field_data['name']; ?>"><?php echo $field_value; ?></textarea>
<script type="text/javascript">
    var BASE_URL = DWS_SITE_URL + "./assets/"; // use your own base url
    tinymce.init({
        selector: ".block_contents",
        theme: "modern",
        // width: 680,
        height: 200,
        relative_urls: false,
        remove_script_host: false,
        // document_base_url: BASE_URL,
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor colorpicker responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | fontsizeselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true,
        external_filemanager_path: BASE_URL + "./filemanager/",
        filemanager_title: "Media Gallery",
        external_plugins: {
            "filemanager": BASE_URL + "./filemanager/plugin.min.js"
        },
        fontsize_formats: "8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 21px 22px 23px 24px 25px 26px 27px 28px 29px 30px 31px 32px 33px 34px 35px 36px 37px 38px 39px 40px 41px 42px 43px 44px 45px 46px 47px 48px 49px 50px 51px 52px 53px 54px 55px 56px 57px 58px 59px 60px",
        setup: function(ed) {
            ed.on('change', function(inst) {
                var editorContent = ed.getContent();
                $('#' + ed.id).val(editorContent);
            });
        }
    });
    // $(document).on('focusin', function(e) {
    //     if ($(e.target).closest(".mce-window").length) {
    //         e.stopImmediatePropagation();
    //     }
    // });
    $('#pageBuilderWidgetsModel').on('hidden.bs.modal', function () {
        tinyMCE.editors=[];
        // $(document).find('.mce-container').remove();
        // $(document).find('.mce-widget').remove();
        // $('#pageBuilderWidgetsModel .form-group').empty();
        // tinymce.remove('.block_contents');
        // $(document).find("#content").tinymce().remove();
    });
</script>