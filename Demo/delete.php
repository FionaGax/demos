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
        $deleteQuery = "DELETE FROM carRegistration WHERE reg='" . $reg . "'";

        if(mysqli_query($db_connection, $deleteQuery)) {
            // Successful
            echo "<h4>The record has been deleted successfully.</h4>";
        } else {
            echo "<h4>Sorry, an error occurred, please try again later.</h4>";
        }
    } else {
        echo '<h4>Sorry, no results found.</h4>';
    }
}?>