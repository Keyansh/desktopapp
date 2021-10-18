function toggle_item(path, id)
{
    $.post(path,
    {
        'id' : id
    },
    function(data, status)
    {
        if($('#' + id).text() == 'Enable')
        {
            $('#' + id).text('Disable').css('color','black');
        }
        else
        {
            $('#' + id).text('Enable').css('color','grey');
        }
    });
}
