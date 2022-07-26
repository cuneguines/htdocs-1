$(document).ready(function(){

    var rows = $("table#production_exceptions tr:not(':first')");
    $(".grouping_category button").click(function(){
        $('.selector').prop('selectedIndex', 0);  
        $(".grouping_category button").not($(this)).removeClass("pressed");
        $(this).addClass("pressed");
        rows.hide();
        switch($(this).attr('class').split(' ')[0]){
            
            case "stage_name" :      rows.filter("[stage = " + $(this).attr('stage') + "]").show(); break;
            case "stage_not_ok_2" :  rows.filter("[stage = " + $(this).attr('stage') + "][overdue = 2W]").show(); break;
            case "stage_not_ok_4" :  rows.filter("[stage = " + $(this).attr('stage') + "][overdue = 2W]").show(); rows.filter("[stage = " + $(this).attr('stage') + "][overdue = 4W]").show(); break;
        }
    });
    $(".grouping_categorys button").click(function()
    {
        $('.selector').prop('selectedIndex', 0);  
        $(".grouping_categorys button").not($(this)).removeClass("pressed");
        $(this).addClass("pressed");
        rows.hide();
        switch($(this).attr('class').split(' ')[0]){
            case "stage_due_Today":  rows.filter("[due =2Today]").show(); break;
            case "stage_due_Tom":  rows.filter("[due =3Tomorrow]").show(); break;
            case "stage_due_day_aft_Tom":  rows.filter("[due =4DayafterTomorrow]").show(); break;
            
            
        }
    });
    
});
