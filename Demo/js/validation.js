// Get all the elements for the form that have to be validated
const form = document.getElementById('addCar');
const vinElement = document.getElementById('vin');
const yearManufactureElement = document.getElementById('yearManufacture');
const seatsElement = document.getElementById('seats');
const doorsElement = document.getElementById('doors');
const colourElement = document.getElementById('colour');
const regElement = document.getElementById('reg');
const dateElement = document.getElementById('date');
const makeElement = document.getElementById('make');
const modelElement = document.getElementById('model');
const engineElement = document.getElementById('engine');
const signUpButton = document.getElementById('signUpButton');

// Declare the booleans for the validations
// Set all validation booleans to false as when the form is opened they are not true
let vinIsValid = false;
let yearManufactureIsValid = false;
let engineIsValid = false;
let seatsIsValid = false;
let doorsIsValid = false;
let colourIsValid = false;
let regIsValid = false;
let dateIsValid = false;
let makeIsValid = false;
let modelIsValid = false;
let transmissionIsValid = false;
let fuelIsValid = false;

// Validation functions
function validateVin(){
    const vin = vinElement.value.trim();
    const length = 17;

    // If there is no input show an error message
    if(!isRequired(vin)) {
        vinIsValid = false;
    } else if(isNaN(vin.charAt(0))) {
        // If the vin doesn't start with a number show an error message
        vinIsValid = false;
        showErrorMessage(vinElement, "The first character must be a number!");
    } else if (!/[a-z]/.test(vin)) {
        // If there is no lowercase letter show an error message
        vinIsValid = false;
        showErrorMessage(vinElement, "There must be at least one lowercase letter!");
    } else if (!/[A-Z]/.test(vin)) {
        // If there is no uppercase letter show an error message
        vinIsValid = false;
        showErrorMessage(vinElement, "There must be at least one uppercase letter!");
    } else if (vin.toLowerCase().includes('i')) {
        // If there is an i show an error message
        console.log("vin has an i");
        showErrorMessage(vinElement, "The VIN cannot contain an 'i'!");
    } else if (vin.toLowerCase().includes('o')) {
        // If there is a o show an error message
        vinIsValid = false;
        showErrorMessage(vinElement, "The VIN cannot contain an 'o'!");
    } else if (vin.toLowerCase().includes('q')) {
        // If there is a q show an error message
        vinIsValid = false;
        showErrorMessage(vinElement, "The VIN cannot contain a 'q'!");
    } else if(vin.length < length) {
        vinIsValid = false;
        console.log("Vin length: " + vin.length);
        showErrorMessage(vinElement, "The VIN must not be shorter than 17 characters!");
    } else if (vin.length > length) {
        // If the vin is shorter or longer than 17 characters show an error message
        vinIsValid = false;
        console.log("Vin length: " + vin.length);
        showErrorMessage(vinElement, "The VIN must not be longer than 17 characters long!");
    } else {
        vinIsValid = true;
        showSuccessMessage(vinElement);
    }
    return vinIsValid;
}

function validateYearManufacture(){
    const year = yearManufactureElement.value.trim();
    const currentYear = new Date().getFullYear();

    if(year < 2013) {
        // If the year is before 2013 show an error message
        yearManufactureIsValid = false;
        showErrorMessage(yearManufactureElement, "The year cannot be before 2013!");
    } else if (year > currentYear) {
        // If the year is a future year show an error message
        yearManufactureIsValid = false;
        showErrorMessage(yearManufactureElement, "The year cannot be after the current year! It's only " + currentYear);
    } else {
        yearManufactureIsValid = true;
        showSuccessMessage(yearManufactureElement);
    }

    return yearManufactureIsValid;
}

