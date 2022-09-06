// KEEPS TRACK ON WHETHER COMMENT TOGGLE IS ON OR OFF (DEFAULT OFF)
$(document).ready(function(){

    $('.selector').prop('selectedIndex',0);

    let status = 1;
    var rows = $("table.filterable tbody tr");
    var jobs = $(".project_item");
    var template = $('table.filterable tfoot tr td');

    if(typeof __update_rows__ !== 'undefined'){
        update_total_row(rows,template);
    }

    $(".selector").not($('#select_engineer')).on("change",function filter()
    {
        $('.selector').not(this).prop('selectedIndex',0);
        $('#bd').prop('disabled', false);

        if($(this).children("option:selected").val() === 'All')
        {
            rows.show();
            jobs.show();
            $('table.filterable tfoot tr').show();
            if(typeof __update_rows__ !== 'undefined'){
                update_total_row(rows,template);
            }
        }
        else
        {
            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
            if(typeof __update_rows__ !== 'undefined'){
                update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']'),template);
            }
        }
        if(status === 0)
        {
            rows.filter('[type = breakdown]').hide();
        }
    });



    ($('#select_engineer')).on("change",function filter()
    {
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All')
        {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        }
        else
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();

            jobs.not("[engineer_nsp = " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_engineer'),function(){
                if(!JSON.stringify($(this).attr("engineers")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
            });
        }
    });

    



    ($('#select_product')).on("change",function filter()
    {
        
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All')
        {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        }
        else
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
console.log(selected_value);
            jobs.not("[product= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_product'),function(){
                if(!JSON.stringify($(this).attr("product")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
    });
    //button for selecting Weekdays (schedule_bookout page)
    ($('#select_days_week')).on("change",function filter()
    {
        
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All')
        {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        }
        else
        //button for selecting last three days(schedule_bookout page)
        if($(this).children("option:selected").val() === 'LastthreeDays')
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
console.log(selected_value);
jobs.not("[lastthreedays= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_days_week'),function(){
                if(!JSON.stringify($(this).attr("lastthreedays")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
        else
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
console.log(selected_value);
            jobs.not("[days_week= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_days_week'),function(){
                if(!JSON.stringify($(this).attr("days_week")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
    });

    $('#bd').click(function(){
        if(status === 1){
            rows.filter('[type = breakdown]').hide();
            status = 0;
        }
        else if(status === 0){
            rows.show();
            $.each($('.selector').not('#select_engineer'),function(index, value){
                if($(this).children("option:selected").val() != 'All'){
                    rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
                }
            });
            status = 1;
        }
    });
});