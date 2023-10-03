$(document).ready(function () {


    $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
    var rows = $("table.filterable tbody tr");
    var template = $('table.filterable tfoot tr td');

    if (typeof __update_rows__ !== 'undefined') {
        update_total_row(rows, template);
    }

    $(".grouping_category button").click(function () {

        // DISABLE OTHER FILTERS AND BUTTONS + ACTIVATE CURRENT BUTTOn

        //$('.selector').prop('selectedIndex', 0);
        $('table tr').removeClass('alternate');
        $('.grouping_category_new button').not(this).removeClass("pressed");
        $('.grouping_category button').not(this).removeClass("pressed");
        $('.grouping_category_newest button').not(this).removeClass("pressed");
        $(this).addClass("pressed");

        // RESTRICT TABLE TO ALL ROWS MACHING THE STAGE OF THE BUTTON HIDE ALL OTHERS 
        person = $('#select_person').val();


        //rows.show();
        console.log($(this).attr('stat'));
        //$(this).attr('stat') !== "ALL" ? rows.not("[stat = " + $(this).attr('stat') + "]").hide() : console.log("");

        if (person != 'All') {
            //alert('yes');
            var new_rows = $("table.filterable tbody tr");
            new_rows = new_rows.filter("[person =" + person + "]");
            console.log(new_rows);
            new_rows.filter("[person =" + person + "]").show();
            new_rows.not("[stat = " + $(this).attr('stat') + "]").hide();

        }
        else {
            $('.selector').not(this).prop('selectedIndex', 0)
            rows.show();
            console.log($(this).attr('stat'));
            $(this).attr('stat') !== "ALL" ? rows.not("[stat = " + $(this).attr('stat') + "]").hide() : console.log("");

        }

        // PASS ALL MATCHING ROWS AS JQUERY LIST AND FOOTER TEMPLATE TO UPDATE TOTAL ROWS FUNCTION
        if (typeof __update_rows__ !== 'undefined') {
            update_total_row(rows.filter("[stat = " + $(this).attr('stat') + "]"), template);
        }
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
        console.log($('table:visible'));

    });

    $(".grouping_category_new button").click(function () {

        // DISABLE OTHER FILTERS AND BUTTONS + ACTIVATE CURRENT BUTTOn

        //$('.selector').prop('selectedIndex', 0);
        //all filters empty
        //$('#select_person option[value="All"]').prop('selected', true);
        $('#select__product_group option[value="All"]').prop('selected', true);

        $('#select_product_group_two').val('');
        $('#select_product_group_three ').val('');

        $('table tr').removeClass('alternate');
        $('.grouping_category_newest button').not(this).removeClass("pressed");
        $('.grouping_category_new button').not(this).removeClass("pressed");
        $('.grouping_category button').not(this).removeClass("pressed");
        $(this).addClass("pressed");

        // RESTRICT TABLE TO ALL ROWS MACHING THE STAGE OF THE BUTTON HIDE ALL OTHERS 
        person = $('#select_person').val();


        //rows.show();
        console.log($(this).attr('new_stat'));
        //$(this).attr('stat') !== "ALL" ? rows.not("[stat = " + $(this).attr('stat') + "]").hide() : console.log("");

        if (person != 'All') {
            //alert('yes');
            var new_rows = $("table.filterable tbody tr");
            new_rows = new_rows.filter("[person =" + person + "]");
            console.log(new_rows);
            new_rows.filter("[person =" + person + "]").show();
            new_rows.not("[new_stat = " + $(this).attr('new_stat') + "]").hide();

        }
        else {
            $('.selector').not(this).prop('selectedIndex', 0)
            rows.show();
            console.log($(this).attr('new_stat'));
            $(this).attr('new_stat') !== "ALL" ? rows.not("[new_stat = " + $(this).attr('new_stat') + "]").hide() : console.log("");

        }

        // PASS ALL MATCHING ROWS AS JQUERY LIST AND FOOTER TEMPLATE TO UPDATE TOTAL ROWS FUNCTION
        if (typeof __update_rows__ !== 'undefined') {
            update_total_row(rows.filter("[new_stat = " + $(this).attr('new_stat') + "]"), template);
        }
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
        console.log($('table:visible'));

    });

    $(".grouping_category_newest button").click(function () {

        // DISABLE OTHER FILTERS AND BUTTONS + ACTIVATE CURRENT BUTTOn

        //$('.selector').prop('selectedIndex', 0);
        //all filters empty
        //$('#select_person option[value="All"]').prop('selected', true);
        $('#select__product_group option[value="All"]').prop('selected', true);

        $('#select_product_group_two').val('');
        $('#select_product_group_three ').val('');

        $('table tr').removeClass('alternate');
        $('.grouping_category_newest button').not(this).removeClass("pressed");
        $('.grouping_category_new button').not(this).removeClass("pressed");
        $('.grouping_category button').not(this).removeClass("pressed");
        $(this).addClass("pressed");

        // RESTRICT TABLE TO ALL ROWS MACHING THE STAGE OF THE BUTTON HIDE ALL OTHERS 
        person = $('#select_person').val();


        //rows.show();
        console.log($(this).attr('type'));
        //$(this).attr('stat') !== "ALL" ? rows.not("[stat = " + $(this).attr('stat') + "]").hide() : console.log("");

        if (person != 'All') {
            //alert('yes');
            var new_rows = $("table.filterable tbody tr");
            new_rows = new_rows.filter("[person =" + person + "]");
            console.log(new_rows);
            new_rows.filter("[person =" + person + "]").show();
            new_rows.not("[type = " + $(this).attr('type') + "]").hide();

        }
        else {
            attrib=$(this).attr('type');
            if (attrib=='OpportunityForImprovement')
            {
            $('.selector').not(this).prop('selectedIndex', 0)
            rows.show();
            console.log($(this).attr('new_stat'));
            $(this).attr('type') !== "ALL" ? rows.filter("[type = CustomerComplaints]").hide() : console.log("");
            }
            else
            
                if (attrib=='CustomerComplaints')
                {
            $('.selector').not(this).prop('selectedIndex', 0)
            rows.show();
            console.log('dggf');
            $(this).attr('type') !== "ALL" ? rows.not("[type = " + $(this).attr('type') + "]").hide(): console.log("");
            }
        }

        // PASS ALL MATCHING ROWS AS JQUERY LIST AND FOOTER TEMPLATE TO UPDATE TOTAL ROWS FUNCTION
        if (typeof __update_rows__ !== 'undefined') {
            update_total_row(rows.filter("[type = " + $(this).attr('type') + "]"), template);
        }
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
        console.log($('table:visible'));

    });



    $("#select_product_group").on("change", function () {
        $('#select_area_caused').not(this).prop('selectedIndex', 0);
        $('#select_area_raised').not(this).prop('selectedIndex', 0);
        $('#select_person').prop('selectedIndex', 0)
        $('table:visible tr').removeClass('alternate');
        $('#select_product_group_two').empty();
        $('#select_product_group_three').empty();

        var productgp2 = [];
        var x = $('#select_product_group :selected').text();
        console.log(x);
        $.ajax({
            type: "POST",
            url: "SQL_getproductgroup.php",
            cache: false,
            data: {
                'id': x,


            },
            dataType: 'json',
            success: function (response) {
                //$("#contact").html(response)
                //$("#contact-modal").modal('hide');
                console.log(response[0]);
                //length=response[0].length;

                $.each(response[0], function () {
                    $.each(this, function (key, val) {
                        if (key == 'U_Product_Group_Two') {
                            Product_item = val;
                            console.log(val);
                            productgp2.push(val);
                            console.log(productgp2[0]);
                            console.log(i);
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
                    if (unique[i] != null) {
                        var option = new Option(unique[i], unique[i].replace(/[^A-Z0-9]/ig, ""));
                        $(option).html(unique[i]);
                        //Append the option to our Select element.
                        $("#select_product_group_two").append(option);

                    }
                }

                //alert('input recieved');
                //location.reload();
            },
            error: function () {
                alert("Error");
            }
        });
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');

    });

    $("#select_product_group_two").on("change", function () {
        $('table tr').removeClass('alternate');
        $('#select_product_group_three').empty();
        var productgp2 = [];
        var x = $('#select_product_group_two :selected').text();
        console.log(x);
        $.ajax({
            type: "POST",
            url: "SQL_getproductgroup2.php",
            cache: false,
            data: {
                'id': x,


            },
            dataType: 'json',
            success: function (response) {
                //$("#contact").html(response)
                //$("#contact-modal").modal('hide');
                console.log(response[0]);
                $.each(response[0], function () {
                    $.each(this, function (key, val) {
                        if (key == 'U_Product_Group_Three') {
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

                console.log(unique.length);
                for (var i = 0; i < unique.length; i++) {
                    if (unique[i] != null) {
                        var option = new Option(unique[i], unique[i].replace(/[^A-Z0-9]/ig, ""));
                        $(option).html(unique[i]);
                        //Append the option to our Select element.
                        $("#select_product_group_three").append(option);

                    }
                }

                //alert('input recieved');
                //location.reload();
            },
            error: function () {
                alert("Error");
            }
        });

        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');

    });





    $(".selector").on("change", function filter() {
       
        //$('.selector').not(this).prop('selectedIndex', 0);
        $('table tr').removeClass('alternate');
        if ($(this).find('option').length == 1) {
            $(this).find('option').prop("selected", true);
            alert($(this).find("option:selected").text() + " : " + $(this).val());
        }
        $('button').removeClass('pressed');
        console.log($(this).children("option:selected").val());
        if ($(this).children("option:selected").val() === 'All') {

            rows.show();
            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows, template);
            }
        }
        else {
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']').hide();
            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']'), template);
            }
        }

        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
    });
    //FOR productgroup3

    $(".selector_p3").on("click", function filter() {

        $('table tr').removeClass('alternate');
        //$('.selector').not(this).prop('selectedIndex', 0);
        if ($(this).find('option').length == 1) {
            $(this).find('option').prop("selected", true);
            //alert($(this).find("option:selected").text() + " : " + $(this).val());
        }
        $('button').removeClass('pressed');
        console.log($(this).children("option:selected").val());
        if ($(this).children("option:selected").val() === 'All') {
            rows.show();
            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows, template);
            }
        }
        else {
            rows.show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']').hide();
            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']'), template);
            }
        }

        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
    });


    $("#select_person").on("change", function filter() {

        $('table tr').removeClass('alternate');
        $('#select_product_group').not(this).prop('selectedIndex', 0);
        $('#select_product_group_two').not(this).prop('selectedIndex', 0);
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
        $('#select_product_group_two').empty();
        $('#select_product_group_three').empty();
        $('.selector').not(this).prop('selectedIndex', 0);
        $('#select_area_raised').not(this).prop('selectedIndex', 0);
    });

    $("#select_area_raised").on("change", function filter() {

        $('table tr').removeClass('alternate');
        $('#select_product_group').not(this).prop('selectedIndex', 0);
        $('#select_product_group_two').empty();
        $('#select_product_group_three').empty();
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
        $('.selector').not(this).prop('selectedIndex', 0);
        $('.select_area_caused').not(this).prop('selectedIndex', 0);
    });
    $("#select_area_caused").on("change", function filter() {

        $('table tr').removeClass('alternate');
        $('#select_product_group').not(this).prop('selectedIndex', 0);
        $('#select_product_group_two').empty();
        $('#select_product_group_three').empty();
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');
        $('.selector').not(this).prop('selectedIndex', 0);
        $('.select_area_raised').not(this).prop('selectedIndex', 0);
    });
    $("#resett_but").on("click", function () {


        $('table tr').removeClass('alternate');
        rows.show();
        $('#select_product_group_three').empty();
        $('#select_product_group_two').empty();
        $('#select_product_group_three')[0].options.length = 0;
        $('#select_product_group_two')[0].options.length = 0;
        $('#select_person option[value="All"]').prop('selected', true);
        
        $('#select_area_caused').not(this).prop('selectedIndex', 0);
        $('#select_area_raised').not(this).prop('selectedIndex', 0);
        $('#select_product_group').not(this).prop('selectedIndex', 0);

      
        $('.grouping_category_new button').not(this).removeClass("pressed");
        $('.grouping_category button').not(this).removeClass("pressed");
        $('table:visible tr:not(:hidden)').filter(':odd').addClass('alternate');

    });
});