<!-- Created by Nataliia Kulieshova, https://github.com/Kulieshova -->
<!DOCTYPE html>
<html>

<head>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap' rel='stylesheet'>
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        #widget {
            width: 100%;
            aspect-ratio: 16/9;
            background-color: #414141;
            color: #fff;
        }

        #top-cover {
            height: 45%;
            width: 100%;
        }

        #bottom-cover {
            display: grid;
            grid-template-columns: 30vw 17.5vw 17.5vw 17.5vw 17.5vw;
            text-align: center;

        }

        #bottom-cover div {
            align-items: center;
            justify-content: center;
            padding-top: 2vw;
        }

        .weekday {
            font-size: 2.4vw;
            font-weight: 600;
            margin-top: 0.85vw;
        }

        .weather_icon {
            width: 7vw;
            margin: 0 auto;
            margin-top: 1.8vw;
            margin-bottom: 1.5vw;
        }

        .small_icon {
            width: 2.4vw;
        }

        .wind_icon {
            width: 2.3vw;
        }

        .forecast_temp {
            font-size: 1.7vw;
            margin-top: 0.8vw;
        }

        .forecast_wind {
            font-size: 1.8vw;
        }

        hr {
            position: absolute;
            left: 0vw;
            width: 100vw;
            border: 0.01vw solid #545454;
            z-index: 999999999;
        }
    </style>
</head>

