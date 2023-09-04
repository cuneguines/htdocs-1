$(document).ready(function(){
    var rows = $("table.filterable tbody tr");
    var template = $('table.filterable tfoot tr td');

    if(typeof __update_rows__ !== 'undefined'){
        update_total_row(rows,template);
    }

    $(".grouping_category button").click(function(){

        // DISABLE OTHER FILTERS AND BUTTONS + ACTIVATE CURRENT BUTTOn
        $('.selector').prop('selectedIndex', 0);    
        $('.grouping_category button').not(this).removeClass("pressed");
        $(this).addClass("pressed");

        // RESTRICT TABLE TO ALL ROWS MACHING THE STAGE OF THE BUTTON HIDE ALL OTHERS 
        rows.show();
        $(this).attr('stage') !== "All" ? rows.not("[stage = " + $(this).attr('stage') + "]").hide() : console.log("");
        
        // PASS ALL MATCHING ROWS AS JQUERY LIST AND FOOTER TEMPLATE TO UPDATE TOTAL ROWS FUNCTION
        if(typeof __update_rows__ !== 'undefined'){
            update_total_row(rows.filter("[stage = " + $(this).attr('stage') + "]"),template);
        }
    });
});