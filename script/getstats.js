
var chartDom = document.getElementById('pie-stats');
var statsChart = echarts.init(chartDom, null, {renderer: 'svg'});
var option;
let flag = false;


$("#show-stats").on("click", function () {
    flag = true;
    $(".nav-bar").hide();
    $(".content-bar").hide();
    $("#pie-stats").slideDown(1000, function () {
        // $("#pie-stats").css("display", "flex");
        statsChart.resize({
            width: chartDom.offsetWidth,
            height: chartDom.offsetHeight
        });
    });
    $(".stats-toolbar").slideDown(1000);


    let datestamp = new Date().getTime();
    datestamp = datestamp.toString().substring(0, 10);
    let stats_data;
    $.ajax({
        url: "/api/get_stats_pie.php",
        type: "POST",
        data: {
            "format": "day",
            "datestamp": datestamp
        },
        success: function (data) {
            console.log(data);
            stats_data = JSON.parse(data);
            console.log(typeof (stats_data));
            console.log(stats_data)
        }
    }).done(
        function () {
            option = {
                title: {
                    text: 'Day Time Distribution',
                    subtext: 'Time of day',
                    left: 'center',
                    top: '20%',
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
                    radius: [20, 140],
                    center: ['50%', '50%'],
                    // roseType: 'area',
                    itemStyle: {
                        borderRadius: 5
                    },
                    data: stats_data
                }]
            };

            option && statsChart.setOption(option);
        }
    )

});

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
    $("#pie-stats").slideUp(1000);
    $(".stats-toolbar").slideUp(1000, function () {
        $(".nav-bar").show();
        $(".content-bar").show();
    });

});