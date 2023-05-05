$(document).ready(function(){
    $(".project_item").click(function(){
        
            test=$(this).attr('process_order')
            console.log(test);
          
            $.ajax({
    
                type: "POST",
                url: "SQL_production_schedule_ajax_on_hand.php",
                data: {
                    'item': test
    
                },
    
                dataType: 'json',
                success: function(data) {
    
    console.log(data[0]);
   
    console.log(data[0][0]['ON_HAND']);
                   
                    if (data[0].length==0)
                    {
                        $('.brred').css({'background-color': ''}); 
                    }
                    else
                    {
                    $('.brred').css({'background-color': 'gold'}); 
                    }
                   
                   
                }
        
        });
    $("h2.first").replaceWith('<h2 class = "inner first medium"><button class = "bred rounded btext white medium" style = "height:30px; width:150px;"onclick = "location.href=' + "'" + '/../SAP READER/SAP READER/BASE_sales_order.php?sales_order=' + $(this).attr('sales_order') + "'" + '">' + $(this).attr('sales_order') + "</button></h2>");
    //for Project number
    $("h2.first_sub").replaceWith( "<h2 class = 'inner first_sub small'>"+$(this).attr('project_num')+"</h2>");
    $("h2.thirteenth_sub").replaceWith( "<h2 class = 'inner thirteenth_sub small'>"+$(this).attr('sales_person')+"</h2>");
   // $("h2.first").replaceWith( "<h2 class = 'inner first medium'>"+$(this).attr('sales_order')+"</h2>");
    $("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = "location.href='+ "'" +'../../EXCEPTIONS/production exceptions/BASE_production_exceptions.php?po='+$(this).attr('process_order')+ ",NORMAL'" +'">'+$(this).attr('process_order')+"</button></h2>");
    $("h2.second").replaceWith( "<h2 class = 'inner second medium'>"+$(this).attr('customer')+"</h2>");
    $("h2.third").replaceWith( " <h2 style = 'color:red;' class = 'inner third medium'>"+$(this).attr('Description')+"        "+$(this).attr('qty')+"</h2>");
    $("h2.fourth").replaceWith( "<h2 class = 'inner fourth medium'>"+$(this).attr('project_man')+"</h2>");
    $("h2.fourteenth").replaceWith( "<h2 class = 'inner fourteenth medium'>"+$(this).attr('promise_date')+" "+$(this).attr('promise_week_due')+" ("+$(this).attr('week_opened')+"-"+$(this).attr('weeks_open')+")</h2>");
    $("h2.fifteenth").replaceWith( "<h2 class = 'inner fifteenth medium'>"+$(this).attr('floor_date')+" "+$(this).attr('weeks_on_floor')+"</h2>");
    $("h2.fifth").replaceWith( "<h2 class = 'inner fifth medium'>"+$(this).attr('engineer')+"</h2>");
    $("h2.sixth").replaceWith( "<h2 class = 'inner sixth medium'>"+$(this).attr('status')+"</h2>");
    $("h2.seventh").replaceWith( "<h2 class = 'inner seventh medium'>"+$(this).attr('stage')+"</h2>");
    $("h2.eighth").replaceWith( "<h2 class = 'inner eighth medium'>"+$(this).attr('est_fab_hrs')+" ("+$(this).attr('planned_hrs')+")</h2>");
    $("h2.eleventh").replaceWith( "<h2 class = 'inner eleventh medium'>"+$(this).attr('comments')+"</h2>");
    $("h2.twent").replaceWith( "<h2 class = 'inner twent medium'>"+$(this).attr('comments_2')+"</h2>");
    
    $(".project_item").removeClass("eng_active");
    $(this).addClass("eng_active");
    });
});

//Multiselect Project managers
$(document).ready(function() {
    //console.log(rows);
    var rows = $("table.searchable tbody tr:not('.head')");
    var jobs = $(".project_item");
    var template = $('table.searchable tfoot tr td');
    allenabled = 0;
    $('#multiselect_project_man .multiselector_checkbox').click(function() {

        if ($(this).val() == 'All') {
            if (allenabled) {
                console.log("PASS_OFF");
                $('.multiselector_checkbox').addClass('checked');
                $("table.searchable tr:not('.head')").show();
                jobs.show();
                $("table.searchable tr:not('.head')").attr('active_in_multiselect', 'Y');
                jobs.attr('active_in_multiselect', 'Y');

                jobs.show();
                rows.show();
                $('#bd').prop('disabled', false);
                allenabled = 0;
            } else {
                console.log("PASS_ON");
                $('.multiselector_checkbox').removeClass('checked', '');
                $("table.searchable tbody tr").hide();
                $("table.searchable tr:not('.head')").attr('active_in_multiselect', 'N');
                jobs.attr('active_in_multiselect', 'N');

                jobs.hide();
                rows.hide();
                $('#bd').prop('disabled', false);
                $('#bd').prop('disabled', true);
                allenabled = 1;
            }
        } 
        else 
        {
            // IF CHECKBOX IS ACTIVE WE DEACTIVATE AND HIDE ENGINEER
            if ($(this).attr('class').includes('checked'))
                {
                    console.log("REMOVING ATTR");
                    selected_eng = $(this).val();
console.log(selected_eng);
console.log(jobs);
                    jobs.filter("[project_man = " + $(this).val() + "]").hide();
                    jobs.filter("[project_man = " + $(this).val() + "]");

                    $.each($('.row').not('#select_project_man'),function(){
                        //console.log($(this).attr("engineers"));
                        console.log(selected_eng);
                        console.log($(this).find('.project_item:visible').length);

                        if($(this).find('.project_item:visible').length == 0){
                            console.log($(this).attr("project_man_tr"));
                            $(this).hide();
                            $(this).attr('active_in_multiselect', 'N');
                        }

                        /*if(JSON.stringify($(this).attr("engineers")).includes(selected_eng))
                        {
                            console.log($(this).attr("engineers"));
                            $(this).hide();
                            $(this).attr('active_in_multiselect', 'N');
                        }
                        rows.filter('[type = data]').hide();
                        */
                    });
                    
                
                    $(this).removeClass('checked');
            } 
            else {
                console.log("ADDING ATTR");
                selected_eng = $(this).val();
                console.log(selected_eng);
                console.log(rows);
                jobs.filter("[project_man = " + $(this).val() + "]").show();
                jobs.filter("[project_man = " + $(this).val() + "]");

                $.each($('.row').not('#select_engineer'),function(){
                    if(JSON.stringify($(this).attr("project_man_tr")).includes(selected_eng))
                    {
                        console.log("TEST");
                        $(this).show();
                        $(this).attr('active_in_multiselect', 'Y');
                    }
                });
                


                $(this).addClass('checked', '');
            }
        }
    });
});

$(document).ready(function() {
    var rows = $("table.searchable tbody tr");
    var template = $('table.searchable tfoot tr td');
    active = 0;
    $('.search_option_button_local').click(function() {
        $('.selector').prop('selectedIndex', 0);
        if (!$(this).hasClass('active')) {
            $('#' + $(this).attr('id') + '.search_option_field').show();
            $(this).addClass('active');
        } else {
            console.log($('#' + $(this).attr('id') + '.search_option_field'));
            $('#' + $(this).attr('id') + '.search_option_field').hide();
            $(this).removeClass('active');
        }
        //if (typeof __update_rows__ !== 'undefined') {
        //update_total_row(rows, template);}
    });
})