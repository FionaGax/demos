<?php
require_once('includes/functions.php');
require_once('../mysql_connect_local.php');
require_once('includes/mySQL.php');

$regErrorMessage = "";
$reg = "";
$makeErrorMessage = "";
$modelErrorMessage = "";
$vinErrorMessage = "";
$yearManufactureErrorMessage = "";
$engineErrorMessage = "";
$transmissionErrorMessage = "";
$seatsErrorMessage = "";
$doorsErrorMessage = "";
$fuelErrorMessage = "";
$colourErrorMessage = "";
$originalRegErrorMessage = "";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Fiona Gacquin">
    <title>Car Registration | Update Car Details</title>
    <!-- Latest compiled and minified CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- Link to local css stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!--Include the header-->
<?php
require_once('includes/header.php');
?>
<!--Include the form-->
<main>
    <div class="form-container">
        <form id="addCar" class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <h1>Search Car to Update</h1>

            <div class="form-field">
                <label for="reg">Registration Number:</label>
                <input type="text" name="reg" id="reg" placeholder="131d2019" autocomplete="off" required value="<?php if($reg !== "") {echo $reg;}?>">
                <small><?php if($regErrorMessage !== "") {echo $regErrorMessage; } ?></small>
            </div>

            <div id="searchButton" class="form-field">
                <input type="submit" value="Search">
            </div>
        </form>
    </div>


    <?php

    // Check that the form was submitted
    if($_SERVER['REQUEST_METHOD'] =="POST") {
        // echo 'Form submitted!';
        $reg = sanitizer($_POST['reg']);
        $regErrorMessage = validateReg($reg);

        $matchReg = "SELECT * FROM carRegistration WHERE reg='" . $reg . "'";
        $searchResult = mysqli_query($db_connection, $matchReg);
        $positiveResult = mysqli_num_rows($searchResult);
        if ($positiveResult > 0) {
            //    echo 'A match was found';

            // Put the results into the array
            $row = mysqli_fetch_array($searchResult);

            $make = $row['make'];
            $model = $row['model'];
            $vin = $row['vin'];
            $yearManufacture = $row['yearMin'];
            $engine = $row['engine'];
            $transmission = $row['transmission'];
            $seats = $row['seats'];
            $doors = $row['doors'];
            $fuel = $row['fuel'];
            $colour = $row['colour'];
            $reg = $row['reg'];
            $originalReg = $row['originalreg'];
            //  echo 'Make: '.$make;

            include('includes/form.php');

            // If the form is updated
            if(isset($_POST['submit'])) {
//                echo '<h4>Form submitted for update.</h4>';
//                echo '<h4>Original Model: ' . $model . ' New Model: ' . $_POST['model'] . '</h4>';

                $make = sanitizer($_POST['make']);
                $model = sanitizer($_POST['model']);
                $vin = sanitizer($_POST['vin']);
                $yearManufacture = sanitizer($_POST['yearManufacture']);
                $engine = sanitizer($_POST['engine']);
                $transmission = sanitizer($_POST['transmission']);
                $seats = sanitizer($_POST['seats']);
                $doors = sanitizer($_POST['doors']);
                $fuel = sanitizer($_POST['fuel']);
                $colour = sanitizer($_POST['colour']);
                $reg = sanitizer($_POST['reg']);
                $originalReg = sanitizer($_POST['date']);

                // Check for errors
                // Validate the make
                $makeErrorMessage = validateDropdowns($make, $makeErrorMessage, 'Please choose a make!');

                // Validate the model
                $modelErrorMessage = validateDropdowns($model, $modelErrorMessage, 'Please choose a model!');

                // Validate the VIN
                $vinErrorMessage = validateVin($vin);

                // Validate the year of manufacture
                $yearManufactureErrorMessage = validateYearManufacture($yearManufacture);

                // Validate the engine
               // $engineErrorMessage = validateDropdowns($engine, $engineErrorMessage, 'Please choose an engine size!');

                // Validate the transmission
                $transmissionErrorMessage = validateRadioButtons($transmission, $transmissionErrorMessage, 'Please choose either manual or automatic!');

                // Validate the seats
                $seatsErrorMessage = validateSeats($seats);

                // Validate the doors
                $doorsErrorMessage = validateDoors($doors);

                // Validate the fuel
                $fuelErrorMessage = validateRadioButtons($fuel, $fuelErrorMessage, 'Please choose either diesel or petrol!');

                // Validate the colour
                $colourErrorMessage = validateColour($colour);

                // Validate the reg
                $regErrorMessage = validateReg($reg);

                // Validate the date
                $dateErrorMessage = validateDate($originalReg);

                // Check to see if there were changes
                if ($make == null) {
                    $make = $row['make'];
                }

                if ($model == null) {
                    $model = $row['model'];
                }

                if ($yearManufacture == null) {
                    $yearManufacture = $row['yearMin'];
                }

                if ($engine == null || $engine === 'Select an option...') {
                    $engine = $row['engine'];
                }

                if ($transmission == null) {
                    $transmission = $row['transmission'];
                }

                if ($seats == null) {
                    $seats = $row['seats'];
                }

                if ($doors == null) {
                    $doors = $row['doors'];
                }

                if ($fuel == null) {
                    $fuel = $row['fuel'];
                }

                if ($colour == null) {
                    $colour = $row['colour'];
                }

                if ($reg == null) {
                    $reg = $row['reg'];
                }

                if ($originalReg == null) {
                    $originalReg = $row['originalreg'];
                }

                // Make a function to keep the hide class away from the submit button


                // Check if there are any errorMessages, if not connect to database and run the update query
                if ($makeErrorMessage == "" && $modelErrorMessage == "" && $vinErrorMessage == "" && $yearManufactureErrorMessage == ""
                    && $engineErrorMessage == "" && $transmissionErrorMessage == "" && $seatsErrorMessage == "" && $doorsErrorMessage == ""
                    && $fuelErrorMessage == "" && $colourErrorMessage == "" && $regErrorMessage == "" && $dateErrorMessage == "") {
                    $updateQuery = "UPDATE carRegistration SET make='$make',
                                            model = '$model',
                                            yearMin = '$yearManufacture',
                                            engine = '$engine',
                                            transmission = '$transmission',
                                            seats = '$seats',
                                            doors = '$doors',
                                            fuel = '$fuel',
                                            colour = '$colour',
                                            reg = '$reg',
                                            originalreg = '$originalReg'
                                            WHERE vin = '$vin';";

                    // Run query
                    if(mysqli_query($db_connection, $updateQuery)) {
                        echo "<h4>The details were updated successfully; </h4>";
//                        echo $make; echo $model; echo $yearManufacture; echo $engine; echo $transmission; echo $seats;
//                        echo $doors; echo $fuel; echo $colour; echo $reg; echo $vin;
                    } else {
                        echo "<h4>Sorry, there was an error. Please try again later.</h4>";
//                        echo $make; echo $model; echo $yearManufacture; echo $engine; echo $transmission; echo $seats;
//                        echo $doors;
                    }
                }
            }
        } else {
            echo '<h4>Sorry, no results found.</h4>';
        }
    }
    ?>



</main>






<!--Add the js files-->
<script src="js/validation.js"></script>
<script src="js/functional.js"></script>
</body>
</html>
