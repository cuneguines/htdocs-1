$(document).ready(function(){
    var rows = $("table.filterable tr:not('.head')");


    $('.selector').not('.multi_option').on("change", function filter(){
        console.log($(this));
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All'){
            rows.show();
        }
        else{
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
        }
    });

    $('.selector.multi_option').on("change", function filter(){
        if($(this).children("option:selected").val() === 'All'){
            rows.show();
        }
        else{
            select_option = $(this).val();
            rows.hide();
            rows.each(function(){
                //console.log($(this).attr('sales_person'));
                if($(this).attr('engineer').includes(select_option)){
                    $(this).show();
                }
            });
        }
    });
});