function validateSeats(){
    const seats = seatsElement.value.trim();
    const min = 2;
    const max = 9;

    if (seats < min) {
        // If the number is less than two show an error
        seatsIsValid = false;
        showErrorMessage(seatsElement, "The minimum amount of seats allowed is 2!");
    } else if (seats > max) {
        // If the number is greater than nine show an error message
        seatsIsValid = false;
        showErrorMessage(seatsElement, "The maximum amount of seats allowed is 9!");
    } else {
        seatsIsValid = true;
        showSuccessMessage(seatsElement);
    }
    return seatsIsValid;
}

function validateDoors(){
    const doors = doorsElement.value.trim();
    const min = 3;
    const max = 5;
    if (doors < min) {
        // If the number is less than three show an error message
        doorsIsValid = false;
        showErrorMessage(doorsElement, "The minimum amount of doors allowed is 3!");
    } else if (doors > max) {
        // If the number is greater than five show an error message
        doorsIsValid = false;
        showErrorMessage(doorsElement, "The maximum amount of doors allowed is 5!");
    } else {
        doorsIsValid = true;
        showSuccessMessage(doorsElement);
    }

    return doors;
}

function validateColour(){
    const colour = colourElement.value.trim();
    const min = 3;
    let hasNumber = true;

    for (let i = 0; i < colour.length; i++) {
        if (isNaN(colour.charAt(i))) {
            hasNumber = false;
        }
    }
    if (hasNumber) {
        // If the input value is less than three show an error message
        colourIsValid = false;
        showErrorMessage(colourElement, "A colour cannot contain a number!");
    }   else if (colour.length < min) {
        // If there are numbers in the input show an error message
        colourIsValid = false;
        showErrorMessage(colourElement, "There must be at least three letters in the colour!");
    } else {
        colourIsValid = true;
        showSuccessMessage(colourElement);
    }
    return colourIsValid;
}

function validateReg(){
    const reg = regElement.value.trim();
    // String must be split into three parts and each part must be validated seperately
    // First three characters of the string will be the year
    if (reg.length < 5) {
        regIsValid = false;
        showErrorMessage(regElement, "The registration must be a minimum of five characters long!");
    } else {
        removeErrorMessage(regElement);
        let year = reg.substring(0, 3);
        // The county can be either one or two characters
        let county;
        let number;

        if (isNaN(reg.charAt(4))) {
            // If the character at index 4 is not a number then it is a letter so it is part of the county
            county = reg.substring(3, 5);
            // The number of the reg then begins at index 5
            number = reg.substring(5, reg.length);
        } else {
            // If the character at index 4 is a number then only the character at index 3 is part of the county
            county = reg.charAt(3);
            // The number of the reg then begins at index 4
            number = reg.substring(4, reg.length);
        }

        // Validate the year
        let yearIsValid = validateYear(year);
        let countyIsValid = validateCounty(county);
        let numberIsValid = validateNumber(number);
        // Validate the county
        // Validate the number
        console.log('Year: ' + year);
        console.log('County: ' + county);
        console.log('Number: ' + number);
        // Minimum year is 131

        // If the first three characters are not numbers (131) show an error
        // If the first three characters are less than 131 show an error
        // If the third character is not equal to 1 or not equal to 2 show an error

        // If the county part (make a substring - max is 2 characters) is not equal to an element in the array then show an error
        // If the last part of the string is not a number then show an error
        // If the last part of the string is less than 1 show an error

        if (yearIsValid === true && countyIsValid === true && numberIsValid === true) {
            showSuccessMessage(regElement);
            regIsValid = true;
        }
    }

}

function validateYear(year){
    let isNumber = true;
    let isValid;

    for(let i = 0; i < year.length; i++) {
        if(isNaN(year.charAt(i))) {
            isNumber = false;
        }
    }

    if (isNumber === false) {
        isValid = false;
        showErrorMessage(regElement, "The first three characters must be the year. Eg. 131 or 132, no letters!");
    } else if (year.charAt(0) < 1)  {
        isValid = false;
        showErrorMessage(regElement, "The earliest registration is 2013. The first digit cannot be 0!");
    } else if (year.charAt(0) === '1' && year.charAt(1) <= 2) {
        isValid = false;
        showErrorMessage(regElement, "The earliest registration is 2013!");
    } else if (year.charAt(2) !== '1' && year.charAt(2) !== '2') {
        isValid = false;
        showErrorMessage(regElement, "The last digit must be either 1 or 2!");
    } else {
        isValid = true;
        removeErrorMessage(regElement);

    }
    return isValid;
}

