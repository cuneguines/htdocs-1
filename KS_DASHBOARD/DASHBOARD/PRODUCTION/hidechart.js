$(document).ready(function() {
  var toggled = true;
    $("#min").click(function(){
        
            //$(this).toggleClass('btn-plus');
           // $(".content").slideToggle();
            //$(".weeks").slideToggle();
            if (toggled) {
            
            $(".bott").height('160%');
            
            $(".submenu .sector.banner").css('top', '35%');
            }
            else{
              $(".bott").height('100%');
             
              $(".submenu .sector.banner").css('top', '4.5%');
            }
            toggled = !toggled;
            $(".top").slideToggle("slow");
          });
    });
