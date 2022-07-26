$(document).ready(function()
{                $(".project_item").click(function(){
                $("h2.first").replaceWith( "<h2 class = 'inner first medium'>"+$(this).attr('sales_order')+"</h2>");
                $("h2.thirteenth").replaceWith( "<h2 class = 'inner thirteenth medium'>"+$(this).attr('process_order')+"</h2>");
                $("h2.second").replaceWith( "<h2 class = 'inner second medium'>"+$(this).attr('customer')+"</h2>");
                $("h2.third").replaceWith( " <h2 style = 'color:red;' class = 'inner third medium'>"+$(this).attr('Description')+"        "+$(this).attr('qty')+"</h2>");
                $("h2.fourth").replaceWith( "<h2 class = 'inner fourth medium'>"+$(this).attr('sales_person')+"</h2>");
                $("h2.fourteenth").replaceWith( "<h2 class = 'inner fourteenth medium'>"+$(this).attr('promise_date')+" "+$(this).attr('promise_week_due')+"</h2>");
                 $("h2.fifteenth").replaceWith( "<h2 class = 'inner fifteenth medium'>"+$(this).attr('floor_date')+" "+$(this).attr('weeks_on_floor')+"</h2>");
                $("h2.fifth").replaceWith( "<h2 class = 'inner fifth medium'>"+$(this).attr('engineer')+"</h2>");
                $("h2.sixth").replaceWith( "<h2 class = 'inner sixth medium'>"+$(this).attr('status')+"</h2>");
                $("h2.seventh").replaceWith( "<h2 class = 'inner seventh medium'>"+$(this).attr('stage')+"</h2>");
                $("h2.eighth").replaceWith( "<h2 class = 'inner eighth medium'>"+$(this).attr('est_fab_hrs')+"</h2>");
                $("h2.eleventh").replaceWith( "<h2 class = 'inner eleventh medium'>"+$(this).attr('comments')+"</h2>");
                $("form.twelfth").replaceWith( "<form action = '../../../PRODUCTION/TABLE/production table/BASE_production_specific_sales_order.php' method='post' class = 'inner twelfth'><input id = 'so_button' type = 'submit' name = 'so' value = '"+ $(this).attr('sales_order')+"'/></form>");
                $(".project_item").removeClass("pressed");
                $(this).addClass("pressed");
                });
});