function validateCounty(county){
    let isValid = false;

    if(county.length === 1) {
        if(!/[cdglw]/.test(county.toLowerCase())) {
            isValid = false;
            showErrorMessage(regElement, county + " is not a valid county representation!");
        } else {
            isValid = true;
        }
    } else if (county.length === 2) {
        let validCounty = false;
        console.log("County length is 2!");
        switch (county.toLowerCase()) {
            case 'ce':
                validCounty = true;
                break;
            case 'cn':
                validCounty = true;
                break;
            case 'cw':
                validCounty = true;
                break;
            case 'dl':
                validCounty = true;
                break;
            case 'ke':
                validCounty = true;
                break;
            case 'kk':
                validCounty = true;
                break;
            case 'ky':
                validCounty = true;
                break;
            case 'ld':
                validCounty = true;
                break;
            case 'lh':
                validCounty = true;
                break;
            case 'lk':
                validCounty = true;
                break;
            case 'lm':
                validCounty = true;
                break;
            case 'ls':
                validCounty = true;
                break;
            case 'mh':
                validCounty = true;
                break;
            case 'mn':
                validCounty = true;
                break;
            case 'mo':
                validCounty = true;
                break;
            case 'oy':
                validCounty = true;
                break;
            case 'so':
                validCounty = true;
                break;
            case 'rn':
                validCounty = true;
                break;
            case 'tn':
                validCounty = true;
                break;
            case 'ts':
                validCounty = true;
                break;
            case 'wd':
                validCounty = true;
                break;
            case 'wh':
                validCounty = true;
                break;
            case 'wx':
                validCounty = true;
                break;
            case 'ww':
                validCounty = true;
                break;
            default:
                validCounty = false;
        }

        if (validCounty === false) {
            isValid = false;
            showErrorMessage(regElement, "The county is not valid!");
        } else {
            isValid = true;
        }
    }

    return isValid;
}

function validateNumber(number){
    let isValid;
    let allNum = true;
    // All characters of the number must be a number
    for (let i = 0; i < number.length; i++) {
        if(isNaN(number.charAt(i))) {
            isValid = false;
            showErrorMessage(regElement, "The final part of the reg must be purely numeric!");
        }
    }

    // Ensure the number is not less then 0
    if (number < 1) {
        isValid = false;
        showErrorMessage(regElement, "The final part of the reg cannot be less then 1!");
    } else {
        isValid = true;
    }

    return isValid;
}

function validateDate(){
    const date = dateElement.value.trim();
    let inputDate = new Date(date);
    let today = new Date();
    today.setHours(23, 59, 59, 998);

    removeErrorMessage(dateElement);
    if(inputDate > today) {
        dateIsValid = false;
        showErrorMessage(dateElement, "The date cannot be in the future!");
    } else {
        dateIsValid = true;
        showSuccessMessage(dateElement);
    }
}

function validateMake(){
    const make = makeElement.value;
    if(make === "") {
        showErrorMessage(makeElement, "Please choose a make!");
        console.log('make: ' + make);
        makeIsValid = false;
    } else {
        makeIsValid = true;
        showSuccessMessage(makeElement);
    }
}

function validateModel() {
    const model = modelElement.value.toLowerCase();
    if (model === "") {
        showErrorMessage(makeElement, "Please choose a model!");
        modelIsValid = false;
    } else {
        modelIsValid = true;
        showSuccessMessage(makeElement);
    }
}

function validateEngine(){
    const engine = engineElement.value;
    if (engine === "") {
        showErrorMessage(engineElement, "Please choose an engine size!");
        engineIsValid = false;
    } else {
        engineIsValid = true;
        showSuccessMessage(engineElement);
    }
}

