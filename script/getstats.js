
var chartDom = document.getElementById('pie-stats');
var statsChart = echarts.init(chartDom, null, { renderer: 'svg' });
var option;
let flag = false;

function getType() {
    return "single";
}

function getStats(format, callback) {
    let datestamp = new Date().getTime();
    datestamp = datestamp.toString().substring(0, 10);
    let stats_data;
    let type = getType();
    $.ajax({
        url: "/api/get_stats_pie.php",
        type: "POST",
        data: {
            "format": format,
            "type": type,
            "datestamp": datestamp
        },
        success: function (data) {
            console.log(data);
            stats_data = JSON.parse(data);
            console.log(typeof (stats_data));
            console.log(stats_data)
        }
    }).done(function(){
        callback(stats_data);
    });
}
function UpperFirstLetter(str)  
{  
   return str.replace(/\b\w+\b/g, function(word) {  
   return word.substring(0,1).toUpperCase( ) +  word.substring(1);  
 });  
}
function setChart(format,s_data){
    option = {
        title: {
            text: UpperFirstLetter(format) +' Time Distribution',
            subtext: 'Time of '+format,
            left: 'center',
            top: '10%',
        },
        tooltip: {
            trigger: 'item',
            formatter: function (params, ticket, callback) {
                console.log(params);
                let time = params.value;
                let min = Math.floor(time / 60);
                let sec = time - min * 60;
                if (min < 10) {
                    min = "0" + min;
                }
                if (sec < 10) {
                    sec = "0" + sec;
                }
                return params.name + " (" + params.percent + '%' + ") " + '<br/>' + min + "' " + sec + "''" + "<br/>" + params.data.start_time + " ~" + params.data.finish_time;
            }
        },
        toolbox: {
            show: false,
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: true,
                    readOnly: false
                },
                restore: {
                    show: true
                },
                saveAsImage: {
                    show: true
                }
            }
        },
        series: [{
            name: 'Area Mode',
            type: 'pie',
            radius: [30, 170],
            center: ['50%', '50%'],
            // roseType: 'area',
            itemStyle: {
                borderRadius: 5
            },
            data: s_data
        }]
    };

    option && statsChart.setOption(option);
}

$("#show-stats").on("click", function () {
    flag = true;
    $(".nav-bar").hide();
    $(".content-bar").hide();
    $("#day-stats").prop("checked", true);


    $(".stats-container").slideDown(1000, function () {

        statsChart.resize({
            width: chartDom.offsetWidth,
            height: chartDom.offsetHeight
        });
    });
    $(".stats-container").css("display", "flex");
    $(".stats-toolbar").slideDown(1000);
    dayStats();
});

function dayStats(data = null) {
    getStats("day",
        function (stats_data) {
            setChart('day', stats_data);
        }
    )
}

function weekStats(data = null) {
    getStats("week",
        function (stats_data) {
            setChart('week', stats_data);
        }
    )
}

function monthStats(data = null) {
    getStats("month",
        function (stats_data) {
            setChart('month', stats_data);
        }
    )
}

function seasonStats(data = null) {
    getStats("season",
        function (stats_data) {
            setChart('season', stats_data);
        }
    )
}

function yearStats(data = null) {
    getStats("year",
        function (stats_data) {
            setChart('year', stats_data);
        }
    )
}

$(function () {
    $(window).resize(function () {
        statsChart.resize({
            width: chartDom.offsetWidth,
            height: chartDom.offsetHeight
        });
        if (flag) {
            option && statsChart.setOption(option);
        }
    });
});



$(".stats-toolbar button").on("click", function () {
    flag = false;
    $(".stats-container").slideUp(1000);
    $(".stats-toolbar").slideUp(1000, function () {
        $(".nav-bar").show();
        $(".content-bar").show();
    });

});

$(function () {
    $('input#day-stats').click(function () {
        if ($(this).is(':checked')) {
            dayStats();
        }
    });
    $('input#week-stats').click(function () {
        if ($(this).is(':checked')) {
            weekStats();
        }
    });
    $('input#month-stats').click(function () {
        if ($(this).is(':checked')) {
            monthStats();
        }
    });
    $('input#season-stats').click(function () {
        if ($(this).is(':checked')) {
            seasonStats();
        }
    });
    $('input#year-stats').click(function () {
        if ($(this).is(':checked')) {
            yearStats();
        }
    });
});