$(document).ready(function()
    {
        $(".dashboard_option").click(function()
        {
            $('.dashboard_option').removeClass('activebtn')
            $('.dashboard_option').removeClass('inactivebtn')
            $('.dashboard_option').not(this).addClass('inactivebtn')
            $(this).addClass("activebtn")

            group = $(this).attr("id");

            if(group == "sales_option")
            {
                $('.submenu').addClass('invisible')
                $("#sales_menu").removeClass('invisible');   
            }
            if(group == "management_option")
            {
                $('.submenu').addClass('invisible')
                $("#finance_menu").removeClass('invisible');
            }
            if(group == "engineering_option")
            {
                $('.submenu').addClass('invisible')
                $("#engineering_menu").removeClass('invisible');
            }
            if(group == "production_option")
            {
                $('.submenu').addClass('invisible')
                $("#production_menu").removeClass('invisible');
            }
            if(group == "intel_option")
            {
                $('.submenu').addClass('invisible')
                $("#intel_menu").removeClass('invisible');
            }
            if(group == "ncr_option")
            {
                $('.submenu').addClass('invisible')
                $("#ncr_menu").removeClass('invisible');
            }
        });

        $("#reload_button").click(function()
        {
            $('.submenu').addClass('invisible');
            menu = "#"+$('.submenu')[0].getAttribute('id');
            console.log(menu);
            $(".temp"+menu).removeClass('invisible');
        });
    });