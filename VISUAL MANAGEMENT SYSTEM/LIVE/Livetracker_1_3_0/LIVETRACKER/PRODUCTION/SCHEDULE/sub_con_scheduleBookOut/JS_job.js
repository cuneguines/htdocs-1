$(document).ready(function(){
    $(".project_item").click(function(){
        test=$(this).attr('process_order')
        console.log(test);
        $.ajax({

            type: "POST",
            url: "SQL_subcontract_schedule_exception.php",
            data: {
                'item': test

            },

            dataType: 'json',
            success: function(data) {

console.log(data[0]);
               
                if (data[0].length==0)
                {
                    $('.brred').css({'background-color': ''}); 
                }
                else
                {
                $('.brred').css({'background-color': 'yellow'}); 
                }
               
               
            }
        });
   // $("h2.first").replaceWith( "<h2 class = 'inner first medium'>"+$(this).attr('sales_order')+"</h2>");
    $("h2.first").replaceWith( '<h2 class = "inner first medium"><button class = "bred rounded btext white medium" style = "height:30px; width:150px;"onclick = "location.href='+ "'" +'/../SAP READER/SAP READER/BASE_sales_order.php?sales_order='+$(this).attr('sales_order')+ "'" +'">'+$(this).attr('sales_order')+"</button></h2>");
    $("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = "location.href='+ "'" +'../../EXCEPTIONS/subcontract exceptions/subcontracting_schedule.php?po='+$(this).attr('process_order')+ ",NORMAL'" +'">'+$(this).attr('process_order')+"</button></h2>");
    $("h2.second").replaceWith( "<h2 class = 'inner second medium'>"+$(this).attr('customer')+"</h2>");
    $("h2.third").replaceWith( " <h2 style = 'color:red;' class = 'inner third medium'>"+$(this).attr('Description')+"        "+$(this).attr('qty')+"</h2>");
    $("h2.fourth").replaceWith( "<h2 style = 'color:red;'class = 'inner fourth medium'>"+$(this).attr('floor_date')+"</h2>");
    $("h2.fourteenth").replaceWith( "<h2 class = 'inner fourteenth medium'>"+$(this).attr('promise_date')+" "+$(this).attr('promise_week_due')+" ("+$(this).attr('week_opened')+"-"+$(this).attr('weeks_open')+")</h2>");
    $("h2.fifteenth").replaceWith( "<h2 class = 'inner fifteenth medium'>"+$(this).attr('floor_date')+" "+$(this).attr('weeks_on_floor')+"</h2>");
    $("h2.fifth").replaceWith( "<h2 class = 'inner fifth medium'>"+$(this).attr('engineer')+"</h2>");
    $("h2.sixth").replaceWith( '<h2 class = "inner sixth medium"><button class = "bred rounded btext white medium" style = "height:30px; width:150px;"onclick = "location.href='+ "'" +'../../EXCEPTIONS/PURCHASING/BASE_purchasing_exceptions.php?po='+$(this).attr('status')+ "'" +'">'+$(this).attr('status')+"</button></h2>");
    //$("h2.sixth").replaceWith( "<h2 class = 'inner sixth medium'>"+$(this).attr('status')+"</h2>");
    $("h2.seventh").replaceWith( "<h2 class = 'inner seventh medium'>"+$(this).attr('stage')+"</h2>");
    $("h2.twentyone").replaceWith( "<h2 class = 'inner sixthsc medium'>"+$(this).attr('weeks_on_floor')+"</h2>");
    $("h2.eleventh").replaceWith( "<h2 class = 'inner eleventh medium'>"+$(this).attr('comments')+"</h2>");
    $("h2.twenty").replaceWith( "<h2 class = 'inner twenty medium'>"+$(this).attr('comments_2')+"</h2>");
    $(".project_item").removeClass("eng_active");
    $(this).addClass("eng_active");
    });
});