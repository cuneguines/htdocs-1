$(document).ready(function(){
    $('.selector').prop('selectedIndex', 0);  
    var rows = $("table#production_exceptions tr:not(':first')");
    $(".grouping_category button").click(function(){
        $(".grouping_category button").not($(this)).removeClass("pressed");
        $(this).addClass("pressed");
        rows.hide();
        switch($(this).attr('class').split(' ')[0]){
            case "stage_name" :      rows.filter("[stage = " + $(this).attr('stage') + "]").show(); break;
            case "stage_not_ok_2" :  rows.filter("[stage = " + $(this).attr('stage') + "][overdue = 2W]").show(); break;
            case "stage_not_ok_4" :  rows.filter("[stage = " + $(this).attr('stage') + "][overdue = 2W]").show(); rows.filter("[stage = " + $(this).attr('stage') + "][overdue = 4W]").show(); break;
        }
    });
});

