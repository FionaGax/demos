<?php

use JetBrains\PhpStorm\Pure;

// Sanitize data
// Function to sanitizer data
function sanitizer($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = strip_tags($data);
    return htmlentities($data);
}

function validateVin(string $vin):string
{
    if (ctype_digit(substr($vin, 0))) {
        // If the vin doesn't start with a number show an error message
        $vinErrorMessage = "The first character must be a number!";
    } else if (checkLowercaseLetter($vin)) {
        // If there is no lowercase letter show an error message
        $vinErrorMessage = "There must be at least one lowercase letter!";
    } else if (checkUppercaseLetter($vin)) {
        // If there is no uppercase letter show an error message
        $vinErrorMessage = "There must be at least one uppercase letter!";
    } else if (strpos(strtolower($vin), 'i')) {
        // If there is an i show an error message
        $vinIsValid = false;
        $vinErrorMessage = "The VIN cannot contain an 'i'!";
    } else if (strpos(strtolower($vin), 'o')) {
        // If there is a o show an error message
        $vinErrorMessage = "The VIN cannot contain an 'o'!";
    } else if (strpos(strtolower($vin), 'q')) {
        // If there is a q show an error message
        $vinErrorMessage = "The VIN cannot contain an 'q'!";
    } else if (strlen($vin) < 17) {
        $vinErrorMessage = "The VIN must not be shorter than 17 characters!";
    } else if (strlen($vin) > 17) {
        // If the vin is shorter or longer than 17 characters show an error message
        $vinErrorMessage = "The VIN must not be longer than 17 characters long!";
    } else {
        $vinErrorMessage = "";
    }
    return $vinErrorMessage;
}

function validateYearManufacture(string $value): string
{
    $currentYear = date("YYYY");
    if($value < 2013) {
        // If the year is before 2013 show an error message
        $yearManufactureErrorMessage = "The year cannot be before 2013!";
    } else if ($value > $currentYear) {
        // If the year is a future year show an error message
        $yearManufactureErrorMessage = "The year cannot be after the current year! It's only " + $currentYear;
    } else {
        $yearManufactureErrorMessage = "";
    }

    return $yearManufactureErrorMessage;
}

function validateSeats(string $value): string
{
    $min = 2;
    $max = 9;

    if ($value < $min) {
        // If the number is less than two show an error
        $seatsErrorMessage = "The minimum amount of seats allowed is 2!";
    } else if ($value > $max) {
        // If the number is greater than nine show an error message
        $seatsErrorMessage = "The maximum amount of seats allowed is 9!";
    } else {
        $seatsErrorMessage = "";
    }
    return $seatsErrorMessage;
}

function validateDoors(string $value): string
{
    $min = 3;
    $max = 5;
    if ($value < $min) {
        // If the number is less than three show an error message
        $doorsErrorMessage = "The minimum amount of doors allowed is 3!";
    } else if ($value > $max) {
        // If the number is greater than five show an error message
        $doorsErrorMessage = "The maximum amount of doors allowed is 5!";
    } else {
        $doorsErrorMessage = "";
    }

    return $doorsErrorMessage;
}

function validateColour(string $value): string
{
    $colourErrorMessage = "";
    $min = 3;

    if (checkForDigit($value)) {
        // If the input value is less than three show an error message
        $colourErrorMessage = "A colour cannot contain a number!";
    }   else if (strlen($value) < $min) {
        // If there are numbers in the input show an error message
        $colourErrorMessage = "There must be at least three letters in the colour!";
    }
    return $colourErrorMessage;
}

function validateReg(string $value): string{
    // String must be split into three parts and each part must be validated seperately
    // First three characters of the string will be the year
    if (strlen($value) < 5) {
        $regErrorMessage = "The registration must be a minimum of five characters long!";
    } else {
        $regErrorMessage = "";
        $year = substr($value, 0, 3);
        // The county can be either one or two characters


        if (!ctype_digit($value[4])) {
            // If the character at index 4 is not a number then it is a letter so it is part of the county
            $county = substr($value, 3, 2);
            $number = substr($value, 5, strlen($value));
        } else {
            $county = substr($value, 3, 1);
            $number = substr($value, 4, strlen($value));
            // The number of the reg then begins at index 4

        }

        $yearIsValidError = "";
        $countyIsValidError = "";
        $numberIsValidError = "";

        $yearIsValidError = validateYear($year);
        $countyIsValidError = validateCounty($county);
        $numberIsValidError = validateNumber($number);
        // Minimum year is 131

        // If the first three characters are not numbers (131) show an error
        // If the first three characters are less than 131 show an error
        // If the third character is not equal to 1 or not equal to 2 show an error

        // If the county part (make a substring - max is 2 characters) is not equal to an element in the array then show an error
        // If the last part of the string is not a number then show an error
        // If the last part of the string is less than 1 show an error

        if ($yearIsValidError !== "") {
            $regErrorMessage = $yearIsValidError;
        } else if ($countyIsValidError !== "") {
            $regErrorMessage = $countyIsValidError;
        } else if ($numberIsValidError !== "") {
            $regErrorMessage = $numberIsValidError;
        }
    }

    return $regErrorMessage;
}

