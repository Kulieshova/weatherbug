<!-- Created by Nataliia Kulieshova, https://github.com/Kulieshova -->
<!DOCTYPE html>
<html>
<head>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap' rel='stylesheet'>
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
            aspect-ratio: 1/1;
            background-color: #414141;
            color: #fff;
        }

        #top-cover {
            height: 75%;
            width: 100%;
        }

        .small_icon {
            height: 3.5vw;
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
        }

        #alert span {
            flex: 1;
        }

        #current_temperature {
            top: 52vw;
        }
    </style>
</head>

<body>
    <div id='widget'>
        <?php
        // Call the API to get the forecast data
        $url = "https://api.open-meteo.com/v1/forecast?latitude=41.0145&longitude=-73.8726&daily=weathercode,temperature_2m_max,temperature_2m_min,windspeed_10m_max&current_weather=true&temperature_unit=fahrenheit&windspeed_unit=mph&timezone=America%2FNew_York";
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        // gets current date and month
        $date_time = new DateTime($data["current_weather"]["time"]);
        $month = $date_time->format('M');
        $date = $date_time->format('d');

        // gets current weather data
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

        // changes background of the top container
        echo "<div id='top-cover' style ='background-image: url($bg_image); background-size: cover;'>";
        // displays current date
        echo "<div style='font-weight: bold; font-size: 15vw; text-align: left; padding: 3vw 2.5vw 0vw; margin-bottom: calc(-1 * 5vw); width: auto;' id='month'>$month</div>";
        echo "<div style='font-weight: bold; font-size: 16vw; text-align: left; padding-left: 2.5vw; width: auto;' id='date'>$date</div>";

        // Displays weather based on the value recieved in API
        echo "<img src='../assets/weather_icons/$picture.png' id='logo' style='position: absolute; top:6vw; right: 2.5vw; width: 20vw;'/>";
        echo "<div style='font-weight: bold; font-size: 19vw; text-align: left; padding-left: 2.5vw; width: auto; position: absolute; right: 2.5vw; top: 52vw;' id='current_temperature'><span>$current_temp</span>° F</div>";

        // gets alerts from the weather bit api
        $url_alerts = "https://api.weatherbit.io/v2.0/alerts?lat=41.0145&lon=-73.8726&key=3e9ad9f2717c45af874b3f794d75f65b";
        $json_alerts = file_get_contents($url_alerts);
        $data_alerts = json_decode($json_alerts, true);
        $alert = $data_alerts["alerts"];
        $warning = "";

        // Checks if the API has any alerts, and then gets just the most urgent warnings
        if (!empty($alert)) {
            for ($i = 0; $i < count($alert); $i++) {
                if ($alert[$i]["severity"] == "Warning") {
                    $warning .= $warning . $alert[$i]["title"];
                }
            }
        }
        // Prints out urgent warnings if they were found
        if ($warning != "") {
            echo "<div id='alert' class='active'>
                <img src='../assets/weather_icons/Wind.png' id='alert_icon' />
                <span>
                $warning
                </span>
            </div>";
        }
        ?>
    </div>

    <div id='bottom-cover'>
        <?php
        // prints verbal description of the current weather
        echo "<div id='weather_decription' style='font-weight: bold; font-size: 6vw; text-align: center; padding: 1.5vw 0;'>$weather_decr</div>";
        // prints forecast for today
        echo "<div style='text-align: center; font-size: 3vw; padding-bottom: 1.3vw; '>High: <span id='today_high'>$highest_temp_today</span>°F; Low: <span id='today_low'>$lowest_temp_today</span>°F</div>";
        echo "<div style='text-align: center; font-size: 3vw;'><img src='../assets/weather_icons/Wind.png' class='small_icon' /> Wind: <span id='wind_today'>$wind_today</span> mph</div>"
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
        var new_position = 69 - (alert_height - 3.5856573705179287) / 2;
        $('#alert').css({ 'top': (new_position - alert_height / 2) + 'vw' });
        window.console && console.log(alert_height);
        $('#current_temperature').css({ 'top': 51 - alert_height + 'vw' });
    });
</script>
</html>