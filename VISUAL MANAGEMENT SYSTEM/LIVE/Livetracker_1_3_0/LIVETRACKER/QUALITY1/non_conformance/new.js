$(document).ready(function () {
    $('#owner').hide();
    $("label[for='owner']").hide();
    $('#action').hide();
    $("label[for='action']").hide();
    $('#ddate').hide();
    $("label[for='date']").hide();
    $('#status').hide();
    $("label[for='status']").hide();

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
    /* $("#passwrd").on("keyup", function () {
        if ($(this).val() == 123456) {
            $('#owner').show();
            $("label[for='owner']").show();
            $('#action').show();
            $("label[for='action']").show();
            $('#ddate').show();
            $("label[for='date']").show();
            $('#status').show();
            $("label[for='status']").show();

        }
        else {
            if ($(this).val() == '') {
                $('#owner').hide();
                $("label[for='owner']").hide();
                $('#action').hide();
                $("label[for='action']").hide();
                $('#ddate').hide();
                $("label[for='date']").hide();
                $('#status').hide();
                $("label[for='status']").hide();
            }
        }
    });
 */



});



function myFunction(event) {

    var CurrentRow = $(event.target).closest("tr");
    // alert(CurrentRow);
    var ItemId = $("td:eq(0)", $(CurrentRow)).html();
    var ItemIssue = $("td:eq(2)", $(CurrentRow)).html();
    console.log(ItemId);
    $('#id').val(ItemId);
    $('#fileid').val('');
    $('#fileid').text('Download');
    $("label[for='download']").text('No Attachments');
    if ($('#passwrd').text().length == 0) {
        $('#owner').hide();
        $("label[for='owner']").hide();
        $('#action').hide();
        $("label[for='action']").hide();
        $('#ddate').hide();
        $("label[for='date']").hide();
        $('#status').hide();
        $("label[for='status']").hide();
    }

    $("#passwrd").on("keyup", function () {
        if ($(this).val() == 123456) {



            var today = new Date().toISOString().split('T')[0];
            $('#owner option[value="All"]').prop('selected', true);
            $('#ddate').val(today);
            //var CurrentRow = $(event.target).closest("tr");
            // alert(CurrentRow);
            // var ItemId = $("td:eq(0)", $(CurrentRow)).html();
            //var ItemIssue = $("td:eq(2)", $(CurrentRow)).html();

            console.log(ItemId);
            console.log(ItemIssue);

            $('#passwrd').val('');


            var ItemId = $('#id').val();
            console.log(ItemId);

            $.ajax({
                type: "POST",
                url: "ReadQA.php",
                cache: false,
                data: {
                    'id': ItemId,




                },
                dataType: 'json',
                success: function (response) {
                    //$("#contact").html(response)
                    //$("#contact-modal").modal('hide');
                    if
                        (response[0].length > 0) {
                        console.log('long');
                        //console.log(response[0][0][9]);
                        // $("#owner option:selected").prop("selected", false)
                        //$('#owner option[value="Lorcan Kent"]').prop('selected', true);/
                        //$('#owner').removeAttr("selected");
                        //$('#owner').val(['Lorcan Kent']);
                        //$('#owner').val(response[0][0][9]).attr('selected','selected');
                        //$('#owner').prop('selected', false);
                        //$('#owner option[value="LorcanKent"]').prop('selected', true);
                        console.log(response[0][0]['person']);
                        console.log(response[0][0]['attachments']);
                        if (response[0][0][10] == null) {
                            response[0][0][10] = 'All'
                        }

                        if (response[0][0][9] == '1900-01-01') {
                            response[0][0][9] = new Date().toISOString().split('T')[0];
                        }
                        if (response[0][0]['person'] != null) {
                            $('#owner option[value="' + response[0][0]['person'].replace(/[^A-Z0-9]/ig, "") + '"]').prop('selected', true);
                        }
                        else
                            if (response[0][0]['person'] == null) {
                                $('#owner option[value="All"]').prop('selected', true);
                            }
                            
                            if (response[0][0]['person'] == 'SeanO Brien (Q)') {
                                $('#owner option[value="Sean O Brien (Q)"]').prop('selected', true);
                            }
                            if (response[0][0]['attachments'] == null) {
                                $('#fileid').text('Download');
                            }
                            else{
                            $('#fileid').text('Download');
                            $("label[for='download']").text(response[0][0]['attachments']);
                            $('#formid').attr('action', 'uploads/'+ response[0][0]['attachments']);
                            }
                        console.log(response[0][0]['person']);

                        //$('#owner option[value="' + response[0][0]['person'].replace(/[^A-Z0-9]/ig, "") + '"]').prop('selected', true);
                        $('#action option[value="' + response[0][0][7] + '"]').prop('selected', true);
                        $('#status option[value="' + response[0][0][2] + '"]').prop('selected', true);

                        $('#ddate').val(response[0][0][9]);
                        $('#owner').show();
                        $("label[for='owner']").show();
                        $('#action').show();
                        $("label[for='action']").show();
                        $('#ddate').show();
                        $("label[for='date']").show();
                        $('#status').show();
                        $("label[for='status']").show();
                        console.log(ItemId);
                    }
                    else {
                        console.log('notlong');
                        $('#owner').show();
                        $("label[for='owner']").show();
                        $('#action').show();
                        $("label[for='action']").show();
                        $('#ddate').show();
                        $("label[for='date']").show();
                        $('#status').show();
                        $("label[for='status']").show();
                        $('#action option[value="Toolbox Talk"]').prop('selected', true).show();
                        $('#owner option[value="All"]').prop('selected', true);
                        $('#status option[value="Closed"]').prop('selected', true);

                    }

                },
                error: function () {
                    alert("Error");
                }
            });
        }

    });


}


function submit() {

    submitForm();



    return false;
};
function submitForm() {
    var x = $("#id").val();
    var y = $("#owner").val();
    var z = $("#action").val();
    var a = $("#status").val();
    var b = $("#ddate").val();
    console.log(y);
    $.ajax({
        type: "POST",
        url: "saveQA.php",
        cache: false,
        data: {
            'id': x,
            'owner': y,
            'action': z,
            'status': a,
            'date': b,


        },

        success: function (response) {
            //$("#contact").html(response)
            //$("#contact-modal").modal('hide');
            alert('input recieved');
            location.reload();
        },
        error: function () {
            alert("Error");
        }
    });

    var file_data = $('#sortpicture').prop('files')[0];

    if (file_data != undefined) {
        var form_data = new FormData();
        form_data.append('file', file_data);
        form_data.append('data', x);

        $.ajax({
            url: 'upload.php', 	// point to server-side PHP script 
            dataType: 'text',  			// what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (output) {
                alert(output); 				// display response from the PHP script, if any
            },
            error: function (response) {
                $('#sortpicture').html(response); // display error response from the server
            }
        });
        $('#pic').val('');						/* Clear the file container */
    }


}




