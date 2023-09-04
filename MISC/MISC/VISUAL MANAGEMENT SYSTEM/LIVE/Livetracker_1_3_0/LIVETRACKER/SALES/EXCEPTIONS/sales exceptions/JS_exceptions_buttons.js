$(document).ready(function(){
    
    var rows = $("table#sales_exceptions tr:not(':first')");
    $('.grouping_category button').click(function(){
        rows.show();
        $(this).addClass("pressed");
        $(".grouping_category button").not($(this)).removeClass("pressed");
        selected_value = $(this).attr("stage");
        $.each($('.row'),function(){
            if(!JSON.stringify($(this).attr("stage")).includes(selected_value)){
                $(this).hide();
            }
        });
        rows.not("[" + $(this).attr("status_w") + " = Y ]").hide();
    });
});