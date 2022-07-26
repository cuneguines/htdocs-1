$(document).ready(function(){
    $('input').keyup(function() {
        $('.selector').prop('selectedIndex', 0);
        $('button').removeClass('active');
        $.each($('.searchable tr').not(':first'),function(){
            $(this).hide();
            $(this).children().each (function() {
                if(JSON.stringify($(this).text()).toLowerCase().includes($('input').val().toLowerCase())){
                   $(this).parent().show();
                }
            });  
        });
    });
});