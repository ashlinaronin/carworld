<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    $app = new Silex\Application();

    $app->get('/', function() {
        return "<h1>Who goes there?!</h1>
            <h3><a href='/carworld-search'>Please visit CarWorld</a></h3>
        ";
    });

    $app->get('/carworld-search', function() {
        return "<html>
                    <head>
                        <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
                        <title>Find a Car</title>
                    </head>
                      <body>
                        <div class='container'>
                          <h1>Find a Car</h1>
                          <form  action='/carworld-results' method='get'>
                            <div class='form-group'>
                              <label for='price'>Enter Maximum Price</label>
                              <input type='number' name='price' id='price' class='form-control'>
                            </div>
                            <div class='form-group'>
                                <label for='miles'>Enter Maximum Miles</label>
                                <input type='number' name='miles' id='miles' class='form-control'>
                            </div>
                            <button name='submit' class='btn btn-success'>Submit</button>
                          </form>
                        </div>
                      </body>
                </html>";
    });


    $app->get('/carworld-results', function() {
        setlocale(LC_MONETARY, 'en_US'); // Adds location info for money format

        $smartcar = new Car("2017 Smartcar", 65000, 180000, "images/smartcar.jpg");
        $semitruck = new Car("1939 BigTruck", 60, 100, "images/semi.jpg");
        $segway = new Car("2009 Paul Blart", 12000, 3, "images/segway.gif");
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
                        <title>CarWorld</title>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Welcome to Car World How Can I Help You</h1>
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
