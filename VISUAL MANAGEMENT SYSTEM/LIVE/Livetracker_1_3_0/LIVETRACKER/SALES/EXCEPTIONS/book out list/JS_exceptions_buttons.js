$(document).ready(function()
{
    // IF ANY MIDDLE BUTTON (DARK GREY) IS CLICKED
    $(".book_out_groupings_button_holder button").click(function()
    {  
        // READS IN TABLE
        var rows = $("table tr:not(':first')");

        // IF ANY FILTER IS ACTIVE CALL ITS RESPECTIVE FUNTION
        function updatefilter()
        {
            if(document.getElementById("select_project").value != 'All'){filter()}
            if(document.getElementById("select_sales_person").value != 'All'){filter2()};
            if(document.getElementById("select_engineer").value != 'All'){filter3()};
        }

        
        if($(this).attr('stage') == 'expired')
        {
            console.log($(this).attr('stage'));
            $('.book_out_groupings_button_holder button').removeClass('pressed');
            $(this).addClass('pressed');
            rows.removeClass("active_in_selection");
            rows.filter("[exp = Y]").addClass("active_in_selection");
            rows.show();
            rows.not("[exp = Y]").hide();
            updatefilter();
        }
        else if($(this).attr('stage') == 'not_booked_in')
        {
            console.log($(this).attr('stage'));
            $('.book_out_groupings_button_holder button').removeClass('pressed');
            $(this).addClass('pressed');
            rows.removeClass("active_in_selection");
            rows.filter("[nbi = Y]").addClass("active_in_selection");
            rows.show();
            rows.not("[nbi = Y]").hide();
            updatefilter();
        }
        else if($(this).attr('stage') == 'All')
        {
            console.log($(this).attr('stage'));
            $('.book_out_groupings_button_holder button').removeClass('pressed');
            $(this).addClass('pressed');
            rows.removeClass("active_in_selection");
            rows.addClass("active_in_selection");
            rows.show();
            $("#select_customer").prop('selectedIndex', 0);
            $('#select_sales_person').prop('selectedIndex', 0); 
            $("#select_engineer").prop('selectedIndex', 0);
        }
        else
        {
            console.log($(this).attr('stage'));
            $('.book_out_groupings_button_holder button').removeClass('pressed');
            $(this).addClass('pressed');
            rows.removeClass("active_in_selection");
            rows.filter("["+ $(this).attr('stage') + "= Y]").addClass("active_in_selection");
            rows.show();
            rows.not("["+ $(this).attr('stage') +" = Y]").hide();
            updatefilter();
        }



        function filter()
        {
            var project = document.getElementById("select_project").value;
            console.log(project);
            if(project != "All")
            {
                rows.filter("[customer =" + customer + "][class = active_in_selection]").show();
                rows.not("[class = active_in_selection]").hide();
                rows.not("[project =" +project+"]").hide();
            }
            else if(project == "All")
            {
                rows.filter("[class = active_in_selection]").show();
            }
        }
        function filter2()
        {
            var sales_person = document.getElementById("select_sales_person").value;
            if(sales_person != "All")
            {
                rows.filter("[sales_person =" + sales_person + "]").show();
                rows.not("[class = active_in_selection]").hide();
                rows.not("[sales_person =" + sales_person +"]").hide();
            }
            else if(sales_person == "All")
            {
                rows.filter("[class = active_in_selection]").show();
            }
        }
        function filter3()
        {
            var engineer = document.getElementById("select_engineer").value;
            if(engineer != "All")
            {
                rows.filter("[engineer = " + engineer + "][class = active_in_selection]").show();
                rows.not("[class = active_in_selection]").hide();
                rows.not("[engineer =" + engineer +"]").hide();
            }
            else if(engineer == "All")
            {
                rows.filter("[class = active_in_selection]").show();
            }
        }
    });
});
