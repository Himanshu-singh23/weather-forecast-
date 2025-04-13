<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/wstyle.css">
</head>

<body style="background-image: url('./assets/images/bg.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">

    <header class="header" style="background-color: green">
        <h1 class="header-title">WEATHER FORECAST</h1>
    </header>

    <div class="container">
        <div class="header-sec">
            <div class="search-box">
                <input type="text" placeholder="Enter your location" class="input-box">

                <button class="fa-solid fa-magnifying-glass" id="searchBtn"></button>
            </div>
        </div>

        <div class="location-not-found">
            <h1>Sorry, Location not found!!!</h1>
            <img src="./assets/images/404.png" alt="404 Error">
        </div>

        <div class="weather-body">
            <img src="./assets/images/cloud.png" alt="Weather Image" class="weather-img">

            <div class="weather-box">
                <p class="temperature">0 <sup>°C</sup></p>
                <p class="description">light rain</p>
            </div>

            <div class="weather-details">
                <div class="humidity">
                    <i class="fa-sharp fa-solid fa-droplet"></i>
                    <div class="text">
                        <span id="humidity">45%</span>
                        <p>Humidity</p>
                    </div>
                </div>

                <div class="wind">
                    <i class="fa-solid fa-wind"></i>
                    <div class="text">
                        <span id="wind-speed">12Km/H</span>
                        <p>Wind Speed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p class="footer-text">© Copyright – All Rights Reserved Team AgriNav</p>
    </footer>

    <script src="./assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/595a890311.js" crossorigin="anonymous"></script>
</body>
</html>