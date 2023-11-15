$(document).ready(function(){
   
    $('.selector').prop('selectedIndex',0);
    let status = 1;
    var rows = $("table.filterable tbody tr");
    var jobs = $(".project_item");
    var template = $('table.filterable tfoot tr td');


($('#select_datecategory')).on("change",function filter()
{
   
    $('.multiselector_checkbox').addClass('checked');
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
    if($(this).children("option:selected").val() === 'TD')
    {
       
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[today= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    else
    //button for selecting last three days(schedule_bookout page)
    if($(this).children("option:selected").val() === 'YD')
    {
       
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[yesterday= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    else
    //button for selecting last three days(schedule_bookout page)
    if($(this).children("option:selected").val() === 'TW')
    {
       
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[thisweek= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    else
    //button for selecting last three days(schedule_bookout page)
    if($(this).children("option:selected").val() === 'LW')
    {
       
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[lastweek= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    else
    //button for selecting last three days(schedule_bookout page)
    if($(this).children("option:selected").val() === 'TM')
    {
       
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[thismonth= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    else
    //button for selecting last three days(schedule_bookout page)
    if($(this).children("option:selected").val() === 'LM')
    {
       
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[lastmonth= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    else
    //button for selecting last three days(schedule_bookout page)
    if($(this).children("option:selected").val() === 'TY')
    {
        
        $('#bd').prop('disabled', true);

        jobs.show();
        rows.show();
        $('table.filterable tfoot tr').hide();
        selected_value = $(this).children("option:selected").val();
        console.log(selected_value);
        rows.not("[thisyear= " + $(this).children("option:selected").val() + "]").hide();

        
    }
    
    
   
})


});