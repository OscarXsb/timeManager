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
    <script src="./script/echarts.min.js"></script>
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
            <li>
                <button id="show-stats">
                    <i class="fa fa-pie-chart"></i>
                </button>
            </li>
            <li>
                <button class="full-screen-btn">
                    <i class="fa fa-arrows-alt"></i>
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

    <div class="record-time-bar">
        <div class="record-content">
            <div class="record-title">
                <span>
                    <nobr>RECORD TITLE</nobr>
                </span>
            </div>
            <div class="record-time">
                <span>00:00</span>
            </div>
            <audio loop preload="auto" id="record-audio">
                <source src="/media/1.mp3" type="audio/mp3" />
                <embed src="/media/1.mp3" />
            </audio>
            <div class="record-control">
                <ul>
                    <li>
                        <button id="play-music" onclick="control_record_music()">
                            <i class="fa fa-music"></i>
                        </button>
                    </li>
                    <li>
                        <button id="start-record">
                            <i class="fa fa-pause"></i>
                            <!-- <i class="fa fa-play"></i> -->
                        </button>
                    </li>
                    <li>
                        <button id="stop-record">
                            <i class="fa fa-stop"></i>
                        </button>
                    </li>
                    <li>
                        <button id="random-background" onclick="random_background(max_bg_num)">
                            <i class="fa fa-image"></i>
                        </button>
                    </li>
                    <li>
                        <button class="full-screen-btn">
                            <i class="fa fa-arrows-alt"></i>
                        </button>
                    </li>
                </ul>
            </div>

        </div>
        <div class="record-shadow">

        </div>
    </div>
    <div class="stats-container">
        <div class="stats-tab">
            <input type="radio" name="tab" id="day-stats">
            <input type="radio" name="tab" id="week-stats">
            <input type="radio" name="tab" id="month-stats">
            <input type="radio" name="tab" id="season-stats">
            <input type="radio" name="tab" id="year-stats">
            <div class="check-box">
                <label for="day-stats"><span>Day</span></label>
                <label for="week-stats"><span>Week</span></label>
                <label for="month-stats"><span>Month</span></label>
                <label for="season-stats"><span>Season</span></label>
                <label for="year-stats"><span>Year</span></label>
            </div>
        </div>
        
        <div class="pie-stats" id="pie-stats">

        </div>
        <div class="check-merge">
            <input type="checkbox" id="merge-checkbox"><label for="merge-checkbox"><span>Merge Items</span></label>
        </div>
    </div>

    <div class="stats-toolbar">
        <button>
            <i class="fa fa-close"></i>
        </button>

    </div>

</body>
<script src="./script/item.js"></script>
<script src="./script/getstats.js"></script>
<script src="./script/fullscreen.js"></script>

</html>