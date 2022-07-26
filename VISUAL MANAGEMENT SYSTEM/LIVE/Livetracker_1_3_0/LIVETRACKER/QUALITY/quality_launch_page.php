<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JS -->
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_filters.js"></script>
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>
    <!-- <link rel="stylesheet" href="../../CSS/LT_STYLE.css"> -->
    <link rel="stylesheet" href="../../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

</head>

<body>
    <style>
        body {


            margin: 0;

        }

        html {
            margin: 0;
            height: 100vh;
            width: 100%;

        }

        .banner_button {
            cursor: pointer;

            padding: 1.5rem 4.5rem;
            border-radius: 1.75rem;
            /* line-height: 2.4rem; */
            font-size: 1.4rem;
            font-weight: 600;

            border: 1px solid #012880;
            /* background-image: linear-gradient(-180deg, #FF89D3 0%, #C01F9F 100%); */
            box-shadow: 0 1rem 1.25rem 0 rgba(22, 75, 195, 0.50),
                0 -0.25rem 1.5rem rgba(110, 15, 155, 1) inset,
                0 0.75rem 0.5rem rgba(255, 255, 255, 0.4) inset,
                0 0.25rem 0.5rem 0 rgba(180, 70, 207, 1) inset;
        }

        select option {
            font-size: 20px;
        }

        .active {
            border: 3px solid #012880;
        }
    </style>

    <?php include '../../SQL CONNECTIONS/conn.php'; ?>
    <?php include '../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>

    <script>
        //ajax call for the buttons
        
        $(document).ready(function() {
            $('.banner_button').click(function() {
                var list = ['Car', 'Bike', 'Scooter'];
        for (var value of list) {
       
          $('#container')
            .append(`<input type="checkbox" id="${value}" checked =true name="interest" value="${value}">`)
            .append(`<label for="${value}">${value}</label></div>`)
            .append(`<br>`);
        }
                var x = $(this).val();
                $('.banner_button').removeClass('active');
                $(this).addClass('active');
                //alert(x)
                $.ajax({

                    type: "POST",
                    url: "./SQL_product.php",
                    data: {
                        'item': x
                    },

                    dataType: 'json',
                    success: function(data) {


                        /* alert("success");*/
                        //console.log(data);
                        var Documentnumber = 0;
                        var Customer = 0;
                        $.each(data.data, function(i) {
                            $.each(data.data[i], function(key, val) {
                                if (key == 'PRODUCT') {
                                    Product_item = val;

                                    //console.log(Documentnumber,key);
                                    // $('#select_customer').val(Documentnumber);
                                    var option = new Option();
                                    //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                                    $(option).html(Product_item);
                                    //Append the option to our Select element.
                                    $("#selec_customer")
                                    
                                             .append(`<input type="checkbox" id="${Product_item}" checked =true name="interest" value="${Product_item}">`)
                                             .append(`<label for="${Product_item}">${Product_item}</label></div>`)
                                             .append('<br>')
                                }
                            });

                        });


                        //$('#employee_detail').html('<b> Order Id selected: ' + Documentnumber + '</b><br><b> Customer : ' + Customer + '</b>');
                    },
                });

            });
        });
    </script>

    <div id="background">
        <h1 style="position:relative;margin-left:45%;">QUALITY</h1>

    </div>
    <div class="container" style="position:relative;margin-left:10%;">

        <button style="position:relative;margin-left:10%;" class="banner_button " value="PRODUCT">Product</button>
        <button style="position:relative;margin-left:1%;" class="banner_button green br_green" value="Process">Process</button>
        <button style="position:relative;margin-left:1%;" class="banner_button green br_green">Sales</button>
        <button style="position:relative;margin-left:1%;" class="banner_button green br_green">Engineering Admin</button>
    </div>
   <!-- Form Filtering with Product Name -->
   
    <form action="./quality_issues_table.php">
        <div style="padding: 2.5rem;width:40%;height:10%;margin-left:30%;float:left;margin-top:10% ;border-radius: 1.75rem;box-shadow: 0 1rem 1.25rem 0 rgba(22, 75, 195, 0.50),
                0 -0.25rem 1.5rem rgba(110, 15, 155, 1) inset,
                0 0.75rem 0.5rem rgba(255, 255, 255, 0.4) inset,
                0 0.25rem 0.5rem 0 rgba(180, 70, 207, 1) inset;" ;id="select_">
            <label style="float:left;" for="cars">Choose:</label>
            <div id="selec_customer" style="padding: 1.4rem;font-size: 20px; float:left;width:40%;height:55%;border-radius: 1.75rem;" name="cars" id="cars">
    </div>
            <button class="banner_button" style="position:relative;float:left;margin-left:5%" type="submit" value="Submit">Submit</button>
        </div>
    </form>
<!-- Form Filtering with Process Order -->

    <form action="./quality_issues_table.php">
    
        <div style="margin-left:3%;padding: 2.5rem;width:40%;height:10%;float:left;margin-top:4% ;border-radius: 1.75rem;box-shadow: 0 1rem 1.25rem 0 rgba(22, 75, 195, 0.50),
                0 -0.25rem 1.5rem rgba(110, 15, 155, 1) inset,
                0 0.75rem 0.5rem rgba(255, 255, 255, 0.4) inset,
                0 0.25rem 0.5rem 0 rgba(180, 70, 207, 1) inset;" ;id="select_">
               
                
               <h3 style="background: #fff; margin-top:-5%; width: 15%;">Pr.Order</h3>
               <div id="container">ffff</div>
            <select id="select_customer" style="padding: 1.4rem;font-size: 20px; float:left;width:40%;height:55%;border-radius: 1.75rem;" name="cars" id="cars">
            </select>
            <button class="banner_button" style="position:relative;float:left;margin-left:5%" type="submit" value="Submit">Submit</button>
        </div>
        
    </form>

<!-- Form Filtering with Sales Order -->
    <form action="./quality_issues_table.php">
        <div style="margin-left:3%;padding: 2.5rem;width:40%;height:10%;float:left;margin-top:4% ;border-radius: 1.75rem;box-shadow: 0 1rem 1.25rem 0 rgba(22, 75, 195, 0.50),
                0 -0.25rem 1.5rem rgba(110, 15, 155, 1) inset,
                0 0.75rem 0.5rem rgba(255, 255, 255, 0.4) inset,
                0 0.25rem 0.5rem 0 rgba(180, 70, 207, 1) inset;" ;id="select_">
           <h3 style="background: #fff; margin-top:-5%; width: 3%;">Sl.Order</h3>
            <select id="select_customer" style="padding: 1.4rem;font-size: 20px; float:left;width:40%;height:55%;border-radius: 1.75rem;" name="cars" id="cars">
    </select>
            <button class="banner_button" style="position:relative;float:left;margin-left:5%" type="submit" value="Submit">Submit</button>
        </div>
    </form>
   
  
</body>

</html>