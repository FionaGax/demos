// Declare the variables
let userName;

// Declare the buttons, use const as they will not require changing
const startButton = document.querySelector("#submit");
const yesButton = document.querySelector("#confirm-yes");
const noButton = document.querySelector("#confirm-no");
const previousButton = document.querySelector("#prev");
const nextButton = document.querySelector("#next");
const playAgainButton = document.querySelector("#play-again");

// Create the array containing the questions - use const as they will not be altered.
const myQuestions = [
    {type: "text", // Q1
        question: "How many Harry Potter books are there?",
        correctAnswer: "seven"
    },
    {type: "text", // Q2
        question: "How many Harry Potter movies are there?",
        correctAnswer: "eight"
    },
    {type: "image", // Q3
        question: "Where is Hogwarts located?",
        answers: {
            a: "<img src = '../images/ireland.jpg' alt='Image of the Irish flag like a button.'>",
            b: "<img src = '../images/england.jpg' alt='Image of the English flag like a button.'>",
            c: "<img src = '../images/wales.jpg' alt='Image of the Welsh flag like a button.'>",
            d: "<img src = '../images/scotland.jpg' alt='Image of the Scotish flag like a button.'>"
        },
        correctAnswer: "d"
    },
    {type: "image", //Q4
        question: "Who created the chess obstacle in Harry Potter and the Philosopher's Stone?",
        answers: {
            a: "<img src = '../images/snape.jpg' alt='Image of Severus Snape.'>",
            b: "<img src = '../images/dumbledore.jpg' alt='Image of Albus Dumbledore.'>",
            c: "<img src = '../images/quirrell.jpg' alt='Image of Quirinus Quirrell.'>",
            d: "<img src = '../images/mcgonagall.jpg' alt='Image of Minerva McGonagall.'>",
        },
        correctAnswer: "d"
    },
    {type: "radio", // Q5
        question: "Where did Harry find the name for his owl Hedwig?",
        answers: {
            a: "The Tales of Beadle and the Bard",
            b: "Fantastic Beasts and Where to Find Them",
            c: "A History of Magic",
            d: "The Standard Book of Spells"
        },
        correctAnswer: "c",
    },
    {type: "radio", // Q6
        question: "What family did Harry free Dobby from in Harry Potter and the Chamber of Secrets?",
        answers: {
            a: "The Abbott's",
            b: "The Bone's",
            c: "The Malfoy's ",
            d: "The Weasley's"
        },
        correctAnswer: "c",
    },
    {type: "radio", // Q7
        question: "In Harry Potter and the Chamber of Secrets, which three Weasley's stole the car to rescue Harry from Privet Drive?",
        answers: {
            a: "Percy, Fred and George",
            b: "Bill, Charlie and Percy",
            c: "Ginny, Percy and Ron",
            d: "Fred, George and Ron"
        },
        correctAnswer: "d"
    },
    {type: "radio", // Q8
        question: "How do you get to Platform 9 3/4?",
        answers: {
            a: "Tapping the correct brick with your wand",
            b: "Through a phone booth by dialling 4-2-6-6-2 (M-A-G-I-C)",
            c: "Through a secret door in the train station",
            d: "Running through the wall between Platform 9 and Platform 10"
        },
        correctAnswer: "d"
    },
    {type: "radio", // Q9
        question: "Where is Wiseacre's Wizarding Equipment?",
        answers: {
            a: "Diagon Alley",
            b: "Knockturn Alley",
            c: "Hogsmead",
            d: "Godric's Hollow"
        },
        correctAnswer: "a"
    },
    {type: "radio", // Q10
        question: "What kind of shop is Slug and Jigger's?",
        answers: {
            a: "An apothecary",
            b: "A wand shop",
            c: "A clothes shop",
            d: "A bookshop"
        },
        correctAnswer: "a"
    },
    {type: "radio", // Q11
        question: "Where is Quality Quidditch Supplies?",
        answers: {
            a: "Diagon Alley",
            b: "Knockturn Alley",
            c: "Hogsmead",
            d: "Godric's Hollow"
        },
        correctAnswer: "a"
    },
    {type: "radio", // Q12
        question: "What potion did Professor Slughorn offer as a reward for the best brewed Draught of the Living Death in Harry Potter and the Half-Blood Prince?",
        answers: {
            a: "Amorentia",
            b: "Polyjuice Potion",
            c: "Felix Felicis",
            d: "Dittany"
        },
        correctAnswer: "c"
    },
    {type: "radio", // Q13
        question: "Who was the Defence Professor in Harry Potter and the Order of the Pheonix who created the Educaitonal Decrees?",
        answers: {
            a: "Professor Remus Lupin",
            b: "Professor Alestor 'Mad-Eye' Moody",
            c: "Professor Quirinis Quirrell",
            d: "Professor Delores Umbridge"
        },
        correctAnswer: "d"
    },
    {type: "radio", // Q14
        question: "In which book did Lucius Malfoy buy the entire Slytherin Quidditch team brand new Nimbus Two-Thousands so his son Draco would be made seeker?",
        answers: {
            a: "Harry Potter and the Prisoner of Azkaban",
            b: "Harry Potter and the Half-Blood Prince",
            c: "Harry Potter and the Deathly Hallows",
            d: "Harry Potter and the Chamber of Secrets"
        },
        correctAnswer: "d"
    },
    {type: "radio", // Q15
        question: "What did Hermione use to go to all her classes in Harry Potter and the Prisoner of Azkaban?",
        answers: {
            a: "A time-turner",
            b: "A potion",
            c: "A spell",
            d: "A magical device"
        },
        correctAnswer: "a"
    },
    {type: "radio", // Q16
        question: "What book did Harry, Hermione and Ron escape Gringotts on the back of a dragon?",
        answers: {
            a: "Harry Potter and the Philosopher's Stone",
            b: "Harry Potter and the Goblet of Fire",
            c: "Harry Potter and the Order of the Pheonix",
            d: "None of the above"
        },
        correctAnswer: "d"
    },
    {type: "radio", // Q17
        question: "Which two Weasley's opened 'Weasley's Wizard Wheezes' joke shop in Diagon Alley?",
        answers: {
            a: "Bill and Charlie",
            b: "Fred and George",
            c: "Ron and Ginny",
            d: "Percy and Charlie"
        },
        correctAnswer: "b"
    }
];

