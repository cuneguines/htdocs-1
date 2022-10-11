
//ajax call for the buttons

$(document).ready(function () {
    //$('#products').hide();
    var rows = $("table tbody tr:visible");

    //FOR SUB GROUP
    var rowss;

    $("#select_group2").on("change", function filter() {
        var data = this.value;
        console.log(data);

        console.log(rowss);
        if (data == 'All') {
            rowss.show();
        } else {
            rowss.hide();
            //$('table.searchable tfoot tr:visible').children().eq(column).html(sum.toFixed(1));
            //$("#products td.Group2 tr:visible:contains('" + data + "')").parent().show();
            rowss.filter(":contains('" + data + "')").show();

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
        $("#select_group3").on("change", function filter() {
            var data = this.value;
            console.log(data);
            //var rows = $("table tbody tr:visible td").find("tr:not('.head')");
            
                rowss.hide();
               rowss.filter(":contains('" + data + "')").show();
               //$("#products td visible.Group3:contains('" + data + "')").parent().show();

            
        });
        //console.log(sum);
    });
    //Selection ends here

    var count = 1;

    //on click list item 
    $('.nav-second-level').on('click', 'li', function (event) {
        var productgp2 = [];
        $('.nav-second-level li:last')
        $('#select_group2').empty();
        $('#select_group3').empty();
        //Shows the filter container 
        //$('.nav-third-level').empty();
        $('.filtercontainer').show();

        $('.nav-second-level li').removeClass('active1');
        $(this).addClass('active1');
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
         $("#products td.Group1:contains('" + data + "')").parent().show();
          //rows.filter(":contains('" + data + "')").show();
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
                            //$("#select_group2").append(option);
                            //$('.active1').append('<ul class="nav-third-level"><li value="' + Product_Group_Two + '"><a href="#"><span class="tab">' + Product_Group_Two + '</span></a></li></ul>');
                            //$(".active1").toggle;
                            productgp2.push(Product_Group_Two);
                            console.log(productgp2[0]);
                            //$(event.currentTarget).append('<li class=newli  value="' + Product_Group_Two + '"><a  href="#"><span class="tab">' + Product_Group_Two + '</span></a></li>');



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
                    $("#select_group2").append(option);
                }

            }
        });


        rowss = $("table tbody tr:visible ");


    });

    /*  $(document).on('click', '.nav-third-level li', function(){ 
         // Your Code
         $('.nav-third-level li').removeClass('active1');
         $(this).addClass('active1');
         Product_item='Hello';
         $(".active1").append('<ul><li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li></ul>');
         alert('hello');
    }); */





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

    $('.has_attachment').click(function (event) {
        /* $('button').click(function(){
            let img = $('#modal').data('image');
            $('#modal-content').html(`<img src="${img}" />`);
            $('#overlay, #modal').fadeIn();
          });
          
          $('#modal-close').click(function(){
            $('#overlay, #modal').fadeOut();
          }); */
        //$str = str_replace('\\', '/', $str);
        var CurrentRow = $(event.target).closest("tr");
        alert(CurrentRow);
        var ItemId = $("td:eq(0)", $(CurrentRow)).text(); // Can Trim also if needed
        console.log(ItemId);
        var x = $(this).val();
        //$str = str_replace('\\', '/', $str);
        //var element = '//Kptsvsp\b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg';
        //var path2 = path.replace(/\\/g, "/");
        //console.log(path2);
        console.log(x);

        //$('#employee_detail').html($('<b> Order Id selected: ' + Documentnumber + '</b><b> Customer : ' + Customer + '</b>'));
        //$('#employee_detail').html('<b> Order Id selected: ' + Documentnumber + '</b><br><b> Customer : ' + Customer + '</b>');
        //"<img src='"+response+"' width='100' height='100' style='display: inline-block;'>");
        //$('.modal-body').html(x).fadeIn();
        /* function getBase64(file) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
              console.log(reader.result);
            };
            reader.onerror = function (error) {
              console.log('Error: ', error);
            };
         }
         
         //var file = document.querySelector('#files > input[type="file"]').files[0];
         var file='//Kptsvsp/b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg';
        x= getBase64(file); */


        //var base64img = getBase64Img("//Kptsvsp\b1_shr/Attachments/PHOTO-2022-06-21-12-22-16.jpg",'image/jpg');
        /* var base64img = x;
        console.log(base64img);
        function Base64ToImage(base64img, callback) {
            var img = new Image();
            img.onload = function() {
                callback(img);
            };
            img.src = base64img;
            img.width=200;
            img.height=200;
        }
        Base64ToImage(base64img, function(img) {
            document.getElementById('attachments').appendChild(img);
        });*/


    });
   

});


$(document).ready(function () {
    $('#services_button').click(function () {
        $("#card_body1").hide();
        $("#card_body2").show();
    });
});