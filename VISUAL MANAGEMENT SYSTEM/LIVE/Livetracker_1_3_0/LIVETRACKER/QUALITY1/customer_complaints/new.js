$(document).ready(function () 
{
    /* $('#page-inner_two').hide();
    $('#product_button').click(function () {
        $('.breadcrumb').show();
        $('#page-inner_two').hide();
        $('#page-inner_three').hide();
        $('#page-inner_one').show();


    });
    
    $('#services_button_cc').click(function () {
        $('.breadcrumb').show();
        $('#page-inner_one').hide();
        $('#page-inner_two').show();

    });

      
    $('#services_button_hs').click(function () {
        $('.breadcrumb').show();
        $('#page-inner_one').hide();
        $('#page-inner_two').hide();
        $('#page-inner_three').show();

    }); */

   
      //refreshTable();
    

    

});


	
    function myFunction(event) {
        var CurrentRow = $(event.target).closest("tr");
        // alert(CurrentRow);
        var ItemId = $("td:eq(0)", $(CurrentRow)).html();
        var ItemIssue = $("td:eq(2)", $(CurrentRow)).html();


        console.log(ItemId);
        console.log(ItemIssue);

    
   
    $('#id').val(ItemId );
    $('#id').val(ItemId );
    }
	function submit(){
       
		submitForm();
      
        
    
    return false;
	};
    function submitForm(){
        var x = $("#id").val();
        var y = $("#owner").val();
        var z = $("#action").val();
        var a = $("#status").val();
        var b = $("#ddate").val();
        
        console.log(x);
        $.ajax({
           type: "POST",
           url: "saveQA.php",
           cache:false,
           data: {
            'id': x,
            'owner':y,
            'action':z,
            'status':a,
            'date':b,

        },
        
           success: function(response){
               //$("#contact").html(response)
               //$("#contact-modal").modal('hide');
               alert('input recieved');
               location.reload();
           },
           error: function(){
               alert("Error");
           }
       });
       
    }
    
  
     
