$(document).ready(function(){
    var rows = $("table tr:not(':first')");
    $('.dropdown_button').click(function(){
        buttons = $('.dropdown_button');
        if($(this).attr('class').split(' ')[1] === 'active'){
            buttons.filter('[sales_order = ' + $(this).attr('sales_order') + ']').removeClass('active').addClass('inactive');
            rows.filter('[sales_order = ' + $(this).attr('sales_order') + '][subitem = Y]').hide();
        }
        else if($(this).attr('class').split(' ')[1]  === 'inactive'){
            buttons.filter('[sales_order = ' + $(this).attr('sales_order') + ']').removeClass('inactive').addClass('active');
            rows.filter('[sales_order = ' + $(this).attr('sales_order') + '][subitem = Y]').show();
        }
    });
});