<body>
    <div id='widget'>
        <?php
        $url = 'https://api.open-meteo.com/v1/forecast?latitude=41.0145&longitude=-73.8726&daily=weathercode,temperature_2m_max,temperature_2m_min,windspeed_10m_max&current_weather=true&temperature_unit=fahrenheit&windspeed_unit=mph&timezone=America%2FNew_York';
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        // gets current data
        $current_temp = $data['current_weather']['temperature'];
        $weather_now = $data['current_weather']['weathercode'];
        $lowest_temp_today = $data['daily']['temperature_2m_min'][0];
        $highest_temp_today = $data['daily']['temperature_2m_max'][0];
        $wind_today = $data['current_weather']['windspeed'];

        // reads weathercode and displays according icon and description
        if ($weather_now == 0) {
            $picture = 'sunny';
            $bg_image = '../backgrounds/sunny.jpg';
            $weather_decr = 'Clear sky';
        } else if ($weather_now == 1) {
            $picture = 'partly_cloudy';
            $bg_image = '../backgrounds/sunny.jpg';
            $weather_decr = 'Mainly clear';
        } else if ($weather_now == 2) {
            $picture = 'partly_clear';
            $bg_image = '../backgrounds/cloudy.jpg';
            $weather_decr = 'Partly cloudy';
        } else if ($weather_now == 3) {
            $picture = 'cloudy';
            $bg_image = '../backgrounds/cloudy.jpg';
            $weather_decr = 'Overcast';
        } else if ($weather_now == 45 || $weather_now == 48) {
            $picture = 'fog';
            $bg_image = '../backgrounds/cloudy.jpg';
            $weather_decr = 'Foggy';
        } else if ($weather_now == 51 || $weather_now == 53 || $weather_now == 55) {
            $picture = 'drizzle';
            $bg_image = '../backgrounds/rainy.jpg';
            $weather_decr = 'Drizzle';
        } else if ($weather_now == 56 || $weather_now == 57) {
            $picture = 'freezing_rain';
            $bg_image = '../backgrounds/rainy.jpg';
            $weather_decr = 'Freeing drizzle';
        } else if ($weather_now == 61 || $weather_now == 63 || $weather_now == 65) {
            $picture = 'rain';
            $bg_image = '../backgrounds/rainy.jpg';
            $weather_decr = 'Rainy';
        } else if ($weather_now == 66 || $weather_now == 67) {
            $picture = 'freezing_rain';
            $bg_image = '../backgrounds/rainy.jpg';
            $weather_decr = 'Freezing rain';
        } else if ($weather_now == 71 || $weather_now == 73 || $weather_now == 75) {
            $picture = 'snow';
            $bg_image = '../backgrounds/snowy.jpg';
            $weather_decr = 'Snow fall';
        } else if ($weather_now == 77) {
            $picture = 'snow_grains';
            $bg_image = '../backgrounds/snowy.jpg';
            $weather_decr = 'Snow grains';
        } else if ($weather_now == 80 || $weather_now == 81 || $weather_now == 82) {
            $picture = 'rain';
            $bg_image = '../backgrounds/rainy.jpg';
            $weather_decr = 'Rain showers';
        } else if ($weather_now == 85 || $weather_now == 86) {
            $picture = 'snow';
            $bg_image = '../backgrounds/snowy.jpg';
            $weather_decr = 'Snow showers';
        } else if ($weather_now == 95 || $weather_now == 96 || $weather_now == 99) {
            $picture = 'thunderstorm';
            $bg_image = '../backgrounds/rainy.jpg';
            $weather_decr = 'Thunderstorm';
        }
        ?>
        <?php
        date_default_timezone_set('America/New_York');
        $month = date('M');
        $date = date('d');
        echo "<div id='top-cover' style='background-image: url($bg_image);background-size: cover;'>
                <div style='font-weight: bold; font-size: 7vw; text-align: left; padding: 3vw 2.5vw 0vw; margin-bottom: calc(-1 * 2vw); width: auto;'>$month</div>
                <div style='font-weight: bold; font-size: 8vw; text-align: left; padding-left: 2.5vw; width: auto;'>$date</div>
                <div style='font-weight: bold; font-size: 11vw; text-align: left; padding-left: 2.5vw; width: auto; position: absolute; right: 2.5vw; top: 2vw;'>
                <span id='current_temp'>$current_temp</span>° F</div>
                </div>";
        ?>
        <div id='bottom-cover'>
            <!-- First row -->
            <?php
            echo "<div id='weather_today' style='font-weight: bold; font-size: 3.7vw; text-align: center;'>$weather_decr</div>";
            for ($i = 1; $i <= 4; $i++) {
                $date = $data["daily"]["time"][$i];
                $day_of_the_week = date("D", strtotime($date));
                echo "<div class='weekday'>$day_of_the_week</div>";
            }
            ?>
            <hr style='top: 32vw;' />
            <!-- Second row -->
            <?php
            echo "<div style='text-align: center; font-size: 2.2vw; padding-bottom: 2vw; font-weight: 400 '>High: <span id='today_high'>$highest_temp_today</span>°F; Low: <span id='today_low'>$lowest_temp_today</span>°F</div>";
            for ($i = 1; $i <= 4; $i++) {
                $lowest_temp_forecast = $data["daily"]["temperature_2m_min"][$i];
                $highest_temp_forecast = $data["daily"]["temperature_2m_max"][$i];
                echo "<div class='forecast_temp'>↑<span>$highest_temp_forecast</span>F; ↓<span>$lowest_temp_forecast</span>F</div>";
            }
            ?>
            <hr style='top: 38vw;' />
            <!-- Third row -->
            <?php
            for ($i = 0; $i <= 4; $i++) {

                $weather_forecast = $data["daily"]["weathercode"][$i];
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
                echo "<img src='../weather_icons/$picture_forecast.png' class='weather_icon' />";
            }
            ?>
            <hr style='top: 48vw;' />

            <!-- Forth row -->
            <?php
            echo "<div style='text-align: center; font-size: 2.3vw; font-weight: 400; '><img src='../weather_icons/Wind.png' class='small_icon' /> Wind: <span id='wind_today'>$wind_today</span> mph</div>";
            for ($i = 1; $i <= 4; $i++) {
                $wind_forecast = $data["daily"]["windspeed_10m_max"][$i];
                echo "<div class='forecast_wind'><img src='../weather_icons/Wind.png' class=' wind_icon' /><span> $wind_forecast</span> mph</div>";
            }
            ?>

        </div>
    </div>
</body>

</html>