function validateTransmission(){
    let radio = document.getElementsByName('transmission');
    for(let i = 0; i < radio.length; i++) {
        if (radio[i].checked) {
            transmissionIsValid = true;
        }
    }

}

function validateFuel(){
    let radio = document.getElementsByName('fuel');

    for(let i = 0; i < radio.length; i++) {
        if(radio[i].checked) {
            fuelIsValid = true;
        }
    }
}

// Check if input is required
function isRequired(value) {
    return value !== ""; // if the value is empty then it will return false
}

function showErrorMessage(element, errorMessage){
    // Select the correct element that has the error with validation
    const formField = element.parentElement;
    console.log('Element targeted: ' + element + " Parent Element: " + formField);

    // Add the error class to the element and remove the success class
    formField.classList.remove('success');
    formField.classList.add('error');

    // Show the error message
    // Target the small element that is under the input field in the HTML
    // Using querySelector lets this be a versatile function and will work for any error
    const error = formField.querySelector('small');
    error.textContent = errorMessage;
}

function removeErrorMessage(element) {
    // Select the correct element
    const formField = element.parentElement;

    // Remove the error class
    formField.classList.remove('error');
    const error = formField.querySelector('small');
    error.textContent = "";
}

function showSuccessMessage(element) {
    // Select the correct element
    const formField = element.parentElement;

    // Add success class and remove the error class
    formField.classList.remove('error');
    formField.classList.add('success');

    // Remove the error message
    const error = formField.querySelector('small');
    error.textContent = "";
}

function validate() {
    if (vinIsValid === true &&
            yearManufactureIsValid === true &&
            engineIsValid === true &&
            seatsIsValid === true &&
            doorsIsValid === true &&
            colourIsValid === true &&
            regIsValid === true &&
            dateIsValid === true &&
            makeIsValid === true &&
            modelIsValid === true &&
            transmissionIsValid === true &&
            fuelIsValid === true) {
        signUpButton.classList.remove('hide');
    }

    console.log('Vin: ' + vinIsValid);
    console.log('Engine: ' + engineIsValid);
    console.log('Seats: ' + seatsIsValid);
    console.log('Doors: ' + doorsIsValid);
    console.log('Colour: ' + colourIsValid);
    console.log('Reg: ' + regIsValid);
    console.log('Date: ' + dateIsValid);
    console.log('Make: ' + makeIsValid);
    console.log('Model: ' + modelIsValid);
    console.log('Transmission: ' + transmissionIsValid);
    console.log('Fuel: ' + fuelIsValid);
    console.log('Year Manufacture: ' + yearManufactureIsValid);
}
// Create the delay timer function for the input
const debounce = (fn, delay = 500) => {
    let timeoutId;
    return (...args) => {
        // cancel the previous timer
        if (timeoutId) {
            clearTimeout(timeoutId);
        }
        // setup a new timer
        timeoutId = setTimeout(() => {
            fn.apply(null, args)
        }, delay);
    };
};

// Create the function to check for validations after input is added
form.addEventListener('input', debounce(function(e) {
    // The event listener is added to every element in the form
    // Create a switch statement to decide what to do depending on which element has been altered
    switch (e.target.id) {
        case 'make':
            validateMake();
            break;
        case 'model':
            validateModel();
            break;
        case 'vin':
            validateVin();
            break;
        case 'yearManufacture':
            validateYearManufacture();
            break;
        case 'engine':
            validateEngine();
            break;
        case 'manual':
            validateTransmission();
            break;
        case 'automatic':
            validateTransmission();
            break;
        case 'petrol':
            validateFuel();
            break;
        case 'diesel':
            validateFuel();
            break;
        case 'seats':
            validateSeats();
            break;
        case 'doors':
            validateDoors();
            break;
        case 'colour':
            validateColour();
            break;
        case 'reg':
            validateReg();
            break;
        case 'date':
            validateDate();
            break;
    }

}));




