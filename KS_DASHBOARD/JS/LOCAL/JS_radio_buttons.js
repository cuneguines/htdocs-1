// HOW TO USE RADIO BUTTONS

/*
<div class = "head">
    <div class = "radio_title large">
        <div class = "title_tray">RADIO GROUP TITLE</div>
    </div>
        <div class = "radio_buttons">
            <div class = "radio_buttons_tray dark_grey">
                <div class = "radio_buttons_inner_tray">
                    <div class = "radio_button radio_btn_group_name mediumplus active" id = "option_one_name style = "width:30%">OPTION 1 TITLE</div>
                    <div class = "radio_breaker" style = "width:5%"></div>
                    <div class = "radio_button radio_btn_group_name mediumplus inactive" id = "option_two_name" style = "width:30%">OPTION 2TITLE</div>
                    <div class = "radio_breaker" style = "width:5%"></div>
                    <div class = "radio_button radio_btn_group_name mediumplus inactive" id = "option_three_name" style = "width:30%">OPTION 3 TITLE</div>
                </div>
            </div>
        </div>
    </div>
    <div class = "content">
        <div class = "radio_btn_page radio_btn_group_name" id = "option_one_name"></div>
        <div class = "radio_btn_page radio_btn_group_name" id = "option_two_name"></div>
        <div class = "radio_btn_page radio_btn_group_name" id = "option_three_name"></div>
    </div>
*/

// 1 COPY BOILER PLATE

// 2 DEPENDING ON HOW MANY RADIO OPTIONS REQUIRED COPY RADIO BUTTONS AND ADJUST WITDTH PERCENTAGE OF BUTTONS AND BREAKERS

// 3 DEFINE radio_btn_group_name AND ADD CLASSNAME TO EACH RADIO BUTTON AND DIV IN THE CONTENT DIV (MUST BE IN THE EXACT SAME POSITION AS SHOWN ABOVE, DO NOT ADD ANY CLASSNAME BEFORE radio_btn_group_name, YOU CAN ADD CLASSNAMES AFTER)

// 4 TITLE THE BUTTON GROUP AND BUTTONS (HAS NO EFFECT ON FUNCTIONALITY)

// RADIO BUTTIONS CLASS = 'radio_button radio_btn_group_name ...'
// EVERY RADIO BUTTON WILL HAVE A UNIQUE ID

// RADIO TOGGLEABLE PAGES CLASS = 'radio_btn_page radio_btn_group_name ...'
// EVERY TOGGLEABLE PAGE WILL HAVE UNQIE ID MATCHING ITS RESPECTIVE RADIO BUTTON
active_option = 'stage_1';
$(document).ready(function(){
    $('.radio_button').click(function(){
        $('.radio_button.'+$(this).attr('class').split(' ')[1]).not($(this)).removeClass('active').addClass('inactive');
        $(this).addClass('active');
        $('.radio_btn_page.'+$(this).attr('class').split(' ')[1]).hide();
        $('.radio_btn_page.'+$(this).attr('class').split(' ')[1]+'#'+$(this).attr('id')).show();
        $('.radio_btn_page.'+$(this).attr('class').split(' ')[1]).removeClass('active').addClass('inactive');
        $('.radio_btn_page.'+$(this).attr('class').split(' ')[1]+'#'+$(this).attr('id')).removeClass('inactive').addClass('active');
        active_option = $(this).attr('id');
        
        // FOR SOME PAGES TO PROP TABLES
        var element = document.getElementsByClassName("propscroll");
        if(element){
            element[0].scrollTop = 350;
        }
    })
});