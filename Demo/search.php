<?php
require_once('includes/functions.php');
require_once('../mysql_connect_local.php');
require_once('includes/mySQL.php');

$regErrorMessage = "";
$reg = "";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Fiona Gacquin">
    <title>Car Registration | Search Car</title>
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
            <h1>Search Car</h1>

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

            echo '
            <div class="form-container">
        <form id="addCar" class="form" method="POST" action="search.php">
            <h1>Search Result</h1>
            <div class="form-field">
                <label for="make">Make:</label>
                <input id="make" type="text" readonly value="'.$make.'">
            </div>

            <div class="form-field">
                <label for="model">Model:</label>
                <input id="model" type="text" readonly value="'.$model.'">
            </div>

            <div class="form-field">
                <label for="vin">VIN:</label>
                <input id="vin" type="text" readonly value="'.$vin.'">
            </div>

            <div class="form-field">
                <label for="yearManufacture">Year of Manufacture:</label>
                <input id="yearManufacture" type="text" readonly value="'.$yearManufacture.'">
            </div>

            <div class="form-field">
                <label for="engine">Engine:</label>
                <input id="engine" type="text" readonly value="'.$engine.'">
            </div>

            <div class="form-field">
                <label for="transmission">Transmission:</label>
                <input id="transmission" type="text" readonly value="'.$transmission.'">
            </div>

            <div class="form-field">
                <label for="seats">Number of Seats:</label>
                <input id="seats" type="text" readonly value="'.$seats.'">
            </div>

            <div class="form-field">
                <label for="doors">Number of Doors:</label>
                <input id="doors" type="text" readonly value="'.$doors.'">
            </div>

            <div class="form-field">
                <label for="fuel">Fuel Type:</label>
                <input id="fuel" type="text" readonly value="'.$fuel.'">
            </div>

            <div class="form-field">
                <label for="colour">Colour:</label>
                <input id="colour" type="text" readonly value="'.$colour.'">
            </div>

            <div class="form-field">
                <label for="reg">Reg Number:</label>
                <input id="reg" type="text" readonly value="'.$reg.'">
            </div>

            <div class="form-field">
                <label for="originalReg">Date of Original Registration: </label>
                <input id="originalReg" type="date" readonly value="'.$originalReg.'">
            </div>


    </form>
    </div>
            ';
        } else {
            echo '<h4>Sorry, no results found.</h4>';
        }
    }?>




</main>






<!--Add the js files-->
<script src="js/validation.js"></script>
<script src="js/functional.js"></script>
</body>
</html>
