$(document).ready(function() {

    // ON PAGE LOAD RESET ANY INSTANCE OF THE TWO TYPES OF FILTER TO ALL (0)(RESET)
    $('.selector').prop('selectedIndex', 0);
    $('.col_selector').prop('selectedIndex', 0);

    // READ IN ROWS FROM FILTERABLE TABLE
    var rows = $("table.filterable tbody tr:not('.head')");
    var template = $('table.filterable tfoot tr td');

    if(typeof __update_rows__ !== 'undefined'){
        update_total_row(rows,template);
    }

    // IF A ROW SELECTOR FILTER IS CHANGED
    // PROP ALL OTHER FILTERS TO ALL
    // IF FILTER IS CHANGED FROM ONE OPTION TO ALL SHOW ALL ROWS
    // OTHERWIE FILTER ALL ROWS WHOOSE DOM VARIABLE MATCHING THE REMAINDER OF THE ID STRiNG AFTER select_xxxvarnamexxx MATHING THE OPTION SELECTED ON THE FILTER
    $(".selector").on("change",function filter(){
        $('.selector').not(this).prop('selectedIndex',0);
        $('button').removeClass('pressed');
        console.log($(this).children("option:selected").val());
        if($(this).children("option:selected").val() === 'All'){
            rows.show();
            if(typeof __update_rows__ !== 'undefined'){
                update_total_row(rows,template);
            }
        }
        else{
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
            if(typeof __update_rows__ !== 'undefined'){
                update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']'),template);
            }
        }
    });

    // IF A COL SELECTOR FILTER IS CHANGED
    // IF FILTER IS CHANGED FROM ONE OPTION TO ALL SHOW ALL COLUMNS
    // OTHERWIE SHOW/HIDE COLUMNS BY MACTHHING CLASS NAME PER EACH FILTER OPTION
    $(".col_selector").on("change",function filter(){
        if($(this).children("option:selected").val() === 'All'){
            $('td').show();
        }
        else{
            $('td').not($('td.step_detail')).hide();
            $('td.' + $(this).val()).show();
        }
    });
});