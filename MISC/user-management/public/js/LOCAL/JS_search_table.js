// WHEN A DOCCUMENT LOADS AND THE SEARCH FIELD IS UPDATED
// WITH A KEYSTROKE LOOP THROUGH ALL FIELDS OF THE TABLE
// AND IF A MATCHING STRING IS NOT FOUND IN ANY TD ELEMENTS
// OF A TR HIDE THE WHOLE ROW
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