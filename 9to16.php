<!-- Created by Nataliia Kulieshova, https://github.com/Kulieshova -->
<!DOCTYPE html>
<html>

<head>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap' rel='stylesheet'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js'></script>
    <title>Weatherbug forecast</title>

    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        #widget {
            width: 100%;
            aspect-ratio: 9/16;
            background-color: #414141;
            color: #fff;
        }

        #top-cover {
            height: 40%;
            width: 100%;
        }

        .small_icon {
            height: 3.5vw;
        }

        .forecast_prediction {
            width: 24vw;
            text-align: center;
            position: absolute;
            top: 140vw;
            font-weight: 300;
            font-size: 3vw;
        }

        .weekday {
            font-weight: 600;
            font-size: 3.3vw;
            margin-bottom: 3vw;
        }

        .weather_icon {
            width: 11.5vw;
            margin-bottom: 2vw;
        }

        .wind_icon {
            height: 2.5vw;
        }

        #forecast_1 {
            left: 0;
        }

        #forecast_2 {
            left: 25.35vw;
        }

        #forecast_3 {
            right: 25.35vw;
        }

        #forecast_4 {
            right: 0vw;
        }

        #alert {
            width: 84vw;
            height: auto;
            background-color: white;
            color: red;
            font-family: 'Inter', sans-serif;
            border-radius: 30px;
            position: absolute;
            right: 3vw;
            font-size: 2.3vw;
            padding: 1vw 3vw 1vw 6vw;
        }

        #alert_icon {
            width: 3vw;
            position: relative;
            margin-left: -4.6vw;
        }

        #alert {
            display: flex;
            align-items: center;
        }

        #alert_icon {
            margin-right: 10px;
            /* Adjust as needed */
        }

        #alert span {
            flex: 1;
        }
    </style>
</head>

