$(document).ready(function () 
{
    $('.selector').prop('selectedIndex', 0);
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
        var today = new Date().toISOString().split('T')[0];
        $('#owner option[value="All"]').prop('selected', true);
       $('#ddate').val(today);
        var CurrentRow = $(event.target).closest("tr");
        // alert(CurrentRow);
        var ItemId = $("td:eq(0)", $(CurrentRow)).html();
        var ItemIssue = $("td:eq(2)", $(CurrentRow)).html();
        
        console.log(ItemId);
        console.log(ItemIssue);

    
   
    $('#id').val(ItemId );
    $('#id').val(ItemId );

    $.ajax({
        type: "POST",
        url: "ReadQA.php",
        cache:false,
        data: {
         'id': ItemId,

         
        

     },
     dataType: 'json',
        success: function(response){
            //$("#contact").html(response)
            //$("#contact-modal").modal('hide');
            console.log(response[0]);
            //console.log(response[0][0][9]);
           // $("#owner option:selected").prop("selected", false)
            //$('#owner option[value="Lorcan Kent"]').prop('selected', true);/
            //$('#owner').removeAttr("selected");
            //$('#owner').val(['Lorcan Kent']);
            //$('#owner').val(response[0][0][9]).attr('selected','selected');
            //$('#owner').prop('selected', false);
            //$('#owner option[value="LorcanKent"]').prop('selected', true);
            if (response[0][0][10]=='null')
            {
                response[0][0][10]='All'
            }
            if (response[0][0][9]=='1900-01-01')
            {
                response[0][0][9]=new Date().toISOString().split('T')[0];
            }
            $('#owner option[value="'+response[0][0][10]+'"]').prop('selected', true);
            $('#action option[value="'+response[0][0][7]+'"]').prop('selected', true);
            $('#status option[value="'+response[0][0][2]+'"]').prop('selected', true);
            //$('#ddate option[value="'+response[0][0][9]+'"]').prop('selected', true);
            $('#ddate').val(response[0][0][9]);
            //alert('input recieved');
            //location.reload();
          
        },
        error: function(){
            alert("Error");
        }
    }); 
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
       console.log(y);
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
      
       if (file_data!=undefined)
       {
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
				},
                error: function (response) {
                    $('#sortpicture').html(response); // display error response from the server
                }
		 });
		 $('#pic').val('');						/* Clear the file container */
        }
    }

       
    
    
  
     
