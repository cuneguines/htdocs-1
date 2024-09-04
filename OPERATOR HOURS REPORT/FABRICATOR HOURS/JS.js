$(document).ready(function(){
    // READ IN TWO DATA TABLES
    var hours_entries = $("#operator_steps tr:not('.head')");
    var hours_calander = $("#operator_hours tr:not('.head')");

    // CALANDER CELL CLICK EVENT
    $('tbody td button').click(function(){
        // GET DETAILS OF CLCIKED CELL ON CALANDER
        day = $(this).attr('id');
        week = $(this).parent().parent().attr('week');
        year = $(this).parent().parent().attr('year');
        emp_no = $(this).parent().parent().attr('emp_no');
        emp_name = $(this).parent().parent().attr('emp_name');
        
        // HIDE ROWS THAT DO NOT MATCH THE SPECIFIC YEAR, WEEK, DAY OF WEEK, AND EMP NUMBER. 
        // IF TOTAL IS CLICKED DO THE EXACT SAME EXCECPT EXCLUDE DAY OF WEK FROM THE CHECK
        hours_entries.hide();
        if(day !== 'tot'){
            hours_entries.filter("[year = " + year + "][week = " + week + "][weekday = " + day + "][emp_no = " + emp_no + "]").show();
        }
        else{
            hours_entries.filter("[year = " + year + "][week = " + week + "][emp_no = " + emp_no + "]").show();
        }

        // DEACTIVE ALL OTHER CALANDER BUTTONS AND ACTIVATE CLICKED BUTTON (STYLING ONLY) & REPLACE TITLE OF ENTRY TABLE WITH DETAILS OF CLICKED CALANDER CELL. 
        $('tbody td button').not(this).removeClass('active');
        $(this).addClass("active");
        $('#empsteps').text(emp_name + " (" + day + " Week " + week + " " + year + ")");
    });

    // PREVIOUS WEEK EVENT
    $('#previous_week').click(function(){
        
        // GET THE WEEK AND YEAR OF THE WEEK WE ARE CHANGING TO
        this_week = $(this).attr('go_to_week');
        this_year = $(this).attr('go_to_year');

        // GET THE WEEK AND YEAR FOR PREVIOUS AND NEXT WEEK RELATIVE TO THE WEEK WE ARE CHANGING TO
        next_week_week = (eval(this_week) + 1) > 52 ? ((eval(this_week) + 1) -52) : (eval(this_week) + 1);
        next_week_year = eval(this_year) + ((eval(this_week)+1) > 52 ? 1 : 0);
        previous_week_week = ((this_week - 1) < 1 ? (this_week - 1) + 52 : (this_week - 1));
        previous_week_year = (this_year - ((this_week-1) < 1 ? 1 : 0));

        // UPDATE PREVIOUS WEEK BUTTON DETAILS AND TEXT TO REFLECT NEW PREVIOUS WEEK WEEK NUMBER AND YEAR
        $('#previous_week').attr('go_to_week', previous_week_week);
        $('#previous_week').attr('go_to_year', previous_week_year);
        $('#previous_week').html("&#9754 " + "Week " + previous_week_week + " " + previous_week_year + " &#9754;").text();

        // UPDATE NEXT WEEK BUTTON DETAILS AND TEXT TO REFLECT NEW NEXT WEEK WEEK NUMBER AND YEAR
        $('#next_week').attr('go_to_week', next_week_week);
        $('#next_week').attr('go_to_year',  next_week_year);
        $('#next_week').html("&#9755 " + "Week " + next_week_week + " " + next_week_year + ' ' + '&#9755').text();
       
        // UPDATE THIS WEEK DETAILS AND PRINT IT TO THE DATE HOLDER
        $('#this_week').attr('go_to_week', this_week);
        $('#this_week').attr('go_to_year', this_year);
        $('.date_holder').text('Week ' + this_week + ' ' + this_year);
        
        // FILTER CALANDER ROWS FOR NEW YEAR AND WEEK NUMBER
        hours_calander.hide();
        hours_calander.filter("[year = " + this_year + "][week = " + this_week + "]").show();

        // IF THERE IS INFORMATION IN THE SEARCH TABLE OPTION FILTER OUT NON MATCHING EMPLOYEE NAMES TOO
        $.each($('.searchable tr td.name').not(':first'),function(){
            if(!JSON.stringify($(this).text()).toLowerCase().includes($('input').val().toLowerCase())){
                $(this).parent().hide();
            }  
        });

        // IF THE PREVIOUS WEEK IS OUTSIDE THE DATA ENCTACHMENT DISABLE THE BUTTON
        if(eval($('.date_holder').attr('start_year')) === previous_week_year && eval($('.date_holder').attr('start_week')) === previous_week_week){
            $('#previous_week').prop('disabled', true);
        }

        // RE-ENABLE NEXT WEEK BUTTON - THIS FUNCTION GOES BACK ONE WEEK. IF WE ARE AT THE FRONT END AND THE BUTTON IS DISABLED "NEXT WEEK" AND WE COME BACK ONE WEEK THERE WILL BE DATA AVAILABLE FOR "NEXT WEEK" AT THAT TIME
        $('#next_week').prop('disabled', false);
    });

    // NEXT WEEK EVENT
    $('#next_week').click(function(){
        
        // GET THE WEEK AND YEAR OF THE WEEK WE ARE CHANGING TO
        this_year = $(this).attr('go_to_year');
        this_week = $(this).attr('go_to_week');
        
        // GET THE WEEK AND YEAR FOR PREVIOUS AND NEXT WEEK RELATIVE TO THE WEEK WE ARE CHANGING TO
        next_week_week = (eval(this_week) + 1) > 52 ? ((eval(this_week) + 1) -52) : (eval(this_week) + 1);
        next_week_year = eval(this_year) + ((eval(this_week)+1) > 52 ? 1 : 0);
        previous_week_week = ((this_week - 1) < 1 ? (this_week - 1) + 52 : (this_week - 1));
        previous_week_year = (this_year - ((this_week-1) < 1 ? 1 : 0));

        // UPDATE NEXT WEEK BUTTON DETAILS AND TEXT TO REFLECT NEW NEXT WEEK WEEK NUMBER AND YEAR
        $('#next_week').attr('go_to_week', next_week_week);
        $('#next_week').attr('go_to_year', next_week_year);
        $('#next_week').html("&#9755 " + "Week " + next_week_week + " " + next_week_year + " &#9755").text();

        // UPDATE PREVIOUS WEEK BUTTON DETAILS AND TEXT TO REFLECT NEW PREVIOUS WEEK WEEK NUMBER AND YEAR
        $('#previous_week').attr('go_to_week', previous_week_week);
        $('#previous_week').attr('go_to_year', previous_week_year);
        $('#previous_week').html("&#9754 " + "Week " + previous_week_week + " " + previous_week_year + " &#9754").text();
        
        // UPDATE THIS WEEK DETAILS AND PRINT IT TO THE DATE HOLDER
        $('#this_week').attr('go_to_week', this_week);
        $('#this_week').attr('go_to_year', this_year);
        $('.date_holder').text('Week ' + this_week + ' ' + this_year);

        // FILTER CALANDER ROWS FOR NEW YEAR AND WEEK NUMBER
        hours_calander.hide();
        hours_calander.filter("[year = " + this_year + "][week = " + this_week + "]").show();

        // IF THERE IS INFORMATION IN THE SEARCH TABLE OPTION FILTER OUT NON MATCHING EMPLOYEE NAMES TOO
        $.each($('.searchable tr td.name').not(':first'),function(){
            if(!JSON.stringify($(this).text()).toLowerCase().includes($('input').val().toLowerCase())){
                $(this).parent().hide();
            }  
        });

        // IF THE NEXT WEEK IS OUTSIDE THE DATA ENCTACHMENT DISABLE THE BUTTON
        if(eval($('.date_holder').attr('end_year')) === next_week_year && eval($('.date_holder').attr('end_week')) === next_week_week){
            $('#next_week').prop('disabled', true);
        }

        // RE-ENABLE PREVIOUS WEEK BUTTON - THIS FUNCTION GOES BACK ONE WEEK. IF WE ARE AT THE BACK END, THE BUTTON "PREVIOUS WEEK" IS DISABLED AND WE COME FORWARD ONE WEEK THERE WILL BE DATA AVAILABLE FOR "PREVIOUS WEEK" AT THAT TIME
        $('#previous_week').prop('disabled', false);
    });

    // EVERY TIME THE SEARCHTABLE IS CHANGED SEARCH ALL NAME CELLS OF THE CALANDER TABLE AND EXCLUDE ALL ROWS WHERE THE NAME CELL DOES NOT MATCH WHAT IS IN SEARCH TABLE
    $('input').keyup(function() {
        $('.selector').prop('selectedIndex', 0);
        $('button').removeClass('active');
        $.each($('.searchable tr td.name').not(':first'),function(){
            $(this).parent().hide();
            if(JSON.stringify($(this).text()).toLowerCase().includes($('input').val().toLowerCase())){
                $(this).parent().show();
            }  
        });
        hours_calander.not("[year = " + $('#this_week').attr('go_to_year') + "][week = " + $('#this_week').attr('go_to_week') + "]").hide();
    });
});