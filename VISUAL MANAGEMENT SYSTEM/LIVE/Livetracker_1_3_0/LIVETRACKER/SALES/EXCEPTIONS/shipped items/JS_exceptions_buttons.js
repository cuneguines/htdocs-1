$(document).ready(function () {
    var rows = $("table tr:not(':first')");

    // IF ANY MIDDLE BUTTON (DARK GREY) IS CLICKED
    $(".grouping_category button").click(function () {


        if ($(this).attr('stage') == 'All') {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            rows.show();
        }
        if ($(this).attr('stage') == 'today') {
            console.log($(this).attr('stage'));
            $('.grouping_category button').removeClass('pressed');
            //$('.selector').prop('selectedIndex', 0);
            console.log($(this).attr('stage'));
            sales_person = $('#select_sales_person').val();
            site_contact = $('#select_site_contact').val();
            project = $('#select_project').val();
            $(this).addClass('pressed');

            $(this).addClass('pressed');


            if (site_contact != 'All') {
                rows.filter("[site_contact =" +site_contact+"]").show();
                view_filtered_rows_today();
            }
            else if (sales_person != 'All') {
                rows.filter("[sales_person =" +sales_person+"]").show();
                view_filtered_rows_today();
            }
            else if (project != 'All') {
                rows.filter("[project =" +project+"]").show();
                view_filtered_rows_today();
            }
            else {
                //alert('no');
                rows.show();
                $("tr td.delivery_note_days_open").each(function () {
                    if ($(this).text() > 0) {
                        $(this).parent().hide();
                    }
                });
            }
           
        }
        if ($(this).attr('stage') == 'past_day') {
            console.log($(this).attr('stage'));
            sales_person = $('#select_sales_person').val();
            site_contact = $('#select_site_contact').val();
            project = $('#select_project').val();
            console.log(sales_person);
            console.log(site_contact);
            console.log(project);
            $('.grouping_category button').removeClass('pressed');
            //$('.selector').prop('selectedIndex', 0);
            //rows.show();
            //console.log(rows.length());
            $(this).addClass('pressed');


            if (site_contact != 'All') {
                rows.filter("[site_contact =" +site_contact+"]").show();
                view_filtered_rows_past_day();
            }
            else if (sales_person != 'All') {
                rows.filter("[sales_person =" +sales_person+"]").show();
                view_filtered_rows_past_day();
            }
            else if (project != 'All') {
                rows.filter("[project =" +project+"]").show();
                view_filtered_rows_past_day();
            }
            else {
                //alert('no');
                rows.show();
                $("tr td.delivery_note_days_open").each(function () {
                    if ($(this).text() > 1) {
                        $(this).parent().hide();
                    }
                });
            }


        }
        if ($(this).attr('stage') == 'three_days') {
            console.log($(this).attr('stage'));
            sales_person = $('#select_sales_person').val();
            site_contact = $('#select_site_contact').val();
            project = $('#select_project').val();
            $('.grouping_category button').removeClass('pressed');
            //$('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            //rows.show();
            if (site_contact != 'All') {
                rows.filter("[site_contact =" +site_contact+"]").show();
                view_filtered_rows_past_three_days();
            }
            else if (sales_person != 'All') {
                rows.filter("[sales_person =" +sales_person+"]").show();
                view_filtered_rows_past_three_days();
            }
            else if (project != 'All') {
                rows.filter("[project =" +project+"]").show();
                view_filtered_rows_past_three_days();
            }
            else {
                //alert('no');
                rows.show();
                $("tr td.delivery_note_days_open").each(function () {
                    if ($(this).text() > 3) {
                        $(this).parent().hide();
                    }
                });
            }

        }
        if ($(this).attr('stage') == 'five_days') {
            console.log($(this).attr('stage'));
            sales_person = $('#select_sales_person').val();
            site_contact = $('#select_site_contact').val();
            project = $('#select_project').val();
            $('.grouping_category button').removeClass('pressed');
           // $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
            //rows.show();
            if (site_contact != 'All') {
                rows.filter("[site_contact =" +site_contact+"]").show();
                view_filtered_rows_past_five_days();
            }
            else if (sales_person != 'All') {
                rows.filter("[sales_person =" +sales_person+"]").show();
                view_filtered_rows_past_five_days();
            }
            else if (project != 'All') {
                rows.filter("[project =" +project+"]").show();
                view_filtered_rows_past_five_days();
            }
            else {
                //alert('no');
                rows.show();
                $("tr td.delivery_note_days_open").each(function () {
                    if ($(this).text() > 5) {
                        $(this).parent().hide();
                    }
                });
            }

        }
        if ($(this).attr('stage') == 'ten_days') {
            console.log($(this).attr('stage'));
            sales_person = $('#select_sales_person').val();
            site_contact = $('#select_site_contact').val();
            project = $('#select_project').val();
            $('.grouping_category button').removeClass('pressed');
           // $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
           // rows.show();

           if (site_contact != 'All') {
            rows.filter("[site_contact =" +site_contact+"]").show();
            view_filtered_rows_past_ten_days();
        }
        else if (sales_person != 'All') {
            rows.filter("[sales_person =" +sales_person+"]").show();
            view_filtered_rows_past_ten_days();
        }
        else if (project != 'All') {
            rows.filter("[project =" +project+"]").show();
            view_filtered_rows_past_ten_days();
        }
        else {
            //alert('no');
            rows.show();
            $("tr td.delivery_note_days_open").each(function () {
                if ($(this).text() > 10) {
                    $(this).parent().hide();
                }
            });
        }


            
        }
        if ($(this).attr('stage') == 'thirty_days') {
            console.log($(this).attr('stage'));
            sales_person = $('#select_sales_person').val();
            site_contact = $('#select_site_contact').val();
            project = $('#select_project').val();
            $('.grouping_category button').removeClass('pressed');
           // $('.selector').prop('selectedIndex', 0);
            $(this).addClass('pressed');
           // rows.show();
           if (site_contact != 'All') {
            rows.filter("[site_contact =" +site_contact+"]").show();
            view_filtered_rows_past_thirty_days();
        }
        else if (sales_person != 'All') {
            rows.filter("[sales_person =" +sales_person+"]").show();
            view_filtered_rows_past_thirty_days();
        }
        else if (project != 'All') {
            rows.filter("[project =" +project+"]").show();
            view_filtered_rows_past_thirty_days();
        }
        else {
            //alert('no');
            rows.show();
            $("tr td.delivery_note_days_open").each(function () {
                if ($(this).text() > 31) {
                    $(this).parent().hide();
                }
            });
        }

        }
    });
    $(".reset_buttons").click(function () {
        alert('Resetting');
        $('#select_sales_person').prop('selectedIndex', 0);
        $('#select_site_contact').prop('selectedIndex', 0);
        $('#select_project').prop('selectedIndex', 0);
        $('.grouping_category button').removeClass('pressed');
        rows.show();
    });
    function view_filtered_rows_today() {
        //alert('yes');
        //rows.filter("[sales_person =" +sales_person+"]").show();
        $("#shipping tr:visible td.delivery_note_days_open").each(function () {
            if ($(this).text() > 0) {
                $(this).parent().hide();
            }
        });
    }
    function view_filtered_rows_past_day() {
        //alert('yes');
      //rows.filter("[sales_person =" +sales_person+"]").show();
        $("#shipping tr:visible td.delivery_note_days_open").each(function () {
            if ($(this).text() > 1) {
                $(this).parent().hide();
            }
        });
    }

    function view_filtered_rows_past_three_days() {
        //alert('yes');
       
       // rows.filter("[sales_person =" +sales_person+"]").show();
        $("#shipping tr:visible td.delivery_note_days_open").each(function () {
            if ($(this).text() > 3) {
                $(this).parent().hide();
            }
        });
    }
    function view_filtered_rows_past_five_days() {
        //alert('yes');
       //rows.filter("[sales_person =" +sales_person+"]").show();
        $("#shipping tr:visible td.delivery_note_days_open").each(function () {
            if ($(this).text() > 5) {
                $(this).parent().hide();
            }
        });
    }
    function view_filtered_rows_past_ten_days() {
        //alert('yes');
       rows.filter("[sales_person =" +sales_person+"]").show();
        $("#shipping tr:visible td.delivery_note_days_open").each(function () {
            if ($(this).text() > 10) {
                $(this).parent().hide();
            }
        });
    }
    function view_filtered_rows_past_thirty_days() {
        //alert('yes');
        //rows.filter("[sales_person =" +sales_person+"]").show();
        $("#shipping tr:visible td.delivery_note_days_open").each(function () {
            if ($(this).text() > 31) {
                $(this).parent().hide();
            }
        });
    }
});
