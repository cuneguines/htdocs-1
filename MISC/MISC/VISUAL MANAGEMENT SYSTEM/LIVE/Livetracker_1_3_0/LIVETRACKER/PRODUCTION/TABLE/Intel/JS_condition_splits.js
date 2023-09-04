$(document).ready(function()
{
    
    
    $(".intel_click_options").click(function()
    {
        var rows = $("table.filterable tr:not(':first')");
        console.log($(this).attr('id'));

        $(".intel_click_options").removeClass("active");
        $('.selector').prop('selectedIndex', 0);
        $(this).addClass("active");
        rows.show();

        if($(this).attr('id') == 'peds_on_floor'){
            rows.filter("[status = GCompleteinIntel]").hide();
            rows.filter("[status = FCompleteinKilkishen]").hide();
            rows.filter("[status = EInKilkishenPowdercoating]").hide();
        }

        if($(this).attr('id') == 'under_40_hours'){    
            $("tr td.labremaining").each(function(){
                if ($(this).text() >= 40){
                    $(this).parent().hide();
                }
                if($(this).parent().attr('status') == 'GCompleteinIntel' || $(this).parent().attr('status') == 'FCompleteinKilkishen' || $(this).parent().attr('status') == 'EInKilkishenPowdercoating' || $(this).parent().attr('status') == 'DInDPD'){
                    $(this).parent().hide();
                }
            });
        }

        if($(this).attr('id') == 'under_80_hours'){
            $("tr td.labremaining").each(function(){
                if($(this).text() >= 80 || $(this).text() < 40){
                    $(this).parent().hide();
                }
                if($(this).parent().attr('status') == 'GCompleteinIntel' || $(this).parent().attr('status') == 'FCompleteinKilkishen' || $(this).parent().attr('status') == 'EInKilkishenPowdercoating' || $(this).parent().attr('status') == 'DInDPD'){
                    $(this).parent().hide();
                }
            });
        }

        if($(this).attr('id') == 'over_80_hours'){
            $("tr td.labremaining").each(function(){
                if ($(this).text() < 80){
                    $(this).parent().hide();
                }
                if($(this).parent().attr('status') == 'GCompleteinIntel' || $(this).parent().attr('status') == 'FCompleteinKilkishen' || $(this).parent().attr('status') == 'EInKilkishenPowdercoating' || $(this).parent().attr('status') == 'DInDPD'){
                    $(this).parent().hide();
                }
            });
        }

        if($(this).attr('id') == 'paused'){
            $("tr td.labremaining").each(function(){
                if($(this).parent().attr('status') != 'CPaused'){
                    $(this).parent().hide();
                }
            });
        }

        if($(this).attr('id') == 'in_dpd'){
            $("tr td.labremaining").each(function(){
                if($(this).parent().attr('status') != 'DInDPD'){
                    $(this).parent().hide();
                }
            });
        }
        if($(this).attr('id') == 'next_to_kilkishen'){
            rows.filter("[ntk = N]").hide();
        }
        if($(this).attr('id') == 'remaining_workload'){
            $("tr td.labremaining").each(function(){
                if ($(this).text() <= 0){
                    $(this).parent().hide();
                }
            });
        }
    });
});