function fetchData(processOrderNumber) {
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    $.ajax({
        url: "/getBatchDataByProcessOrders",
        type: "POST",
        data: {
            process_order_number: processOrderNumber
        },
        headers: headers,
        dataType: "json",
        success: function(response) {
            console.log(response);
            
            // Handle responses and update UI accordingly
            if (response.data.materialData!=null) {
                // Highlight corresponding button for material preparation data
                $('#qualityStep_3').css('background-color', '#7cbfa0');
                
            }
            if (response.data.manufacturingData) {
                // Highlight corresponding button for manufacturing data
                $('#qualityStep_2').css('background-color', '#7cbfa0');
            }
            if (response.data.planningData) {
                // Highlight corresponding button for manufacturing data
                $('#qualityStep_0').css('background-color', '#7cbfa0');
            }
            if (response.data.engineeringData) {
                $('#qualityStep_1').css('background-color', '#7cbfa0');
            }
            
            if (response.data.kittingData) {
                $('#qualityStep_4').css('background-color', '#7cbfa0');
            }
            if (response.data.fabricationFitData) {
                $('#qualityStep_5').css('background-color', '#7cbfa0');
            }
            if (response.data.weldingData) {
                $('#qualityStep_6').css('background-color', '#7cbfa0');
            }
            if (response.data.testingData) {
                $('#qualityStep_7').css('background-color', '#7cbfa0');
            }
            
            if (response.data.finishingData) {
                $('#qualityStep_8').css('background-color', '#7cbfa0');
            }
            if (response.data.subContractData) {
                $('#qualityStep_9').css('background-color', '#7cbfa0');
            }
            if (response.data.finalData) {
                $('#qualityStep_10').css('background-color', '#7cbfa0');
            }
            if (response.data.qualityData) {
                $('#qualityStep_11').css('background-color', '#7cbfa0');
            }
            if (response.data.documentationData) {
                $('#qualityStep_12').css('background-color', '#7cbfa0');
            }
          
            if (response.data.packingandTransportData) {
                $('#qualityStep_13').css('background-color', '#7cbfa0');
            } 
        },
        error: function(error) {
            console.error(error);
        }
    });
}
function fetchCompleteData(processOrderNumber) {
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        url: "/getBatchCompleteDataByProcessOrders", // Adjust URL as necessary
        type: "POST",
        data: {
            process_order_number: processOrderNumber
        },
        headers: headers,
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.data) {
                // Highlight overall status based on response
                if (response.data.overall_status === "complete") {
                    $('#button_complete_Material\\ Preparation').css('background-color', 'green');
                } else if (response.data.overall_status === "half_complete") {
                    $('#button_complete_Material\\ Preparation').css('background-color', 'orange');
                } else {
                    $('#button_complete_Material\\ Preparation').css('background-color', 'red');
                }

                // Additionally, highlight individual steps if needed
                highlightStep('cutting', response.data.cutting);
                highlightStep('deburring', response.data.deburring);
                highlightStep('forming', response.data.forming);
                highlightStep('machining', response.data.machining);
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

function highlightStep(step, status) {
    if (status === "complete") {
        $('#' + step + '_button').css('background-color', 'green');
    } else if (status === "partial") {
        $('#' + step + '_button').css('background-color', 'orange');
    } else {
        $('#' + step + '_button').css('background-color', 'transparent');
    }
}