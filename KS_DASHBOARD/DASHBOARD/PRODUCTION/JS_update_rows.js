// GETS AND PROCESS VALUE IN ROW GIVEN (JQUERY ROW OBJECT) AND COLUMN X
function get_num_value(row, column) {
    value = parseFloat(row.children().eq(column).html());
    //console.log(row);
    //console.log(column);
    console.log(value);
    if (isNaN(value)) { value = 0; }
    return value;
}

function update_total_row(rows, template) {

    var column = 0;
    template.each(function () {
        console.log(column);
        if ($(this).attr('aggregateable') === 'Y') {


            if ($(this).attr('operation') === 'COUNT') {
                var count = 0;

                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') { count += 1; }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html(count);
            }

            if ($(this).attr('operation') === 'COUNT_UNIQUE') {
                var count = 0;
                var occurances = [];
                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        if (!occurances.includes($(this).children().eq(column).html())) {
                            occurances.push($(this).children().eq(column).html());
                            count += 1;
                        }
                    }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html(count);
            }
            // Find the sum of Palnned hours
            if ($(this).attr('operation') === 'SUM_P') {
                var sum = 0;
                $("table tr:visible td.p_hours").each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        //sum+=get_num_value($(this),column);

                        // console.log(customerId);
                        sum += parseFloat($(this).text());


                        //console.log(sum);
                    }
                });

                $('table.searchable tfoot tr:visible').children().eq(column).html(sum.toFixed(1));
            }
            else if ($(this).attr('operation') === 'SUM_B') {
                var sum = 0;
                $("table tr:visible td.b_hours").each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        //sum+=get_num_value($(this),column);

                        // console.log(customerId);
                        sum += parseFloat($(this).text());


                        console.log(sum);
                    }
                });

                $('table.searchable tfoot tr:visible').children().eq(column).html(sum.toFixed(1));
            }
            if ($(this).attr('operation') === 'SUM_R') {
                var sum = 0;
                $("table tr:visible td.r_hours").each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        //sum+=get_num_value($(this),column);

                        // console.log(customerId);
                        sum += parseFloat($(this).text());


                        //console.log(sum);
                    }
                });

                $('table.searchable tfoot tr:visible').children().eq(column).html(sum.toFixed(1));
            }
            if ($(this).attr('operation') === 'AVG') {
                var sum = 0;
                var count = 0;
                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        sum += get_num_value($(this), column);
                        count += 1;
                    }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html(parseInt(sum / count));
            }

            if ($(this).attr('operation') === 'MIN_NUM') {
                var min = 999999999;
                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        if (get_num_value($(this), column) < min) {
                            min = get_num_value($(this), column);
                        }
                    }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html((min));
            }

            if ($(this).attr('operation') === 'MAX_NUM') {
                var max = 0;
                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        if (get_num_value($(this), column) > max) {
                            max = get_num_value($(this), column);
                        }
                    }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html((max));
            }

            if ($(this).attr('operation') === 'MIN_STRING') {
                var min = 'ZZZZZZZZZ';
                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        if ($(this).children().eq(column).html() < min) {
                            min = $(this).children().eq(column).html();
                        }
                    }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html((min));
            }

            if ($(this).attr('operation') === 'MAX_STRING') {
                var max = '000000000';
                rows.each(function () {
                    if ($(this).attr('type') !== 'breakdown') {
                        if ($(this).children().eq(column).html() > max) {
                            max = $(this).children().eq(column).html();
                        }
                    }
                });
                $('table.searchable tfoot tr:visible').children().eq(column).html((max));
            }
        }
        else {
            $('table.searchable tfoot tr:visible').children().eq(column).html('------');
        }
        column++;
    });
}