function checkLowercaseLetter($value): bool
{
    $isLower = true;
    for($i = 0; $i < strlen($value); $i++) {
        if(!ctype_lower($value[$i])) {
            $isLower = false;
            break;
        }
    }
    return $isLower;
}

function checkUppercaseLetter($value): bool
{
    $isUpper = true;
    for($i = 0; $i < strlen($value); $i++) {
        if(!ctype_upper($value[$i])) {
            $isUpper = false;
            break;
        }
    }
    return $isUpper;
}

function checkForDigit(string $value): bool
{
    $isDigit = true;
    for($i = 0; $i < strlen($value); $i++) {
        if(!ctype_digit($value[$i])) {
            $isDigit = false;
            break;
        }
    }
    return $isDigit;
}

function validateYear(string $value): string
{
    $isNumber = false;

    for($i = 0; $i < strlen($value); $i++) {
        if(ctype_digit($value[$i])) {
            $isNumber = true;
        } else {
            $isNumber = false;
            break;
        }
    }

    if ($isNumber === false) {
        $regErrorMessage = "The first three characters must be the year. Eg. 131 or 132, no letters!";
    } else if ($value[0] < 1)  {
        $regErrorMessage = "The earliest registration is 2013. The first digit cannot be 0!";
    } else if ($value[0] === '1' && $value[1] <= 2) {
        $regErrorMessage = "The earliest registration is 2013!";
    } else if ($value[2] !== '1' && $value[2] !== '2') {
        $regErrorMessage = "The last digit must be either 1 or 2!";
    } else {
        $regErrorMessage = "";

    }
    return $regErrorMessage;
}

function validateCounty(string $value): string
{   $regErrorMessage = "";

    if(strlen($value) === 1) {
        if($value !== 'c' &&
            $value !== 'd' &&
            $value !== 'g' &&
            $value !== 'l' &&
            $value !== 'w') {
            $regErrorMessage = $value . " is not a valid county representation!";

        }
    } else if (strlen($value) === 2) {
        $regErrorMessage = "That is not a valid county!";
        switch (strtolower($value)) {
            case 'cn':
            case 'cw':
            case 'ke':
            case 'ky':
            case 'dl':
            case 'ld':
            case 'lh':
            case 'lk':
            case 'ls':
            case 'kk':
            case 'mh':
            case 'mn':
            case 'mo':
            case 'oy':
            case 'rn':
            case 'tn':
            case 'ts':
            case 'so':
            case 'wh':
            case 'wx':
            case 'ww':
            case 'lm':
            case 'wd':
            case 'ce':
                $regErrorMessage = "";
                break;

        }

    }

    return $regErrorMessage;
}

function validateNumber(string $value): string
{
    // All characters of the number must be a number
    for ($i = 0; $i < strlen($value); $i++) {
        if(!ctype_digit($value[$i])) {
            return "The final part of the reg must be purely numeric!";
        }
    }

    // Ensure the number is not less then 0
    if ($value < 1) {
        $regErrorMessage = "The final part of the reg cannot be less then 1!";
    } else {
        $regErrorMessage = "";
    }

    return $regErrorMessage;
}

function validateDate(string $value): string
{
    $dateErrorMessage = "";
    $date = strtotime($value);
    $date = date('Y-m-d', $date);
    $today = date('Y-m-d');

    if(!preg_match("^[0-9]{4}-[0-1][0-9]-[0-3][0-9]$^",$value)) {
            $dateErrorMessage = "That is not a valid date!";
    }
    if ($value > $today) {
        echo "<p>Today '.$date.'</p>";
        $dateErrorMessage = 'Date is in the future!';
    }

    return $dateErrorMessage;
}

function validateDropdowns(string $value, string $errorMessage, string $message): string {
    $errorMessage = "";
        if($value == null || $value == "Select an option...") { // Check that make has a value
        $errorMessage = $message;
    }
    return $errorMessage;
}

function validateRadioButtons(string $value, string $errorMessage, string $message): string {
    $errorMessage = "";
    if($value == null) {
        $errorMessage = $message;
    }
    return $errorMessage;
}