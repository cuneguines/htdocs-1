$(document).ready(function(){
    var rows = $("table tr:not(':first')");
    $(".grouping_category button").click(function(){
        rows.show();
        rows.not("[stage = " + $(this).attr('stage') + "]").hide();
        $(".grouping_category button").not($(this)).removeClass("pressed");
        $(this).addClass("pressed");
    });
});
