$(document).ready(function () {

});
function myFunction(event) {
    var CurrentRow = $(event.target).closest("tr");
    var engr_name = $("td:eq(0)", $(CurrentRow)).html();
    console.log(engr_name);
    $('#name').val(engr_name);
}
function submitt()
{
    //alert('submitted');
    submitForm();
   
}
    function submitForm() {
        var prev_owner='no';
        var x = $('#nam').val();
        var y = $("#pr_name").val();
        
        var z = $("#sales_order").val();
            
        var a = $("#pdm_name").val();
        var b = parseFloat($("#engr_hrs").val());
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
                alert(response);//vishu use this for testing
                //object.reload(forcedReload);
            },
            error: function () {
                alert("Error");
            }
        });
       
}
function viewss()
{
    

        var ItemId = $('#nam').val();
        console.log(ItemId);

        $.ajax({
            type: "POST",
            url: "readEng_hr.php",
            cache: false,
            data: {
                'id': ItemId,




            },
            dataType: 'json',
            success: function (response) {
                //$("#contact").html(response)
                //$("#contact-modal").modal('hide');
                alert(response);
                console.log(response);
                var trHTML = '';
                
                $.each(response[0], function (i, item) {
                    $('#tbody').empty();
                    console.log($.trim(item.Project_name));
                      if(!$.trim(item.Project_name))
                    {
                        console.log('yes');
                        x='null';
                        console.log(item.Project_name);
                    
                    trHTML += '<tr><td style=font-size:12px class=prop__name>' + item.Engineer_name + '</td><td style=font-size:12px class=prop__name>' + item.Sales_order + '</td><td style=font-size:12px class=prop__name>' + x + '</td><td style=font-size:12px class=prop__name>' + item.Engineer_hrs + '</td><td style=font-size:12px class=prop__name>' + item.Date + '</td></tr>';
                    }
                    else
                       
                        {
                        console.log('no');
                        
                        console.log(item.Project_name);
                        trHTML += '<tr><td style=font-size:12px class=prop__name>' + item.Engineer_name + '</td><td style=font-size:12px class=prop__name>' + item.Sales_order + '</td><td style=font-size:12px class=prop__name>' + item.Project_name + '</td><td style=font-size:12px class=prop__name>' + item.Engineer_hrs + '</td><td style=font-size:12px class=prop__name>' + item.Date + '</td></tr>';
                    }  
                });
                $('#tbody').append(trHTML);
            
            },
            error: function () {
                alert("Error");
                
            }
        });
       
    
    }

