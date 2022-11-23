$(document).ready(function()
{
    var rows = $("table tr:not(':first')");

    // IF ANY MIDDLE BUTTON (DARK GREY) IS CLICKED
    $(".grouping_category button").click(function()
    {
       

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
            sales_person=$('#select_sales_person').val();
            site_contact=$('#select_site_contact').val();
            project=$('#select_project').val();
            console.log(sales_person);
            console.log(site_contact);
            console.log(project);
            $('.grouping_category button').removeClass('pressed');
            //$('.selector').prop('selectedIndex', 0);
            //rows.show();
            //console.log(rows.length());
            $(this).addClass('pressed');
            

            if (site_contact!='All')
           {
            view_filtered_rows();
          }
           else if (sales_person!='All')
           {
            view_filtered_rows();
          }
          else if (project!='All')
          {
           view_filtered_rows();
         }
         else{
            //alert('no');
            rows.show();
            $("tr td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 1)
                {
                    $(this).parent().hide();
                } 
            });
        }
    

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
    $(".reset_buttons").click(function()
    {
alert('Resetting');
$('#select_sales_person').prop('selectedIndex', 0);
$('#select_site_contact').prop('selectedIndex', 0);
$('#select_project').prop('selectedIndex', 0);
$('.grouping_category button').removeClass('pressed');
rows.show();
    });

    function view_filtered_rows()
    {
        //alert('yes');
           //rows.filter("[sales_person =" +sales_person+"]").show();
             $("#shipping tr:visible td.delivery_note_days_open").each(function()
            {
                if($(this).text() > 1)
                {
                    $(this).parent().hide();
                } 
            }); 
    }
});
