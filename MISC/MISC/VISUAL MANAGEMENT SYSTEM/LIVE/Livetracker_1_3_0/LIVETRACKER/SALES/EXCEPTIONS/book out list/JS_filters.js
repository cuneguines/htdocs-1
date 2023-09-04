$(document).ready(function()
{
    var row = $("table tr:not(:first)");
   
    
    $('#select_customer').on("change", function t2() {
        $('.selector').not($(this)).prop('selectedIndex', 0);
        filter();
    });

    $('#select_sales_person').on("change", function t2() {
        $('.selector').not($(this)).prop('selectedIndex', 0);
        filter2();
    });

    $('#select_project').on("change", function t2() {
        $('.selector').not($(this)).prop('selectedIndex', 0);
        filter3();
    });

   function filter()
    {
        var customer = document.getElementById("select_customer").value;
        console.log(customer);
        if(customer != "All")
        {
            row.filter("[customer =" + customer + "][class = active_in_selection]").show();
            row.not("[class = active_in_selection]").hide();
            row.not("[customer =" + customer + "]").hide();
        }
        else if(customer == "All")
        {
            row.filter("[class = active_in_selection]").show();
        } 
    }
    function filter2()
    {
        var sales_person = document.getElementById("select_sales_person").value;
        if(sales_person != "All")
        {
            row.filter("[sales_person =" + sales_person + "]").show();
            row.not("[class = active_in_selection]").hide();
            row.not("[sales_person =" + sales_person +"]").hide();
        }
        else if(sales_person == "All")
        {
            row.filter("[class = active_in_selection]").show();
        }
    }
  /*  function filter3()
    {
        var engineer = document.getElementById("select_engineer").value;
        if(engineer != "All")
        {
            row.filter("[engineer = " + engineer + "][class = active_in_selection]").show();
            row.not("[class = active_in_selection]").hide();
            row.not("[engineer =" + engineer +"]").hide();
        }
        else if(engineer == "All")
        {
            row.filter("[class = active_in_selection]").show();
        }
    }  */
    function filter3()
    {
        var project = document.getElementById("select_project").value;
        console.log(project);
        if(project != "All")
        {
            row.filter("[project =" + project + "][class = active_in_selection]").show();
            row.not("[class = active_in_selection]").hide();
            row.not("[project =" + project + "]").hide();
        }
        else if(project == "All")
        {
            row.filter("[class = active_in_selection]").show();
        }
    } 
});


