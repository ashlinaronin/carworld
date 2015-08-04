<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    $app = new Silex\Application();

    $app->get('/', function() {
        return "<h1>Who goes there?!</h1>
            <h3><a href='/carworld'>Please visit CarWorld</a></h3>
        ";
    });

    $app->get('/carworld', function() {
        setlocale(LC_MONETARY, 'en_US'); // Adds location info for money format

        $smartcar = new Car("2017 Smartcar", 65000, 180000, "images/smartcar.jpg");
        $semitruck = new Car("1939 BigTruck", 60, 100, "images/semi.jpg");
        $segway = new Car("2009 Paul Blart", 12000, 3, "images/segway.jpg");
        $tonka = new Car ("2000 Dumptruck", 3, 15, "images/tonka.jpg");

        $cars = array($smartcar, $semitruck, $segway, $tonka);

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_GET["price"], $_GET["miles"])) {
                array_push($cars_matching_search, $car);
            }
        }

        $output = "<html>
                    <head>
                        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
                        <title>Your Car Dealership's Homepage</title>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Your Car Dealership</h1>
                            <ul>";

        if (!empty($cars_matching_search)){
            foreach ($cars_matching_search as $car) {
                $current_make_model = $car->getMake();
                $current_price = money_format('%(#10.0n', $car->getPrice());
                $current_miles = $car->getMiles();
                $current_image = $car->getImagePath();

                $output = $output .
                    "<li><strong>$current_make_model</strong></li>
                    <ul>
                        <li>$current_price</li>
                        <li>Miles: $current_miles</li>
                        <li><img src='$current_image' alt='$current_make_model'></li>
                    </ul>";
            }
        }
        else {
                $output = $output .
            "Your search returned no results.";
        }

        $output = $output . "</ul></div></body></html>";
        return $output;


    });

    return $app;
?>
