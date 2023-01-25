$(document).ready(function () {
    var value='no';
    $(".project_item").click(function () {


        test = $(this).attr('process_order');
        itemname = $(this).attr('Description');
        //console.log(test);
        //console.log(itemname);
        $.ajax({

            type: "POST",
            //url: "SQL_subcontract_schedule_test.php",
            data: {
                'item': test

            },

            dataType: 'json',
            success: function (data) {

                //console.log(data[0]);

                if (data[0].length == 0) {
                    $('.brred').css({ 'background-color': '' });
                }
                else {
                    $('.brred').css({ 'background-color': 'yellow' });
                }


            }
        });
        //AJAX to give pink border when the onhand < qunatity required 
        salesorder = $(this).attr('sales_order');
        processorder=$(this).attr('process_order');
        //console.log(salesorder);
        $.ajax({

            type: "POST",
            //url: "SQL_production_schedule_qty.php",
            data: {
                'item': salesorder,
                'porder':processorder


            },

            dataType: 'json',
            success: function (data) {

               //console.log(data);
                var value_onhand = 0;
                var value_onqty= 0;
              $.each(data.data, function (i) {

                   $.each(data.data[i], function (key , val)
                   {
if (key=='On Hand' )
{


                        value_onhand=Math.trunc( val );
                        console.log(value_onhand);
                    }
                        if(key=='Quantity')
                        {
                            value_onqty=Math.trunc( val );
                            console.log(value_onqty);
                        }
                        if (value_onhand>0 && value_onhand<value_onqty)
                        {
                            value='yes';
                        }
                        else 
                        value='no';
                   });
                    
                });
               
                    //console.log(data.data.length);
                

     
       console.log(value);
        if (value=='yes') {
            //console.log(value);
            $('.brred').css({ 'border': '5px solid rgb(170, 51, 106)' });
        }
        else {
            $('.brred').css({ 'border': '' });
        }



    }
            });

//$("h2.first").replaceWith( "<h2 class = 'inner first medium'>"+$(this).attr('sales_order')+"</h2>");
$("h2.first").replaceWith('<h2 class = "inner first medium"><button class = "bred rounded btext white medium" style = "height:30px; width:150px;"onclick = "location.href=' + "'" + '/../SAP READER/SAP READER/BASE_purchase_order.php?purchase_order=' + $(this).attr('purchase_order') + "'" + '">' + $(this).attr('purchase_order') + "</button></h2>");
/* $("h2.thirteenth").replaceWith('<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = "location.href=' + "'" + '../../../PRODUCTION/EXCEPTIONS/production exceptions/BASE_production_exceptions.php?po=' + $(this).attr('process_order') + ",NORMAL'" + '">' + $(this).attr('process_order') + "</button></h2>");
//$("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = "location.href='+ "'" +'/../SAP READER/SAP READER/BASE_process_order.php?process_order='+$(this).attr('process_order')+ "'" +'">'+$(this).attr('process_order')+"</button></h2>");
//$("h2.thirteenth").replaceWith( '<h2 class = "inner thirteenth medium"><button class = "brred rounded btext white medium" style = "height:30px; width:150px;" onclick = location.href="/../SAP READER/BASE_document_search.php">'+$(this).attr('process_order')+"</button></h2>");
$("h2.second").replaceWith("<h2 class = 'inner second medium'>" + $(this).attr('customer') + "</h2>");
$("h2.third").replaceWith(" <h2 style = 'color:red;' class = 'inner third medium'>" + $(this).attr('desc') +"        "+$(this).attr('qty')+"</h2>");
$("h2.fourth").replaceWith("<h2 class = 'inner fourth medium'>" + $(this).attr('sales_person') + "</h2>");
var z=$(this).attr('color_for_dates');
console.log(z);

$("h2.fourteenth").replaceWith("<h2 class = 'inner fourteenth medium' style='font-size:1.7vh;background-color:" + z + ";'>" + $(this).attr('promise_date') + "</h2>");
var x = $(this).attr('color_for_date');
console.log(x);

var y = $(this).attr('border_color_date');
console.log(y);
value = 'red';
//border: 1px solid " + y + ";border-width:0 7px 7px 7px;
//border: 1px solid " + y + ";border-width:7px 7px 0 7px;
$("p.smediums").replaceWith("<p class='smediums'style='font-size:1.7vh;background-color:" + x + ";'>" + "Promise Date" + "</p>");
$("h2.fifteenth").replaceWith("<h2 style='background-color:" + x + ";'class = 'inner fifteenth medium'>" + $(this).attr('promise_week_due') + " " + $(this).attr('weeks_on_floor') + "</h2>");
$("h2.fifth").replaceWith("<h2 class = 'inner fifth medium'>" + $(this).attr('engineer') + "</h2>");
$("h2.sixth").replaceWith("<h2 class = 'inner sixth medium'>" + $(this).attr('status') + "</h2>");
$("h2.seventh").replaceWith("<h2 class = 'inner seventh medium'>" + $(this).attr('stage') + "</h2>");
$("h2.eighth").replaceWith("<h2 class = 'inner eighth medium'>" + $(this).attr('est_fab_hrs') + " (" + $(this).attr('planned_hrs') + ")</h2>");
//comments has commodity code in it

//Comments_2 is replaced with comments_1
$("h2.twenty").replaceWith("<h2 class = 'inner twenty medium'>" + $(this).attr('comments_2') + "</h2>");
$(".project_item").removeClass("eng_active");
$(this).addClass("eng_active");

x = ""; */
var x = $(this).attr('color_for_date');
console.log(x);

$("h2.eleventh").replaceWith("<h2 class = 'inner eleventh medium rtext'>" + $(this).attr('comments') + "</h2>");
$("h2.third").replaceWith(" <h2 style = 'color:red;' class = 'inner third medium'>" + $(this).attr('desc') +"        ("+$(this).attr('qty')+")</h2>");
$("h2.fifteenth").replaceWith("<h2 style='background-color:" + x + ";'class = 'inner fifteenth medium'>" + $(this).attr('date') + "</h2>");
$("h2.fourth").replaceWith("<h2 class = 'inner fourth medium'>" + $(this).attr('qty') + "</h2>");
$("h2.fifth").replaceWith("<h2 class = 'inner fifth medium'>" + $(this).attr('outqty') + "</h2>");
$("h2.twent").replaceWith("<h2 class = 'inner twent medium'>" + $(this).attr('comment2') + "</h2>");
$(".project_item").removeClass("eng_active");
$(this).addClass("eng_active");
    });



    
});

