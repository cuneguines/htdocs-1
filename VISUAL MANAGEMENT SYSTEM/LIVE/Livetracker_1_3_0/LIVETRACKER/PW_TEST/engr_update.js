$(document).ready(function () {

});
function myFunction(event) {
    var CurrentRow = $(event.target).closest("tr");
    var engr_name = $("td:eq(0)", $(CurrentRow)).html();
    console.log(engr_name);
    $('#name').val(engr_name);
}
function submitt(e)
{
    //alert('submitted');
    submitForm();
    e.preventdefault();
}
    function submitForm() {
        var prev_owner='no';
        var x = $('#nam').val();
        var y = $("#pr_name").val();
        var z = $("#sales_order").val();
        var a = $("#pdm_name").val();
        var b = parseInt($("#engr_hrs").val());
        var d = $("#ddate").val();
     prev_owner=$("#owner_hidden").val();
    console.log(x)
        console.log(y);
       // console.log(prev_owner);
        parseInt(b);
        console.log(y);
        //console.log(y);
       // console.log(prev_owner);
        console.log(z);
        //console.log(a);
        console.log(b);
        console.log(d);
        //alert('submitted');
        $.ajax({
            type: "POST",
            url: "save_eng.php",
            cache: false,
            data: {
                'nam': x,
                'pr_name': y,
                'sales_order': z,
                'pdm_name':a,
                'engr_hrs': b,
                'date': d,
    
            },
    
            success: function (response) {
                //$("#contact").html(response)
                //console.log(response);
                //$("#contact-modal").modal('hide');
                //alert('input recieved');
                //alert(response);//vishu use this for testing
                //object.reload(forcedReload);
            },
            error: function () {
                alert("Error");
            }
        });
    
}
