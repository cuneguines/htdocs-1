$(document).ready(function(){
    var rows = $("table.filterable tbody tr");
    var template = $('table.filterable tfoot tr td');

    if(typeof __update_rows__ !== 'undefined'){
        update_total_row(rows,template);
    }

    $(".grouping_category button").click(function(){

        // DISABLE OTHER FILTERS AND BUTTONS + ACTIVATE CURRENT BUTTOn
        
        $('.selector').prop('selectedIndex', 0);    
        $('.grouping_category button').not(this).removeClass("pressed");
        $(this).addClass("pressed");

        // RESTRICT TABLE TO ALL ROWS MACHING THE STAGE OF THE BUTTON HIDE ALL OTHERS 
        rows.show();
        console.log( $(this).attr('stat'));
        $(this).attr('stat') !== "ALL" ? rows.not("[stat = " + $(this).attr('stat') + "]").hide() : console.log("");
        
        // PASS ALL MATCHING ROWS AS JQUERY LIST AND FOOTER TEMPLATE TO UPDATE TOTAL ROWS FUNCTION
        if(typeof __update_rows__ !== 'undefined'){
            update_total_row(rows.filter("[stat = " + $(this).attr('stat') + "]"),template);
        }
    });
    $("#select_product_group").on("change",function (){
        $('#select_product_group_two').empty();
        var productgp2 = [];
        var x= $(this).val();
        console.log(x);
        $.ajax({
            type: "POST",
            url: "SQL_getproductgroup.php",
            cache:false,
            data: {
             'id': x,
             
 
         },
         dataType: 'json',
            success: function(response){
                //$("#contact").html(response)
                //$("#contact-modal").modal('hide');
                console.log(response[0]);
                $.each(response[0][0], function (i) {
                    $.each(response[0][i], function (key, val) {
                        if (key == 'U_Product_Group_Two') {
                            Product_item = val;
                            console.log(val);
                            productgp2.push(val);
                            console.log(productgp2[0]);
                           // $(".nav-second-level")

                                //.append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                        }


                    });
                });



                 //CODE TO FIND THE UNIQUE VALUES FROM THE AJAX CALL 
         for (var i = 0; i < productgp2.length; i++) {
            console.log(productgp2[i]);
        }
        var unique = productgp2.filter((v, i, a) => a.indexOf(v) === i);

        console.log(unique);
        for (var i = 0; i < unique.length; i++) {
            var option = new Option();
            $(option).html(unique[i]);
            //Append the option to our Select element.
            $("#select_product_group_two").append(option);
        }


                //alert('input recieved');
                //location.reload();
            },
            error: function(){
                alert("Error");
            }
        });

        
    });

});