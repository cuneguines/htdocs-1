$(document).ready(function()
{


    // IF ANY MIDDLE BUTTON (DARK GREY) IS CLICKED
    $(".grouping_category button").click(function()
    {
        var rows = $("table tr:not(':first')");

        if($(this).attr('stage') == 'All')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
        }
        if($(this).attr('stage') == 'today')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 0)
                {
                    $(this).parent().hide();
                } 
            });
        }
        if($(this).attr('stage') == 'past_day')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 1)
                {
                    $(this).parent().hide();
                } 
            });
        }
        if($(this).attr('stage') == 'three_days')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 3)
                {
                    $(this).parent().hide();
                } 
            });
        }
        if($(this).attr('stage') == 'five_days')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                
                if($(this).text() > 5)
                {
                    $(this).parent().hide();
                }
            });
        }
        if($(this).attr('stage') == 'ten_days')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 10)
                {
                    $(this).parent().hide();
                } 
            });
        }
        if($(this).attr('stage') == 'thirty_days')
        {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 31)
                {
                    $(this).parent().hide();
                } 
            });
        }
    });
});
