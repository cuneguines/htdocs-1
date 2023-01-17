$(document).ready(function()
{
    
    var rows = $("table#finance_drilldown tr:not(':first')");

    $("#select_customer").on("change", function t2(){
        $('#select_engineer').prop('selectedIndex', 0);
        $('#select_ontime_status').prop('selectedIndex', 0);
        filter_1();
    })

    $("#select_engineer").on("change", function t2(){
        $('#select_customer').prop('selectedIndex', 0);
        $('#select_ontime_status').prop('selectedIndex', 0);
        filter_2();
    })

    $("#select_ontime_status").on("change", function t2(){
        $('#select_customer').prop('selectedIndex', 0);
        $('#select_engineer').prop('selectedIndex', 0);
        filter_3();
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
        engineer = document.getElementById("select_engineer").value;
        console.log(engineer);

        if(engineer == "All")
        {
            rows.show();
        }
        else if(engineer !== "All")
        {
            rows.show();
            rows.not("[engineer = " + engineer + "]").hide();
        }
    }
    function filter_3()
    {
        ontime_status = document.getElementById("select_ontime_status").value;
        console.log(ontime_status);

        if(ontime_status == "All")
        {
            rows.show();
        }
        else if(ontime_status !== "All")
        {
            rows.show();
            rows.not("[ontime_status = " + ontime_status + "]").hide();
        }
    }
});