// Declare the array to hold the five random numbers (unique) and the array for the five questions in the quiz
let randomNumbers = new Array(5);
let quizQuestions = new Array(5);

// Decalre the variable to hold the current, previous and next questions
let currentQuestion;
let prevQuestion;
let nextQuestion;

// Create the variables that will control the divs
let nameBox = document.querySelector("#name-box");
let confirmBox = document.querySelector("#confirm");
let correctAnswers = document.querySelector("#correct-answers");
let questionBox = document.querySelector('#question-box');

// Create the variables that will print the total results and correct answers to the screen
let printTotal = document.getElementById("print-total");
let printCorrect = document.getElementById("correct-answers");
let incorrectAnswers = false;

// Create the variables to hold the details for the questions div
let questionDiv = document.querySelector(".question-box");
let questionNumber = document.querySelector("#question-number");
let questionText = document.querySelector("#question");
let questionAnswers = document.querySelector("#question-answers");


let questions = []; // An array to hold the five questions

let fiveRandomNumbers = new Array(5);
let counter = 0;
let userAnswer;
let percentCorrect = 0;
let score = 0;

// Declare the functions
// Function to generate five random questions from the question array
function generateRandomNumbers(){
    for (let i = 0; i < randomNumbers.length; i++) {
        // Generate a number between 0 and the length of the question array
        let num = Math.floor(Math.random() * myQuestions.length + 1);
        // Check to see if the number is already in the randomNumbers array
        // If it is then pick another random number
        while (randomNumbers.includes(num)) {
            num = Math.floor(Math.random() * myQuestions.length + 1);
        }
        // If it isn't then add it
        randomNumbers[i] = num;
    }

    // Testing - print the numbers to the console
    console.log(randomNumbers);
}

// Add the five random questions to the quiz array
function addQuestionsToArray(){
    for (let i = 0; i < quizQuestions.length; i++) {
        quizQuestions[i] = myQuestions[randomNumbers[i] - 1];
    }

    // Testing
    console.log(quizQuestions);
}

// Validate the user name
function validateName(){
    userName = document.getElementById('user-name').value;
    // Ensure the name is longer than 0 characters
    if (userName.length < 1) {
        alert("Please enter your name here!");
        console.log(userName);
    } else {
        // If it isn't then hide the first div box
        nameBox.classList.add('hide');
        confirmName();
    }
}

// Ask the user to confirm their name is correct
function confirmName(){
    // Display the confirm name div
    confirmBox.classList.remove('hide');
    // Print the name the user gave to the h2
    document.getElementById('confirm-name').innerText = "Your name is " + userName;
}

// Function for the yes button
function hitYes() {
    // User said name is correct so hide the confirmBox and start the quiz
    confirmBox.classList.add('hide');
    questionBox.classList.remove('hide');
}

// Function for the no button
function hitNo(){
    // User said that this is not their name
    confirmBox.classList.add('hide');
    nameBox.classList.remove('hide');
}

// Display the questions
function showQuestion(){

}


// Play the game
generateRandomNumbers();
addQuestionsToArray();
startButton.addEventListener('click', validateName);
yesButton.addEventListener('click', hitYes);
noButton.addEventListener('click', hitNo);