<body>
    <?php
    $url = "https://api.open-meteo.com/v1/forecast?latitude=41.0145&longitude=-73.8726&daily=weathercode,temperature_2m_max,temperature_2m_min,windspeed_10m_max&current_weather=true&temperature_unit=fahrenheit&windspeed_unit=mph&timezone=America%2FNew_York";
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    // gets current data
    $current_temp = $data["current_weather"]["temperature"];
    $weather_now = $data["current_weather"]["weathercode"];
    $lowest_temp_today = $data["daily"]["temperature_2m_min"][0];
    $highest_temp_today = $data["daily"]["temperature_2m_max"][0];
    $wind_today = $data["current_weather"]["windspeed"];

    // reads weathercode and displays according icon and description
    if ($weather_now == 0) {
        $picture = "sunny";
        $bg_image = "../assets/backgrounds/sunny.jpg";
        $weather_decr = "Clear sky";
    } else if ($weather_now == 1) {
        $picture = "partly_cloudy";
        $bg_image = "../assets/backgrounds/sunny.jpg";
        $weather_decr = "Mainly clear";
    } else if ($weather_now == 2) {
        $picture = "partly_clear";
        $bg_image = "../assets/backgrounds/cloudy.jpg";
        $weather_decr = "Partly cloudy";
    } else if ($weather_now == 3) {
        $picture = "cloudy";
        $bg_image = "../assets/backgrounds/cloudy.jpg";
        $weather_decr = "Overcast";
    } else if ($weather_now == 45 || $weather_now == 48) {
        $picture = "fog";
        $bg_image = "../assets/backgrounds/cloudy.jpg";
        $weather_decr = "Foggy";
    } else if ($weather_now == 51 || $weather_now == 53 || $weather_now == 55) {
        $picture = "drizzle";
        $bg_image = "../assets/backgrounds/rainy.jpg";
        $weather_decr = "Drizzle";
    } else if ($weather_now == 56 || $weather_now == 57) {
        $picture = "freezing_rain";
        $bg_image = "../assets/backgrounds/rainy.jpg";
        $weather_decr = "Freeing drizzle";
    } else if ($weather_now == 61 || $weather_now == 63 || $weather_now == 65) {
        $picture = "rain";
        $bg_image = "../assets/backgrounds/rainy.jpg";
        $weather_decr = "Rainy";
    } else if ($weather_now == 66 || $weather_now == 67) {
        $picture = "freezing_rain";
        $bg_image = "../assets/backgrounds/rainy.jpg";
        $weather_decr = "Freezing rain";
    } else if ($weather_now == 71 || $weather_now == 73 || $weather_now == 75) {
        $picture = "snow";
        $bg_image = "../assets/backgrounds/snowy.jpg";
        $weather_decr = "Snow fall";
    } else if ($weather_now == 77) {
        $picture = "snow_grains";
        $bg_image = "../assets/backgrounds/snowy.jpg";
        $weather_decr = "Snow grains";
    } else if ($weather_now == 80 || $weather_now == 81 || $weather_now == 82) {
        $picture = "rain";
        $bg_image = "../assets/backgrounds/rainy.jpg";
        $weather_decr = "Rain showers";
    } else if ($weather_now == 85 || $weather_now == 86) {
        $picture = "snow";
        $bg_image = "../assets/backgrounds/snowy.jpg";
        $weather_decr = "Snow showers";
    } else if ($weather_now == 95 || $weather_now == 96 || $weather_now == 99) {
        $picture = "thunderstorm";
        $bg_image = "../assets/backgrounds/rainy.jpg";
        $weather_decr = "Thunderstorm";
    }
    ?>
    <?php
    echo " <div id='widget'>
        <div id='top-cover' style='background-image: url($bg_image); background-size: cover;'>";

    ?>
    <?php
    // gets system's date
    date_default_timezone_set('America/New_York');
    $month = date('M');
    $date = date('d');
    echo "<div style='font-weight: bold; font-size: 15vw; text-align: left; padding: 3vw 2.5vw 0vw; margin-bottom: calc(-1 * 5vw); width: auto;' id='month'>$month</div>";
    echo "<div style='font-weight: bold; font-size: 16vw; text-align: left; padding-left: 2.5vw; width: auto;' id='month'>$date</div>";
    echo "<div style='font-weight: bold; font-size: 19vw; text-align: left; padding-left: 2.5vw; width: auto; position: absolute; right: 2.5vw; top: 50vw;' id='current_temperature'><span>$current_temp</span>° F</div>";

    // gets alerts from the weather bit api
    $url_alerts = "https://api.weatherbit.io/v2.0/alerts?lat=41.0145&lon=-73.8726&key=3e9ad9f2717c45af874b3f794d75f65b";
    $json_alerts = file_get_contents($url_alerts);
    $data_alerts = json_decode($json_alerts, true);
    $alert = $data_alerts["alerts"];
    $warning = "";
    $warning_count = 0;

    // Checks if the API has any alerts, and then gets just the most urgent warnings
    if (!empty($alert)) {
        for ($i = 0; $i < count($alert); $i++) {
            if ($alert[$i]["severity"] == "Warning") {
                // Makes sure that duplicate warnings will not be displayed
                if ($warning_count == 0) {
                    $warning .= $warning . $alert[$i]["title"];
                }
                $warning_count++;
            }
        }
    }
    // Prints out urgent warnings if they were found
    if ($warning != "") {
        echo "<div id='alert' class='active'>
                    <img src='../assets/weather_icons/bell.png' id='alert_icon' />
                    <span>
                    $warning
                    </span>
                </div>";
    }
    ?>
    </div>

    <div id='bottom-cover'>
        <?php
        $date_today = $data["daily"]["time"][0];
        $day_of_the_week_today = date("D", strtotime($date));
        echo "<div id='week_day_today' style='font-weight: bold; font-size: 8vw; text-align: center; padding: 2vw 0 4vw 0;'>$day_of_the_week_today</div>";
        echo "<img src='../assets/weather_icons/$picture.png' id='logo' style='width: 20vw; position: relative; left: 40vw;' />";
        echo "<div id='weather_today' style='font-weight: 600; font-size: 5.5vw; text-align: center; padding: 2vw 0 4vw 0;'>$weather_decr</div>";

        echo "<div style='text-align: center; font-size: 3.5vw; padding-bottom: 2vw; font-weight: 300 '>High: <span>$highest_temp_today</span>°F; Low: <span>$lowest_temp_today</span>°F</div>
    <div style='text-align: center; font-size: 3.5vw; font-weight: 300; padding-bottom: 5vw;'><img
            src='../assets/weather_icons/Wind.png' class='small_icon' /> Wind: <span>$wind_today</span> mph</div>"
            ?>
        <hr style='border-bottom: 0.05vw solid #545454;'>

        <?php
        // loops 4 time to print 4 days of forecast
        for ($i = 1; $i <= 4; $i++) {
            $weather_forecast = $data["daily"]["weathercode"][$i];
            $lowest_temp_forecast = $data["daily"]["temperature_2m_min"][$i];
            $highest_temp_forecast = $data["daily"]["temperature_2m_max"][$i];
            $wind_forecast = $data["daily"]["windspeed_10m_max"][$i];
            $date = $data["daily"]["time"][$i];
            $day_of_the_week = date("D", strtotime($date));

            // reads weathercode and displays according icon
            if ($weather_forecast == 0) {
                $picture_forecast = "sunny";
            } else if ($weather_forecast == 1) {
                $picture_forecast = "partly_cloudy";
            } else if ($weather_forecast == 2) {
                $picture_forecast = "partly_clear";
            } else if ($weather_forecast == 3) {
                $picture_forecast = "cloudy";
            } else if ($weather_forecast == 45 || $weather_now == 48) {
                $picture_forecast = "fog";
            } else if ($weather_forecast == 51 || $weather_now == 53 || $weather_now == 55) {
                $picture_forecast = "drizzle";
            } else if ($weather_forecast == 56 || $weather_now == 57) {
                $picture_forecast = "freezing_rain";
            } else if ($weather_forecast == 61 || $weather_now == 63 || $weather_now == 65) {
                $picture_forecast = "rain";
            } else if ($weather_forecast == 66 || $weather_now == 67) {
                $picture_forecast = "freezing_rain";
            } else if ($weather_forecast == 71 || $weather_now == 73 || $weather_now == 75) {
                $picture_forecast = "snow";
            } else if ($weather_forecast == 77) {
                $picture_forecast = "snow_grains";
            } else if ($weather_forecast == 80 || $weather_now == 81 || $weather_now == 82) {
                $picture_forecast = "rain";
            } else if ($weather_forecast == 85 || $weather_now == 86) {
                $picture_forecast = "snow";
            } else if ($weather_forecast == 95 || $weather_now == 96 || $weather_now == 99) {
                $picture_forecast = "thunderstorm";
            }

            echo " <div class='forecast_prediction' id='forecast_$i'>
        <div class='weekday'>$day_of_the_week</div>
        <img src='../assets/weather_icons/$picture_forecast.png' class='weather_icon'/>
        <div>↑<span >$highest_temp_forecast</span>F; ↓<span>$lowest_temp_forecast</span>F</div>
        <div><img src='../assets/weather_icons/Wind.png' class='wind_icon'/><span> $wind_forecast</span> mph</div>
    </div>";
        }
        ?>
    </div>
    </div>
</body>
<!-- adjusts location of the current temperature and the warning bubble based on the size of the warning text-->
<script>
    $(document).ready(function () {
        // 3.5856573705179287vw -> a magic number -> min height for the alert
        var alert_height = $('#alert').height();
        var screen_width = $(window).width();
        // alert height in vw
        alert_height = alert_height / screen_width * 100;
        var new_position = 65 - (alert_height - 3.5856573705179287) / 2;
        $('#alert').css({ 'top': (new_position - alert_height / 2) + 'vw' });
        window.console && console.log(alert_height);
        $('#current_temperature').css({ 'top': 47 - alert_height + 'vw' });
    });
</script>

</html>