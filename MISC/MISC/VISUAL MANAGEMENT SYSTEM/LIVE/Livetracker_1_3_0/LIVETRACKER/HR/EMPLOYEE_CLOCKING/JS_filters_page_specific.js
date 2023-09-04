$(document).ready(function() {
    $('.selector').prop('selectedIndex', 0);
    var rows = $("table.filterable tr:not('.head')");

    $(".selector").on("change",function filter(){
        $('.selector').not(this).prop('selectedIndex',0);
        $('button').removeClass('pressed');
        if($(this).children("option:selected").val() === 'All'){
            rows.show();
            rows.filter('[rtype = emp_detail]').hide();
            $('.supp_data').hide();
        }
        else if($(this).attr('id') == 'select_employee'){
            $('.supp_data').show();
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
        }
        else{
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
            $('.supp_data').hide();
            rows.filter('[rtype = emp_detail]').hide();
        }
    });
});