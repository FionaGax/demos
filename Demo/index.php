<?php
require_once('includes/functions.php');
require_once('../mysql_connect_local.php');
require_once('includes/mySQL.php');

$make = "";
$model = "";
$vin = "";
$yearManufacture = "";
$engine = "";
$transmission = "";
$seats = "";
$doors = "";
$fuel = "";
$colour = "";
$reg = "";
$originalReg = "";


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
$regErrorMessage = "";
$originalRegErrorMessage = "";

// Check that the form was submitted
if($_SERVER['REQUEST_METHOD'] =="POST") {
//    $src = $_SERVER['PHP_SELF'];
//    $showButton = preg_replace(
//        "/class\s*=\s*'form-field [^\']*hide[^\']*'/",
//        "class='form-field'",
//        $src);

    $make = sanitizer($_POST['make']);
    $model = sanitizer($_POST['model']);
    $vin = sanitizer($_POST['vin']);
//    $vinIsValid = validateVin($vin);
//    $vin = validateVin($vin);
    $yearManufacture = sanitizer($_POST['yearManufacture']);
//    $yearManufacture = validateYearManufacture($yearManufacture);
    $engine = sanitizer($_POST['engine']);
    $transmission = sanitizer($_POST['transmission']);
    $seats = sanitizer($_POST['seats']);
    $doors = sanitizer($_POST['doors']);
    $fuel = sanitizer($_POST['fuel']);
    $colour = sanitizer($_POST['colour']);
    $reg = sanitizer($_POST['reg']);
    $originalReg = sanitizer($_POST['date']);

    // Validate the make
    $makeErrorMessage = validateDropdowns($make, $makeErrorMessage, 'Please choose a make!');

    // Validate the model
    $modelErrorMessage = validateDropdowns($model, $modelErrorMessage, 'Please choose a model!' );

    // Validate the VIN
    $vinErrorMessage = validateVin($vin);

    // Validate the year of manufacture
    $yearManufactureErrorMessage = validateYearManufacture($yearManufacture);

    // Validate the engine
    $engineErrorMessage = validateDropdowns($engine, $engineErrorMessage, 'Please choose an engine size!');

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

    // Make a function to keep the hide class away from the submit button


    // Check if there are any errorMessages, if not connect to database and run the insert query
    if($makeErrorMessage == "" && $modelErrorMessage == "" && $vinErrorMessage == "" && $yearManufactureErrorMessage == ""
    && $engineErrorMessage == ""  && $transmissionErrorMessage == "" && $seatsErrorMessage == "" && $doorsErrorMessage == ""
    && $fuelErrorMessage == "" && $colourErrorMessage == "" && $regErrorMessage == "" && $dateErrorMessage == "") {

        // Create a query to set up a table in the database
// This will only create the table if it doesn't exist
        $createTableQuery = 'CREATE TABLE IF NOT EXISTS carRegistration(
                                             make VARCHAR(30) NOT NULL,
                                             model VARCHAR(30) NOT NULL,
                                             vin VARCHAR(17) NOT NULL,
                                             yearMin VARCHAR(5) NOT NULL,
                                             engine VARCHAR(5) NOT NULL,
                                             transmission VARCHAR(30) NOT NULL,
                                             seats INT NOT NULL,
                                             doors INT NOT NULL,
                                             fuel VARCHAR(30) NOT NULL,
                                             colour VARCHAR(30) NOT NULL,
                                             reg VARCHAR(30) NOT NULL,
                                             originalreg DATE NOT NULL,
                                             PRIMARY KEY (vin)
                                             );';

        $matchVin = "Select * FROM carRegistration WHERE vin='".$vin."'";

        $matchReg = "SELECT * FROM carRegistration WHERE reg='".$reg."'";

        $insert = "INSERT INTO carRegistration (make, model, vin, yearMin, engine, transmission,
             seats, doors, fuel, colour, reg, originalreg) VALUES('$make', '$model', '$vin',
                            '$yearManufacture', '$engine', '$transmission', '$seats',
                             '$doors', '$fuel', '$colour', '$reg', '$originalReg');";

        mysqli_query($db_connection, $createTableQuery);
        // Check the VIN doesn't match an existing entry
        $vinResult = mysqli_query($db_connection, $matchVin);
        $vinArray = mysqli_num_rows($vinResult);
        $regResult = mysqli_query($db_connection, $matchReg);
        $regArray = mysqli_num_rows($regResult);
        if($vinArray > 0) {
            // echo "VIN EXISTS";
            $vinErrorMessage = "This VIN already exists in the database. Please use another VIN.";
        } else if ($regArray > 0) {
            $regErrorMessage = "This registration already exists in the database. Please use another reg.";
            //echo "Reg Exists";
        } else {
          // echo "VIN DOESN'T EXIST";

            if(mysqli_query($db_connection, $insert)) {
//                echo '<p>Inserted Successfully!</p>';
                $resultMessage = "The details were added successfully.";
                $test = mysqli_query($db_connection, $matchReg);
                $test2 = mysqli_fetch_array($test);
//                echo 'Make: '.$test2['make'];


            } else {
//                echo "<p>Unsucessful insertion!</p>";
                echo mysqli_error($db_connection);
//                echo "<p>$originalReg</p>";
                $resultMessage = "An error occurred. Please try again later.";
            }

        }
    }

//    echo '<p>Make: '.$make.'. Make is valid: '.$makeIsValid.' error .'.$makeErrorMessage.'</p>';
//    echo '<p>Model: '.$model.'. Model is valid: '.$modelIsValid.'</p>';
//    echo '<p>Vin: '.$vin.'. VIN is valid: . VIN Error: '.$vinErrorMessage.'</p>';
//    echo '<p>Year of Manufacture: '.$yearManufacture.'. Year is valid: .'.$yearManufactureIsValid.'. Year Error: '.$yearManufactureErrorMessage.'</p>';
//    echo '<p>Engine: '.$engine.'</p>';
//    echo '<p>Transmission: '.$transmission.'</p>';
//    echo '<p>Seats: '.$seats.'. Seats are valid: '.$seatsIsValid.'. Seats Error: '.$seatsErrorMessage.'</p>';
//    echo '<p>Doors: '.$doors.'. Doors are valid: '.$doorsIsValid.'. Doors Error: '.$doorsErrorMessage.'</p>';
//    echo '<p>Fuel: '.$fuel.'</p>';
//    echo '<p>Colour: '.$colour.'. Colour is valid: '.$colourIsValid.'. Colour Error: '.$colourErrorMessage.'</p>';
//    echo '<p>Reg: '.$reg.'. Reg is valid: '.$regIsValid.'. Reg Error: '.$regErrorMessage.'</p>';
//    echo '<p>Original Reg: '.$originalReg.'</p>'.$dateErrorMessage;


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Fiona Gacquin">
    <title>Car Registration | Add Car</title>
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
    <?php
    if(isset($resultMessage)) { echo $resultMessage.'<br><br>'; }

    require_once('includes/form.php');
    ?>

</main>




<!--Add the js files-->
<script src="js/validation.js"></script>
<script src="js/functional.js"></script>
</body>
</html>

