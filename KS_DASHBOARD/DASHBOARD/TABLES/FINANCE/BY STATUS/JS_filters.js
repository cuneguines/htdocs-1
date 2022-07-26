$(document).ready(function()
{
    var rows = $("table#finance_drilldown tr:not(':first')");

    $("#select_customer").on("change", function t2(){
        $('#select_sales_person').prop('selectedIndex', 0);
        filter_1();
    })

    $("#select_sales_person").on("change", function t2(){
        $('#select_customer').prop('selectedIndex', 0);
        filter_2();
    })

    function filter_1()
    {
        customer = document.getElementById("select_customer").value;
        console.log(customer);

        if(customer == "All")
        {
            rows.show();
        }
        else if(customer !== "All")
        {
            rows.show();
            rows.not("[customer = " + customer + "]").hide();
        }

    }
    function filter_2()
    {
        sales_person = document.getElementById("select_sales_person").value;
        console.log(sales_person);

        if(sales_person == "All")
        {
            rows.show();
        }
        else if(sales_person !== "All")
        {
            rows.show();
            rows.not("[sales_person = " + sales_person + "]").hide();
        }
    }
});