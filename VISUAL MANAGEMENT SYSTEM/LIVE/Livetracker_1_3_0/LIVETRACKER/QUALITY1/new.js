$(document).ready(function () 
{
    $('#page-inner_two').hide();
    $('#product_button').click(function () {
        $('.breadcrumb').show();
        $('#page-inner_one').show();


    });
    
    $('#services_button').click(function () {
        $('.breadcrumb').show();
        $('#page-inner_one').hide();
        $('#page-inner_two').show();

    });

      
});