$(document).ready(function(){
    var rows = $("table tr:not(':first')");
    $(".hr_days").click(function(){
        $('#bd').prop('disabled', true);
        $(".hr_days").not($(this)).removeClass("pressed");
        $(this).addClass("pressed");
        if($('.hr_days.pressed').attr('id') == 712){
            $('#bd').prop('disabled', false);
        }
        $("table tr:not(':first')").each(function(){
            $(this).hide();
            $(this).children().not(':first').each(function(){
                if($(this).children()[0])
                {
                    $(this).children().each(function(){
                        $(this).show();
                        if(Number($(this).attr('days_open')) < Number($('.hr_days.pressed').attr('id')))
                        {
                            $(this).parent().parent().show();
                        }
                        else
                        {
                            $(this).hide();
                        }
                    });
                }
            });
        });
    });
});