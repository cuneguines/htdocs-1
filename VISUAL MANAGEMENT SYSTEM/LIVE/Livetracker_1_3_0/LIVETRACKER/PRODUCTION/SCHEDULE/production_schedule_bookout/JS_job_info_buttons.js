$(document).ready(function(){
    $(".project_item").click(function(){
    //$("h2.first").replaceWith( "<h2 class = 'inner first medium'>"+$(this).attr('sales_order')+"</h2>");
    $("h2.first").replaceWith( '<h2 class = "inner first medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;"onclick = "location.href='+ "'" +'/../SAP READER/SAP READER/BASE_sales_order.php?sales_order='+$(this).attr('sales_order')+ "'" +'">'+$(this).attr('sales_order')+"</button></h2>");
    $("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = "location.href='+ "'" +'../../../EXCEPTIONS/production exceptions/BASE_production_exceptions.php?po='+$(this).attr('process_order')+ ",NORMAL'" +'">'+$(this).attr('process_order')+"</button></h2>");
    //$("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = "location.href='+ "'" +'/../SAP READER/SAP READER/BASE_process_order.php?process_order='+$(this).attr('process_order')+ "'" +'">'+$(this).attr('process_order')+"</button></h2>");
    //$("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = location.href="/../SAP READER/BASE_document_search.php">'+$(this).attr('process_order')+"</button></h2>");
    $("h2.second").replaceWith( "<h2 class = 'inner second medium'>"+$(this).attr('customer')+"</h2>");
    $("h2.third").replaceWith( " <h2 style = 'color:red;' class = 'inner third medium'>"+$(this).attr('Description')+"        "+$(this).attr('qty')+"</h2>");
    $("h2.fourth").replaceWith( "<h2 class = 'inner fourth medium'>"+$(this).attr('sales_person')+"</h2>");
    $("h2.fourteenth").replaceWith( "<h2 class = 'inner fourteenth medium'>"+$(this).attr('promise_date')+"</h2>");
    $("h2.fifteenth").replaceWith( "<h2 class = 'inner fifteenth medium'>"+$(this).attr('promise_week_due')+" "+$(this).attr('weeks_on_floor')+"</h2>");
    $("h2.fifth").replaceWith( "<h2 class = 'inner fifth medium'>"+$(this).attr('engineer')+"</h2>");
    $("h2.sixth").replaceWith( "<h2 class = 'inner sixth medium'>"+$(this).attr('status')+"</h2>");
    $("h2.seventh").replaceWith( "<h2 class = 'inner seventh medium'>"+$(this).attr('stage')+"</h2>");
    $("h2.eighth").replaceWith( "<h2 class = 'inner eighth medium'>"+$(this).attr('est_fab_hrs')+" ("+$(this).attr('planned_hrs')+")</h2>");
    //comments has commodity code in it
    $("h2.eleventh").replaceWith( "<h2 class = 'inner eleventh medium'>"+$(this).attr('comments')+"</h2>");
    //Comments_2 is replaced with comments_1
    $("h2.twenty").replaceWith( "<h2 class = 'inner twenty medium'>"+$(this).attr('comments_2')+"</h2>");
    $(".project_item").removeClass("eng_active");
    $(this).addClass("eng_active");
    });
});