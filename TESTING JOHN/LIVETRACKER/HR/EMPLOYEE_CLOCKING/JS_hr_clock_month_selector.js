$(document).ready(function(){
    var rows = $("table.filterable tr:not('.head')");

    $("#hr_clock_month_buttons button").click(function(){
        $(this).addClass('active');
        $("#hr_clock_month_buttons button").not($(this)).removeClass("active");

        if($(this).text() == 'PIVOT'){
            rows.show();
            rows.filter('[type = total]').hide();
        }
        else{
            month = $(this).text();
            rows.hide();
            rows.filter('[month = ' + month + ']').show();
            console.log(month);
        }
    });
});