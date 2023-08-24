// EXPORT TO EXCEL
function export_production_table_to_excel(tableID) {
    // CREATE DOWNLOADLINK AND SELECT TABLE
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML
    tableHTML = tableHTML.replace(/€/g, '%20');
    tableHTML = tableHTML.replace(/ /g, '%20');
    tableHTML = tableHTML.replace(/#/g, '%20');

    // GET TODAYS DATE AND NAME THE FILE WITH IT
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    filename = 'Pre_Production_Table_' + date + '.xls';

    // CREATE DOWNLOAD OBJECT
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
        navigator.msSaveOrOpenBlob(blob, filename);
    }
    else {
        // CREATE LINK TO FILE
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        // APPLYS NAME TO DOWNLOAD
        downloadLink.download = filename;
        //TRIGGERS DOWNLOAD
        downloadLink.click();
    }
}

// BUILD CHART DATA FROM JSON
function construct_chart_data(caption, categories, data, capacity) {
    chart_data = {
        chart: {
            caption: caption,
            yaxisname: "Hours",
            showLegend: "1",
            showLabels: "1",
            labelDisplay: "Auto",
            theme: "fusion"
        },
        categories: [
            {
                category: categories
            }
        ],
        dataset: data,
        trendlines: [{
            line: [{
                isTrendZone: "1",
                startvalue: (Number(capacity) - Number(capacity * 0.05)),
                endValue: (Number(capacity) + Number(capacity * 0.05)),
                color: "#29C3BE",
                valueOnRight: "1",
                alpha: "50",
                tooltext: "Current Average Execution Between $startDataValue and $endDataValue",
                displayvalue: "Operating Average"
            }]
        }]
    };
    return chart_data;
}

// RENDER CHART WITH CATAGOIRES AND LIST ACTION CLICKS
function render_chart(chart_number, data) {
    FusionCharts.ready(function () {
        var myChart = new FusionCharts({
            type: "stackedcolumn2d",
            renderAt: "step_" + chart_number,
            width: "100%",
            height: "100%",
            dataFormat: "json",
            dataSource: data,
            events: {
                legendItemClicked: function (eventObj, dataObj) {
                    var template = $("table.searchable tfoot tr td:visible");
                    console.log(template);
                    // COMMENT DATASET NAME AND CATEGORY (WEEK NUMBER)
                    console.log(dataObj.datasetName);
                    console.log(dataObj.visible);

                    // SELECT ROWS OF ACTIVE TABLE
                    rows = $('#' + active_option + ".radio_btn_page table tr:not(':first')");

                    // CHECK STATUS OF CATEGORY THAT WE ARE CHAGNING TO

                    // IF WE ARE TURNING IT OFF HIDE ALL ROWS MATCHING CATEGORY LABEL
                    if (dataObj.visible === false) {
                        rows.filter("[prev_step_status = " + dataObj.datasetName + "]").hide();
                        var row_agg = $("table.searchable tbody tr:visible");
                        console.log(row_agg);
                        console.log(template);
                        update_total_row(row_agg, template);
                    }
                    // IF WE ARE TURNING IN ON RESHOW ALL MATCHING CATEGORIES
                    else if (dataObj.visible === true) {
                        if (dataObj.datasetName == 'BKLG') {
                            console.log("NOT APPLICABLE");
                        }
                        else {
                            // SHOW ALL ROWS MATCHING STATUS
                            rows.filter("[prev_step_status = " + dataObj.datasetName + "]").show();
                            rows.filter("[active_in_multiselect = N]").hide();
                            var row_agg = $("table.searchable tbody tr:visible");
                            console.log(row_agg);
                            update_total_row(row_agg, template);
                        }
                    }
                },
                dataplotClick: function (eventObj, dataObj) {
                    template = $("table.searchable tfoot tr td:visible");

                    console.log(dataObj.datasetName);
                    console.log(dataObj.categoryLabel);

                    rows = $('#' + active_option + ".radio_btn_page table tbody tr");

                    rows.hide();
                    rows.filter("[prev_step_status = " + dataObj.datasetName + "][est_step_start_due = " + dataObj.categoryLabel + "]").show();
                    rows.filter("[active_in_multiselect = N]").hide();
                    var row_agg = $("table.searchable tbody tr:visible");
                    update_total_row(row_agg, template);
                }
            }
        });
        myChart.render();
    });
}


