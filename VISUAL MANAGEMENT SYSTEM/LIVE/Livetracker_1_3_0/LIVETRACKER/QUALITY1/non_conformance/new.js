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

       var file_data = $('#sortpicture').prop('files')[0];   
       var form_data = new FormData();
		form_data.append('file', file_data);
        form_data.append('data',x);
		
		$.ajax({
				url			: 'upload.php', 	// point to server-side PHP script 
				dataType	: 'text',  			// what to expect back from the PHP script, if anything
				cache		: false,
				contentType	: false,
				processData	: false,
				data		: form_data,                         
				type		: 'post',
				success		: function(output){
					alert(output); 				// display response from the PHP script, if any
				}
		 });
		 $('#pic').val('');						/* Clear the file container */
    }

       
    
    
  
     
