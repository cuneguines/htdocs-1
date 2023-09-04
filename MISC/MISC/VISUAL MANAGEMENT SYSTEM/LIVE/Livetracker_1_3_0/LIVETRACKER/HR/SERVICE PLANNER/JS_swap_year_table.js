$(document).ready(function()
{
    $('.service_year_selector').click(function(){
        console.log($(this));
        $('.service_year_selector').not(this).removeClass('pressed');
        $(this).addClass('pressed');

        if($(this).attr('id') === 'service_last')
        {
            $('.subtable_container').addClass('hide');
            $('#service_planner_last').removeClass('hide');
        }
        if($(this).attr('id') === 'service_this')
        {
            $('.subtable_container').addClass('hide');
            $('#service_planner_this').removeClass('hide');
        }
        if($(this).attr('id') === 'service_next')
        {
            $('.subtable_container').addClass('hide');
            $('#service_planner_next').removeClass('hide');
        }
    });
});