var rows = 0;
$(document).ready(function () {
    //For Row sum 
    var rows = $("table.searchable tbody tr:visible");
    var template = $('table.searchable tfoot tr td:visible');
    update_total_row(rows, template);


    $('.chart_button').click(function () {
        $(this).addClass('active');
        //$(".radio_btn_page table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").hide();
        filter_field = 'prev_step_status';
        $('.chart_button').not($(this)).removeClass('active');
        $('.radio_btn_page').hide();
        $('.radio_btn_page#' + $(this).attr('id')).show();
        
        //x.show();
        active_option = $(this).attr('id');
        rows = $("table.searchable tbody tr:visible");
        var template = $('table.searchable tfoot tr td:visible');
        update_total_row(rows, template);
    });
});

// SEARCH TABLE changed to get the foot
$(document).ready(function () {
    var rows = $("#table.searchable tbody tr");
    console.log(rows);
    var template = $('table.searchable tfoot tr td');
    $('.search_docno').keyup(function () {
        console.log("TEST");
        input = $(this).val();
        $.each($(".radio_btn_page table.searchable tbody tr:not('.head')"), function () {
            $(this).hide();
            if (JSON.stringify(($(this).children().first().children().first().text())).toLowerCase().includes(input.toLowerCase()) || JSON.stringify(($(this).children().eq(4).children().first().text())).toLowerCase().includes(input.toLowerCase())) {
                $(this).show();
            }
        });
        update_total_row(rows, template);
    });
});


$(document).ready(function () {
    var rows = $("table.searchable tbody tr");
    console.log(rows);
    var template = $('table.searchable tfoot tr td');
    console.log(template);
    active = 0;
    $('.search_option_button').click(function () {
        if (!$(this).hasClass('active')) {
            $('#' + $(this).attr('id') + '.search_option_field').show();
            $(this).addClass('active');
        }
        else {
            console.log($('#' + $(this).attr('id') + '.search_option_field'));
            $('#' + $(this).attr('id') + '.search_option_field').hide();
            $(this).removeClass('active');
        }
        if (typeof __update_rows__ !== 'undefined') {
            update_total_row(rows, template);
        }
    });
})

$(document).ready(function () {
    console.log(rows);
    var template = $('table.searchable tfoot tr td');
    allenabled = 0;
    $('.multiselector_checkbox').click(function () {
        //console.log($(this).parent().parent().parent().parent().parent().parent().attr('id').substring(12));
        filter_field = $(this).parent().parent().parent().parent().parent().parent().attr('id').substring(12);
        console.log(filter_field);
        if ($(this).val() == 'All') {
            if (allenabled) {
                console.log("PASS_OFF");
                $('.multiselector_checkbox').addClass('checked');
                $(".radio_btn_page table.searchable tr:not('.head')").show();
                $(".radio_btn_page table.searchable tr:not('.head')").attr('active_in_multiselect', 'Y');
                allenabled = 0;
            }
            else {
                console.log("PASS_ON");
                $('.multiselector_checkbox').removeClass('checked', '');
                $(".radio_btn_page table.searchable tr:not('.head')").hide();
                $(".radio_btn_page table.searchable tr:not('.head')").attr('active_in_multiselect', 'N');
                allenabled = 1;
            }
        }
        else {
            if ($(this).attr('class').includes('checked')) {
                console.log("REMOVING ATTR");
                $(".radio_btn_page table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").hide();
                $(".radio_btn_page table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").attr('active_in_multiselect', 'N');
                $(this).removeClass('checked');
            }
            else {
                console.log("ADDING ATTR");
                $(".radio_btn_page table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").show();
                $(".radio_btn_page table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").attr('active_in_multiselect', 'Y');
                $(this).addClass('checked', '');
            }
        }
        rows = $("table.searchable tbody tr:visible");
        update_total_row(rows, template);
    });
});