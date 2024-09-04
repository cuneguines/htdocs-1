$(document).ready(function(){
    // READ IN TWO DATA TABLES
    var hours_entries = $("#operator_steps  tr:not('.head')");

    var hours_calander = $("#operator_hours  tr:not('.head')");



    
    function getCurrentWeek() {
        var date = new Date();
        var oneJan = new Date(date.getFullYear(), 0, 1);
        var numberOfDays = Math.floor((date - oneJan) / (24 * 60 * 60 * 1000));
        return Math.ceil((date.getDay() + 1 + numberOfDays) / 7);
    }

    // Function to get the current year
    function getCurrentYear() {
        return new Date().getFullYear();
    }

    // Initialize by creating the total row for the current week and year
    var currentWeek = getCurrentWeek(); // Get the current week dynamically
    var currentYear = getCurrentYear(); // Get the current year dynamically
    console.log(currentWeek);
    createTotalRow(currentWeek, currentYear);
    updateTotals();
    //console.log(hours_calander);
    //updateTotals();
    // CALANDER CELL CLICK EVENT
    $('tbody td button').click(function(){
       
        // GET DETAILS OF CLCIKED CELL ON CALANDER
        day = $(this).attr('id');
        week = $(this).parent().parent().attr('week');
        year = $(this).parent().parent().attr('year');
        emp_no = $(this).parent().parent().attr('emp_no');
        console.log(emp_no);
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
        createTotalRow-m(week, year);
    });

    // PREVIOUS WEEK EVENT
    $('#previous_week').click(function(){

        
        // GET THE WEEK AND YEAR OF THE WEEK WE ARE CHANGING TO
        this_week = $(this).attr('go_to_week');
        this_year = $(this).attr('go_to_year');
createTotalRow(this_week, this_year);
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
        $('.operator').text('Week ' + this_week + ' ' + this_year);


        // FILTER CALANDER ROWS FOR NEW YEAR AND WEEK NUMBER
        hours_calander.hide();
      
        hours_calander.filter("[year = " + this_year + "][week = " + this_week + "]").show();
     

        // IF THERE IS INFORMATION IN THE SEARCH TABLE OPTION FILTER OUT NON MATCHING EMPLOYEE NAMES TOO
        $.each($('.searchable tr tfoot td.name').not(':first'),function(){
            updateTotals();
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
        updateTotals();
    });

    // NEXT WEEK EVENT
    $('#next_week').click(function(){
       
        // GET THE WEEK AND YEAR OF THE WEEK WE ARE CHANGING TO
        this_year = $(this).attr('go_to_year');
        this_week = $(this).attr('go_to_week');
        createTotalRow(this_week, this_year);
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
        $('.operator').text('Week ' + this_week + ' ' + this_year);

        // FILTER CALANDER ROWS FOR NEW YEAR AND WEEK NUMBER
        hours_calander.hide();
        hours_calander.filter("[year = " + this_year + "][week = " + this_week + "]").show();

        // IF THERE IS INFORMATION IN THE SEARCH TABLE OPTION FILTER OUT NON MATCHING EMPLOYEE NAMES TOO
        $.each($('.searchable tr  td.name').not(':first'),function(){
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
        updateTotals();
    });

    // EVERY TIME THE SEARCHTABLE IS CHANGED SEARCH ALL NAME CELLS OF THE CALANDER TABLE AND EXCLUDE ALL ROWS WHERE THE NAME CELL DOES NOT MATCH WHAT IS IN SEARCH TABLE
    $('input').keyup(function() {
       
        $('.selector').prop('selectedIndex', 0);
        $('button').removeClass('active');
        $.each($('.searchable tr  td.name').not(':first'),function(){
            $(this).parent().hide();
            if(JSON.stringify($(this).text()).toLowerCase().includes($('input').val().toLowerCase())){
                $(this).parent().show();
            }  
        });
        hours_calander.not("[year = " + $('#this_week').attr('go_to_year') + "][week = " + $('#this_week').attr('go_to_week') + "]").hide();
       
    });


    function updateTotals() {
        const total = {
            mon: 0,
            tue: 0,
            wed: 0,
            thu: 0,
            fri: 0,
            sat: 0,
            week: 0
        };

        $("table tr:visible").each(function() {
            let rowTotal = 0;
            $(this).find("td.day-mon button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.mon += value;
                    rowTotal += value;
                }
            });
            $(this).find("td.day-tue button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.tue += value;
                    rowTotal += value;
                }
            });
            $(this).find("td.day-wed button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.wed += value;
                    rowTotal += value;
                }
            });
            $(this).find("td.day-thu button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.thu += value;
                    rowTotal += value;
                }
            });
            $(this).find("td.day-fri button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.fri += value;
                    rowTotal += value;
                }
            });
            $(this).find("td.day-sat button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.sat += value;
                    rowTotal += value;
                }
            });
            $(this).find("td.day-total button").each(function(index) {
                const value = parseFloat($(this).text());
                if (!isNaN(value)) {
                    total.week += value;
                    rowTotal += value;
                }
            });
            
        });

        $("#total-mon").text(total.mon.toFixed(2));
    $("#total-tue").text(total.tue.toFixed(2));
    $("#total-wed").text(total.wed.toFixed(2));
    $("#total-thu").text(total.thu.toFixed(2));
    $("#total-fri").text(total.fri.toFixed(2));
    $("#total-sat").text(total.sat.toFixed(2));
    $("#total-week").text(total.week.toFixed(2));
    }

    updateTotals(); // Initial calculation
});



function createTotalRow(week, year) {
    // Remove existing total rows if any
    $('#total tbody tr[lastrow]').remove();
   
    // Create the total row HTML dynamically
    var totalRow = `<tr lastrow="lastrow" week="${week}" year="${year}" style="background-color: #4d79ef; position: sticky; bottom: 0; width: 100%;">
        <td colspan="3" style="text-align: right;border:1px solid #4d79ef;">Total:</td>
        <td id="total-mon" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
        <td id="total-tue" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
        <td id="total-wed" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
        <td id="total-thu" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
        <td id="total-fri" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
        <td id="total-sat" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
        <td id="total-week" style="background-color: #4d79ef;border:1px solid #4d79ef;"></td>
      
    </tr>`;

    // Append the total row to the table body
    $('#total tbody').append(totalRow);
  
}


