let max_bg_num = 7;
    refresh_item();
    $("#pomodoro-submit").on("click", function() {

        let content = $("#pomodoro-item-content").val();
        let time = $("#pomodoro-range").val();
        if ($.trim(content) == "") {
            $("#pomodoro-item-content").css("border", "1px solid #e74c3c");
            return false;
        }
        $.ajax({
            url: "/api/add_item.php",
            type: "POST",
            data: {
                content: content,
                item_time: time,
                rest_time: 5,

            },
            success: function(data) {
                console.log(data);
            }
        }).done(function() {
            refresh_item();
        });
        clear_add_item();
        $("#pomodoro-item-content").css("border", "1px solid #000");

        return false;
    });
    $("#pomodoro-cancel").on("click", function() {
        clear_add_item();
    });
    $("#show-add-item").on("click", function() {
        show_add_item();
    });
    $("#stop-record").on("click", function() {
        close_record();
    });

    function refresh_item() {
        $(".content-bar").empty();
        $.getJSON("/api/get_item.php", function(data) {
                console.log(data);
                $.each(data, function(i, item_data) {
                    let item = `<div class="item-show pomodoro">
                                    <div class="left-bar">
                                        <span class="item-name">
                                            <nobr>${item_data.item_name}</nobr>
                                        </span>
                                        <span class="item-time">${item_data.item_time} min</span>
                                    </div>
                                    <div class="start-right-bar">
                                        <span onclick="start_record_by_id(${item_data.id})">START</span>
                                    </div>
                                </div>`;
                    $(".content-bar").append(item);
                });
            })
            .done(function() {
                console.log("success");
            });
    }

    function clear_add_item() {
        $(".add-event-bar").fadeOut(90);
        $(".add-event-shadow").fadeOut(100);
        $("#pomodoro-item-content").val("");
        $("#pomodoro-range").val(25);
        document.getElementById('show').innerHTML = $("#pomodoro-range").val() + ' Minutes';
    }

    function show_add_item() {
        $("#pomodoro-technique").prop("checked",true);
        $(".add-event-bar").fadeIn(100);
        $(".add-event-bar").css("display", "flex");
        $(".add-event-shadow").fadeIn(90);
        $("#pomodoro-item-content").css("border", "#000 solid 1px");

    }

    function start_record_by_id(item_id) {
        $(".nav-bar").hide();
        $(".content-bar").hide();
        random_background(max_bg_num);
        $(".record-time-bar").slideDown(1000);
        //$(".record-time-bar").css("display", "flex");

        $.getJSON("/api/get_item.php", function(data) {
            $.each(data, function(i, item_data) {
                if (item_data['id'] == item_id) {
                    $(".record-title span nobr").html(item_data['item_name']);
                    let time = item_data['item_time'];
                    if (time < 10) {
                        time = '0' + time;
                    }
                    $('.record-time span').html(time + ":00");
                    let start_timestamp = new Date().getTime();
                    console.log(start_timestamp.toString());
                    start_timestamp = start_timestamp.toString().substring(0, 10);
                    console.log(start_timestamp);
                    start_timestamp = parseInt(start_timestamp);
                    let timeLeft = item_data['item_time'] * 60;
                    window.record_timer = setInterval(function() {
                        timeLeft--;
                        if (timeLeft <= 0) {
                            clearInterval(record_timer);
                            $(".record-time span").html("00:00");
                            let end_timestamp = new Date().getTime();
                            end_timestamp = end_timestamp.toString().substring(0, 10);
                            end_timestamp = parseInt(end_timestamp);
                            finish_record(item_id, item_data['item_name'], item_data['rest_time'], start_timestamp, end_timestamp, item_data['item_time']);
                            return;
                        }
                        let min = Math.floor(timeLeft / 60);
                        let sec = timeLeft - min * 60;
                        if (min < 10) {
                            min = "0" + min;
                        }
                        if (sec < 10) {
                            sec = "0" + sec;
                        }
                        $(".record-time span").html(min + ":" + sec);
                    }, 1000);
                    console.log(item_id);
                    return false;
                }
            });
        });
    }

    function random_background(max_num) {
        let random_num = Math.floor(Math.random() * max_num) + 1;
        $(".record-time-bar").css("background", `url("/style/img/${random_num}.webp") no-repeat center ,url("/style/img/${random_num}.jpg") no-repeat center`);
    }

    function finish_record(item_id, item_name, rest_time, start_ts, end_ts, last_min) {
        console.log(start_ts);
        $.ajax({
            url: "/api/finish_item.php",
            type: "POST",
            data: {
                item_id: item_id,
                item_name: item_name,
                start_time: start_ts,
                end_time: end_ts,
                last_time: last_min,
            },
            success: function(data) {
                console.log(data);
            }
        });
        start_rest(rest_time);
    }

    function start_rest(rest_time) {
        $(".record-title span nobr").html("TAKING A BREAK ~");
        let timeLeft = rest_time * 60;
        if (rest_time < 10) rest_time = '0' + rest_time;
        $('.record-time span').html(rest_time + ":00");
        window.record_timer = setInterval(function() {
            // console.log(rest_time);
            timeLeft--;
            if (timeLeft <= 0) {
                clearInterval(record_timer);
                $(".record-time span").html("00:00");
                close_record();
                return;
            }
            let min = Math.floor(timeLeft / 60);
            let sec = timeLeft - min * 60;
            if (min < 10) {
                min = "0" + min;
            }
            if (sec < 10) {
                sec = "0" + sec;
            }
            $(".record-time span").html(min + ":" + sec);
        }, 1000);
    }

    function close_record() {
        let audio = $('#record-audio')[0];
        audio.pause();
        audio.currentTime = 0;
        clearInterval(window.record_timer);
        $(".record-time-bar").slideUp(1000, function() {
            $(".nav-bar").show();
            $(".content-bar").show();
        });
        $("#play-music").css("color", "rgba(255,255,255,.6)");
        return;
    }

    function control_record_music() {
        let audio = $('#record-audio')[0];
        if (audio.paused) {
            audio.play();
            $("#play-music").css("color", "rgba(255,255,255,1)")
        } else {
            audio.pause();
            $("#play-music").css("color", "rgba(255,255,255,.6)")
        }
    }