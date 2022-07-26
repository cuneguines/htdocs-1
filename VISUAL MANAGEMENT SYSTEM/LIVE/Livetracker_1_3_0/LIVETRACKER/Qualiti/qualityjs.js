
//ajax call for the buttons

$(document).ready(function () {
    //$('#products').hide();
    var rows = $("table tbody tr:visible");
    //FOR SUB GROUP
    $("#select_group2").on("change", function filter() {
        var data = this.value;
        console.log(data);
        var rows = $("#products tr:visible td.Group2").find("tr:not('.head')");
        console.log(rows);
        if (data == 'All') {
            rows.show();
        } else {
            rows.hide();
            rows.filter(":contains('" + data + "')").show();

        }

        var customerId = '';
        $('#select_group3').empty();
        $("#products tr:visible td.Group3").each(function () {

            var customerId = $(this).html();

            console.log(customerId);
            var option = new Option();
            //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
            $(option).html(customerId);
            //Append the option to our Select element.
            $("#select_group3").append(option);
        });
        //console.log(sum);
    });
    //Selection ends here

    var count=1;

   //on click list item 
    $('.nav-second-level').on('click', 'li', function (event) {
        $('.nav-second-level li:last')
        $('#select_group2').empty();
       
        //Shows the filter container 
        //$('.nav-third-level').empty();
        $('.filtercontainer').show();
        
        $('.nav-second-level li').removeClass('active');
        $(this).addClass('active');
        event.preventDefault();
        console.log(event.currentTarget);
        //console.log(event.target.value);
        data = event.target.innerText;
        var rows = $("#products").find("tr:not('.head')");
        console.log(rows);
        if (data == 'All') {
            rows.show();
        } else {
            rows.hide();
            rows.filter(":contains('" + data + "')").show();
        }


        //AJAX FOR PRODUCT SUB GROUP
        $.ajax({

            type: "POST",
            url: "SQL_product_Group1.php",
            data: {
                'item': data

            },

            dataType: 'json',
            success: function (data) {

                console.log(data);
                var Product_Group_one = 0;
                var appended = false;
                var option1 = new Option();
                $(option1).html('All');
                $("#select_group2").append(option1);
                $.each(data.data, function (i) {
                    $.each(data.data[i], function (key, val) {
                        if (key == 'U_Product_Group_Two') {
                            Product_Group_Two = val;
                            console.log(Product_Group_Two);
                            var option = new Option();
                            //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                            $(option).html(Product_Group_Two);
                            //Append the option to our Select element.
                            $("#select_group2").append(option);
                           $(event.currentTarget).append('<ul class="nav-third-level"><li value="' + Product_Group_Two + '"><a href="#"><span class="tab">' + Product_Group_Two + '</span></a></li></ul>');
                            //$(".active1").toggle;
                           

                            //$(event.currentTarget).append('<li class=newli  value="' + Product_Group_Two + '"><a  href="#"><span class="tab">' + Product_Group_Two + '</span></a></li>');
                         
                           
       
                        }

                    });
                });

            }
        });


    });

   $(document).on('click', '.nav-third-level li', function(){ 
        // Your Code
        $('.nav-third-level li').removeClass('active');
        $(this).addClass('active');
        Product_item='Hello';
        $(this).append('<ul><li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li></ul>');
        alert('hello');
   });

   

    
    
    $('#product_button').click(function () {

        var x = $(this).val();
        $('.banner_button').removeClass('active');
        $(this).addClass('active');
        //alert(x)
        $.ajax({

            type: "POST",
            url: "assets/product_list.json",
            data: {
                //'item': x

            },

            dataType: 'json',
            success: function (data) {


                /* alert("success");*/
                console.log(data);
                var Documentnumber = 0;
                var Customer = 0;
                /* $.each(data.data, function (i) {
                    $.each(data.data[i], function (key, val) {
                        if (key == 'PRODUCT') {
                            Product_item = val;

                            //console.log(Documentnumber,key);
                            // $('#select_customer').val(Documentnumber);
                            var option = new Option();
                            //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                            $(option).html(Product_item);
                            //Append the option to our Select element.
                            $(".nav-second-level")

                                .append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a></li>');
                        }
                    });

                }); */
                $(".nav-second-level").append('<li value="All"><a href="#"><span class="tab">All</span></a></li>');
                $.each(data, function (i) {
                    $.each(data[i], function (key, val) {
                        if (key == 'PRODUCT') {
                            Product_item = val;
                            console.log(Documentnumber, key);
                            $(".nav-second-level")

                                .append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                        }


                    });
                });
                //$('#employee_detail').html('<b> Order Id selected: ' + Documentnumber + '</b><br><b> Customer : ' + Customer + '</b>');
            },
        });


    });
});
