var __update_rows__ = 1;

// GETS AND PROCESS VALUE IN ROW GIVEN (JQUERY ROW OBJECT) AND COLUMN X
function get_num_value(row,column){
    value = parseInt(row.children().eq(column).html().replace(/,/g, '').replace(/%/g, ''));
    if(isNaN(value)){value = 0;}
    return value;
}

function update_total_row(rows, template){ 
    
    var column = 0; 
    template.each(function(){
        if($(this).attr('aggregateable') === 'Y'){


            if($(this).attr('operation') === 'COUNT'){
                var count = 0;
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){count+=1;}
                });
                $('table.filterable tfoot tr').children().eq(column).html(count);
            }

            if($(this).attr('operation') === 'COUNT_UNIQUE'){
                var count = 0;
                var occurances = [];
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        if(!occurances.includes($(this).children().eq(column).html())){
                        occurances.push($(this).children().eq(column).html());
                        count+=1;
                    }}
                });
                $('table.filterable tfoot tr').children().eq(column).html(count);
            }

            if($(this).attr('operation') === 'SUM'){
                var sum = 0;
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        sum+=get_num_value($(this),column);
                    }
                });
                $('table.filterable tfoot tr').children().eq(column).html(sum);
            } 

            if($(this).attr('operation') === 'AVG'){
                var sum = 0;
                var count = 0;
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        sum+=get_num_value($(this),column);
                        count+=1;
                    }
                });
                $('table.filterable tfoot tr').children().eq(column).html(parseInt(sum/count));
            }

            if($(this).attr('operation') === 'MIN_NUM'){
                var min = 999999999;
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        if(get_num_value($(this),column) < min){
                        min = get_num_value($(this),column);
                        }
                    }
                });
                $('table.filterable tfoot tr').children().eq(column).html((min));
            }

            if($(this).attr('operation') === 'MAX_NUM'){
                var max = 0;
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        if(get_num_value($(this),column) > max){
                        max = get_num_value($(this),column);
                        }
                    }
                });
                $('table.filterable tfoot tr').children().eq(column).html((max));
            }

            if($(this).attr('operation') === 'MIN_STRING'){
                var min = 'ZZZZZZZZZ';
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        if($(this).children().eq(column).html() < min){
                        min = $(this).children().eq(column).html();
                        }
                    }
                });
                $('table.filterable tfoot tr').children().eq(column).html((min));
            }

            if($(this).attr('operation') === 'MAX_STRING'){
                var max = '000000000';
                rows.each(function(){
                    if($(this).attr('type') !== 'breakdown'){
                        if($(this).children().eq(column).html() > max){
                        max = $(this).children().eq(column).html();
                        }
                    }
                });
                $('table.filterable tfoot tr').children().eq(column).html((max));
            }
        }
        else{
            $('table.filterable tfoot tr').children().eq(column).html('------');
        }
        column++;
    });
}