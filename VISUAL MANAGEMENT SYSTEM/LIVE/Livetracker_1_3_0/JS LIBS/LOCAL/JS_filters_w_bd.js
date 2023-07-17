// KEEPS TRACK ON WHETHER COMMENT TOGGLE IS ON OR OFF (DEFAULT OFF)
$(document).ready(function(){
   
    $('.selector').prop('selectedIndex',0);
    let status = 1;
    var rows = $("table.filterable tbody tr");
    var jobs = $(".project_item");
    var template = $('table.filterable tfoot tr td');

    

    if(typeof __update_rows__ !== 'undefined'){
        update_total_row(rows,template);
    }

    $(".selector").not($('#select_engineer')).on("change",function filter()
    {
        $('.multiselector_checkbox').addClass('checked');
        $('.selector').not(this).prop('selectedIndex',0);
        $('#bd').prop('disabled', false);
        console.log('yes');
        console.log($(this).children("option:selected").val());
        if($(this).children("option:selected").val() === 'All')
        {
            rows.show();
            jobs.show();
            $('table.filterable tfoot tr').show();
            if(typeof __update_rows__ !== 'undefined'){
                update_total_row(rows,template);
            }
        }
        else
        {
            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').show();
            rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
            if(typeof __update_rows__ !== 'undefined'){
                update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']'),template);
            }
        }
        if(status === 0)
        {
            rows.filter('[type = breakdown]').hide();
        }
    });


    //Select BookOutdate present/Not Present 
    
//Select Account status
    $('#select_account').on("change", function filter() {
        console.log("TEST");
        //alert("changed");
        $('.multiselector_checkbox').addClass('checked');
        $('.selector').not(this).prop('selectedIndex', 0);
        if ($(this).children("option:selected").val() === 'All') {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        } else {
            $('#bd').prop('disabled', true);
    
           jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
            console.log(selected_value);
            
            // Filter jobs based on the account status
            
            jobs.filter(function() {
                return $(this).attr("account").indexOf(selected_value) === -1;
            }).hide();
    
            $.each($('.row').not('#select_account'), function () {
                var accountStatus = $(this).attr("account");
                if (accountStatus.indexOf(selected_value) === -1) {
                    $(this).hide();
                }
                rows.filter('[type=data]').hide();
            });
        }
    });

    ($('#select_engineer')).on("change",function filter()
    {
        $('.multiselector_checkbox').addClass('checked');
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All')
        {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        }
        else
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();

            jobs.not("[engineer_nsp = " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_engineer'),function(){
                if(!JSON.stringify($(this).attr("engineers")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
            });
        }
    });

    



    ($('#select_product')).on("change",function filter()
    {
        $('.multiselector_checkbox').addClass('checked');
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All')
        {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        }
        else
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
console.log(selected_value);
            jobs.not("[product= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_product'),function(){
                if(!JSON.stringify($(this).attr("product")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
    });
    //button for selecting Weekdays (schedule_bookout page)
    ($('#select_days_week')).on("change",function filter()
    {
        $('.multiselector_checkbox').addClass('checked');
        $('.selector').not(this).prop('selectedIndex',0);
        if($(this).children("option:selected").val() === 'All')
        {
            $('#bd').prop('disabled', false);
            $('table.filterable tfoot tr').show();
            rows.show();
            jobs.show();
        }
        else
        //button for selecting last three days(schedule_bookout page)
        if($(this).children("option:selected").val() === 'LastthreeDays')
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
            console.log(selected_value);
            jobs.not("[lastthreedays= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_days_week'),function(){
                if(!JSON.stringify($(this).attr("lastthreedays")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
        else
        //Last five days selection 
        if($(this).children("option:selected").val() === 'LastfiveDays')
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
            console.log(selected_value);
            jobs.not("[lastfivedays= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_days_week'),function(){
                if(!JSON.stringify($(this).attr("lastfivedays")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
        else
        {
            $('#bd').prop('disabled', true);

            jobs.show();
            rows.show();
            $('table.filterable tfoot tr').hide();
            selected_value = $(this).children("option:selected").val();
console.log(selected_value);
            jobs.not("[days_week= " + $(this).children("option:selected").val() + "]").hide();

            $.each($('.row').not('#select_days_week'),function(){
                if(!JSON.stringify($(this).attr("days_week")).includes(selected_value))
                {
                    $(this).hide();
                }
                rows.filter('[type = data]').hide();
                
            });
        }
    });

    $('#bd').click(function(){
        if(status === 1){
            rows.filter('[type = breakdown]').hide();
            status = 0;
        }
        else if(status === 0){
            rows.show();
            $.each($('.selector').not('#select_engineer'),function(index, value){
                if($(this).children("option:selected").val() != 'All'){
                    rows.not('[' + $(this).attr('id').substring(7) + ' = '+$(this).children("option:selected").val()+']').hide();
                }
            });
            status = 1;
        }
    });

    });


//For muliselect Engineers

$(document).ready(function() {
    //console.log(rows);
    var rows = $("table.searchable tbody tr:not('.head')");
    var jobs = $(".project_item");
    var template = $('table.searchable tfoot tr td');
    allenabled = 0;
    $('#multiselect_engineer .multiselector_checkbox').click(function() {

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
                    jobs.filter("[engineer_nsp = " + $(this).val() + "]").hide();
                    jobs.filter("[engineer_nsp = " + $(this).val() + "]");

                    $.each($('.row').not('#select_engineer'),function(){
                        //console.log($(this).attr("engineers"));
                        console.log(selected_eng);
                        console.log($(this).find('.project_item:visible').length);

                        if($(this).find('.project_item:visible').length == 0){
                            console.log($(this).attr("engineers"));
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
                jobs.filter("[engineer_nsp = " + $(this).val() + "]").show();
                jobs.filter("[engineer_nsp = " + $(this).val() + "]");

                $.each($('.row').not('#select_engineer'),function(){
                    if(JSON.stringify($(this).attr("engineers")).includes(selected_eng))
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
    $('.search_option_button').click(function() {
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