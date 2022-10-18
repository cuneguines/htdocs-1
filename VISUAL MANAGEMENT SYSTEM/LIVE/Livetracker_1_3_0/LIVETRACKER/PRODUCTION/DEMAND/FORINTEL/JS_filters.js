$(document).ready(function () {

    // ON PAGE LOAD RESET ANY INSTANCE OF THE TWO TYPES OF FILTER TO ALL (0)(RESET)
    $('.selector').prop('selectedIndex', 0);
    $('.col_selector').prop('selectedIndex', 0);

    // READ IN ROWS FROM FILTERABLE TABLE
    var rows = $("table.filterable tbody tr:not('.head')");
    var template = $('table.filterable tfoot tr td');
    //Find the index of Intel IReland to set as default
    var opts = document.getElementById("select_customer").options;
    for (var i = 0; i < opts.length; i++) {
        if (opts[i].innerText == "Intel Ireland Ltd") {
            //alert("found it at index " + i + " or number " + (i + 1));
            break;
        }

    }
    console.log(i);
    //SET the Default as Intel
    $('#select_customer').prop('selectedIndex', i);
    //Updating the Rows
    var Cust_name="IntelIrelandLtd"
    rows.hide();
    var matches = rows.filter('[customer="'+Cust_name+'"]');
    matches.show();


    if (typeof __update_rows__ !== 'undefined') {
        update_total_row(rows, template);
    }

    // IF A ROW SELECTOR FILTER IS CHANGED
    // PROP ALL OTHER FILTERS TO ALL
    // IF FILTER IS CHANGED FROM ONE OPTION TO ALL SHOW ALL ROWS
    // OTHERWIE FILTER ALL ROWS WHOOSE DOM VARIABLE MATCHING THE REMAINDER OF THE ID STRiNG AFTER select_xxxvarnamexxx MATHING THE OPTION SELECTED ON THE FILTER
    $(".selector").on("change", function filter() {
        $('.selector').not(this).prop('selectedIndex', 0);
        $('button').removeClass('pressed');
        if ($(this).children("option:selected").val() === 'All') {
            rows.show();
            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows, template);
            }
        }
        else {
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']').hide();
            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']'), template);
            }
        }
    });
//Button on click 
$(".bred").click(function()
{
    //jobs.filter("[engineer_nsp = " + $(this).val() + "]").hide();
    rows.filter("[status = complete]").hide();
    alert('removed');
});
$(".bblue").click(function()
{
    //jobs.filter("[engineer_nsp = " + $(this).val() + "]").hide();
    rows.show();
    alert('y');
}
);

$(".laserph").click(function()
{
    alert('hello');
    //jobs.filter("[engineer_nsp = " + $(this).val() + "]").hide();
    //rows.filter("[step_laser = SEQ001\u2714]").parent().hide();
    $('#custom_hr_table').find('tbody').find('[step_laser = SEQ001\u2714]').each(function() {
        
        $(this).parent().hide();
            
        
});
$(".laserps").click(function()
{
   rows.show();
            
        
});
    
    $("#table td.col1:not(:contains('" + $(this).val() + "'))").parent().hide();
    alert('removed');
});
    // IF A COL SELECTOR FILTER IS CHANGED
    // IF FILTER IS CHANGED FROM ONE OPTION TO ALL SHOW ALL COLUMNS
    // OTHERWIE SHOW/HIDE COLUMNS BY MACTHHING CLASS NAME PER EACH FILTER OPTION
    $(".col_selector").on("change", function filter() {
        if ($(this).children("option:selected").val() === 'All') {
            $('td').show();
        }
        else {
            $('td').not($('td.step_detail')).hide();
            $('td.' + $(this).val()).show();
        }
    });

});