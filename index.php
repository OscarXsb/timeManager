<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Manager</title>
    <link rel="stylesheet" href="./style/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./style/index.css">
    <script src="./script/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="nav-bar">
        <h1>Time Manager</h1>
        <ul>
            <li>
                <button id="show-add-item">
                    <i class="fa fa-plus"></i>
                </button>
            </li>
        </ul>
    </div>
    <div class="add-event-bar">
        <div class="box-title">
            <span>Add Item</span>
        </div>
        <div class="box-content">
            <input type="radio" name="tab" id="pomodoro-technique" checked>
            <input type="radio" name="tab" id="no-scheduled-task">
            <div class="check-box">
                <label for="pomodoro-technique"><span>Pomodoro Technique</span></label>
                <label for="no-scheduled-task"><span>No Scheduled Task</span></label>
            </div>
            <div class="tab tab-pomodoro">
                <form action="javascript:;">
                    <input type="text" name="pomodoro-item-content" id="pomodoro-item-content" placeholder="Item Title" />
                    <div class="time-range-box">
                        <input type="range" id="pomodoro-range" min="5" max="120" value="25" step="5" oninput="document.getElementById('show').innerHTML=value+' Minutes'" />
                        <span id="show">25 Minutes</span>
                    </div>
                    <div class="pomodoro-control-box">
                        <button id="pomodoro-submit">Create</button>
                        <button id="pomodoro-cancel">Cancel</button>
                    </div>

                </form>
            </div>
            <div class="tab tab-no-scheduled">
                <form action="#">
                    No Scheduled Task
                </form>
            </div>

        </div>

    </div>
    <div class="add-event-shadow">
    </div>
    <div class="content-bar">
    </div>
</body>
<script>
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
        })
        clear_add_item();
        refresh_item();
        $("#pomodoro-item-content").css("border", "1px solid #000");

        return false;
    });
    $("#pomodoro-cancel").on("click", function() {
        clear_add_item();
    });
    $("#show-add-item").on("click", function() {
        show_add_item();
    });

    function refresh_item() {
        $(".content-bar").empty();
        $.getJSON("/api/get_item.php", function(data) {
                $.each(data, function(i, item_data) {
                    let item = `<div class="item-show pomodoro">
                                    <div class="left-bar">
                                        <span class="item-name">
                                            <nobr>${item_data.item_name}</nobr>
                                        </span>
                                        <span class="item-time">${item_data.item_time} min</span>
                                    </div>
                                    <div class="start-right-bar">
                                        <span>START</span>
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
    }

    function show_add_item() {
        $(".add-event-bar").fadeIn(100);
        $(".add-event-bar").css("display", "flex");
        $(".add-event-shadow").fadeIn(90);
        $("#pomodoro-item-content").css("border", "#000 solid 1px");

    }
</script>

</html>