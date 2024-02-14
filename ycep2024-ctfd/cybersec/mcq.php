<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Knowledge and Awareness MCQ Quiz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .quiz-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .question-options-container {
            margin-bottom: 20px;
            border: 2px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        .question {
            margin-bottom: 10px;
            font-weight: bold;
        }


        .options {
            padding-top: 0px;
        }

        .result {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .required-message {
            color: red;
            font-style: italic;
            margin-bottom: 5px;
        }

        .score-box {
            border: 2px solid;
            padding: 10px;
            margin-top: 20px;
            display: inline-block;
            transition: border 0.5s ease-in-out;
            animation: moveBorderClockwise 2s infinite;
        }

        .green-border {
            border-color: green;
        }

        .red-border {
            border-color: red;
        }

        @keyframes moveBorderClockwise {
            0%, 100% {
                transform: rotate(5deg);
            }
            50% {
                transform: rotate(-5deg);
            }
        }

        @keyframes moveBorderAntiClockwise {
            0%, 100% {
                transform: rotate(-5deg);
            }
            50% {
                transform: rotate(5deg);
            }
        }
    </style>
</head>
<body>
<div class="quiz-container">
    <h1>Cybersecurity Knowledge and Awareness MCQ Quiz</h1>

<?php
function shuffleQs() {
    session_start();

    // Quiz array
    $quizArray = array(
        array("What is a common red flag of a phishing email?", "Well-written and professional language", "Urgent requests for personal information", "Emails from known contacts", "Short and simple messages", "Urgent requests for personal information"), 
        array("What can you do to avoid falling victim to phishing?", "Click on any link received in emails to verify authenticity", "Ignore suspicious emails and delete them", "Share personal information if the email looks trustworthy", "Use the same password across multiple accounts", "Ignore suspicious emails and delete them"),
        array("What is the purpose of Wi-Fi encryption?", "To make Wi-Fi connections faster", "To ensure a stable Wi-Fi connection", "To secure and protect data transmitted over Wi-Fi", "To limit the number of devices connected to Wi-Fi", "To secure and protect data transmitted over Wi-Fi"),
        array("Why should you avoid online banking or shopping when connected to public Wi-Fi?", "Public Wi-Fi is faster for online transactions", "It is always safe to use public Wi-Fi for financial transactions", "Public Wi-Fi may lack security, exposing your sensitive information", "Public Wi-Fi provides extra protection for online activities", "Public Wi-Fi may lack security, exposing your sensitive information"),
        array("Why is using the same password across multiple accounts a security risk?", "It makes it easier to remember passwords", "It ensures consistent access to all accounts", "It is a common security best practice", "If one account is compromised, all others are at risk", "If one account is compromised, all others are at risk"),
        array("What is two-factor authentication (2FA)?", "Using two different passwords", "A security feature that requires additional verification beyond a password", "Having two separate user accounts", "Using the same password for different accounts", "A security feature that requires additional verification beyond a password"),
        array("How can you avoid falling victim to social engineering attacks?", "Verify requests for sensitive information through trusted channels", "Share personal information freely", "Trust everyone you meet online", "Ignore any communication that asks for information", "Verify requests for sensitive information through trusted channels"),
        array("What is the role of awareness in the prevention of social engineering attacks?", "Recognizing potential manipulation and staying vigilant", "Being oblivious to online interactions", "Avoiding all social interactions", "Trusting everyone without questioning their motives", "Recognizing potential manipulation and staying vigilant"),
        array("How does encryption contribute to data security during transmission?", "It slows down data transmission", "It makes data more vulnerable", "It protects data from unauthorized access during transmission", "Encryption has no impact on data security", "It protects data from unauthorized access during transmission"),
        array("Which of the following are considered best practices for data backup and encryption?", "Storing backups in a single location for easy access.", "Using free but untrusted and unfamiliar backup and encryption software.", "Employing full disk encryption to encrypt the entire storage device.", "Avoiding cloud-backup services to ensure maximum security.", "Employing full disk encryption to encrypt the entire storage device."),
        array("Why is it important to set a secure device password or PIN?", "To prevent unauthorized access and protect personal information", "It's not necessary as devices are secure by default", "To make it easier for friends to access your device", "To remember the password easily", "To prevent unauthorized access and protect personal information"),
        array("Which principle of the CIA triad ensures that information is not accessed by unauthorized individuals?", "Integrity", "Confidentiality", "Accountability", "Availibility", "Confidentiality"),
        array("How does the principle of Integrity relate to information security?", "It ensures data is available when needed", "It prevents unauthorized access to information", "It ensures data is accurate and unaltered", "It focuses on keeping data private", "It ensures data is accurate and unaltered"),
        array("What does the Availability principle of the CIA triad emphasize?", "Keeping data private", "Ensuring data is accurate and unaltered", "Making data accessible when needed", "Protecting against unauthorized access", "Making data accessible when needed"),
        array("What is the first octet range of a Class B IP address?", "128 - 190", "127 - 190", "128 - 191", "127 - 191", "128 - 191"),
        array("Why is HTTPS important for secure online activities?", "It makes websites load faster", "It ensures a more colorful website design", "HTTPS is only necessary for business websites", "It encrypts data, protecting it from interception during transmission", "It encrypts data, protecting it from interception during transmission")
    );
    
    shuffle($quizArray);
    $questions = array();
    $options = array();
    $correctAns = array();

    foreach ($quizArray as $questionData) {
        // Extract question (index 0)
        $questions[] = $questionData[0];
    
        // Extract options (index 1-4) and shuffle them
        $shuffledOptions = array_slice($questionData, 1, 4);
        shuffle($shuffledOptions);
        $options[] = $shuffledOptions;
    
        // Extract correct answer (index 5)
        $correctAns[] = $questionData[5];
    }

    $_SESSION['questions'] = $questions;
    $_SESSION['options'] = $options;
    $_SESSION['correctAns'] = $correctAns;

    echo '<form method="post" action="" onsubmit="return validateForm()">';

    // Display questions and options
    for ($i = 0; $i < count($questions); $i++) {
        $q = $i + 1;
        echo "<div class='question-options-container'>";
        echo "<div class='question'>Question $q: $questions[$i]</div>";
        echo "<div class='options'>";
        foreach ($options[$i] as $key => $option) {
            echo "<label><input type='radio' name='q$i' value='$option' required>$option</label><br>";
        }
        echo "<div class='required-message' id='required_message_$i'></div>";
        echo "</div> </div>";
    }
    echo '<input type="submit" name="formButton" value="Submit">';
    echo '</form>';
    
    unset($questions, $options, $correctAns);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formButton"])) {
    session_start();
    if (!isset($_SESSION['questions']) || !isset($_SESSION['options']) || !isset($_SESSION['correctAns'])) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } 
    $questions = $_SESSION['questions'];
    $options = $_SESSION['options'];
    $correctAns = $_SESSION['correctAns'];
    // Initialize a variable to count correct answers
    $score = 0;
    
    // Loop through each question
    for ($i = 0; $i < count($questions); $i++) {
        // Get the user's selected answer from the submitted form
        $userAnswer = $_POST["q" . $i];
        // Check if the user's answer matches the correct answer
        if ($userAnswer == $correctAns[$i]) {
            $score++;
        }
    }
    
    // Determine the border color based on the score. Green for pass, Red for fail
    $borderColorClass = ($score / count($questions) >= 0.5) ? 'green-border' : 'red-border';

    // Display the score in a box with moving border animation
    echo "<div class='score-box $borderColorClass'>";
    echo "<div class='result'>Your score: $score out of " . count($questions) . "</div>";
    $percentage = round(($score / count($questions)) * 100, 2);
    echo "<div class='result'>Percentage: " . $percentage . "%</div>";
    echo "</div>";

    // Define the flags
    $flag50 = "YCEP2024-7YB3R33C(50KAA50)";
    $flag75 = "YCEP2024-7YB3R33C(75AAK57)";
    $flag100 = "YCEP2024-7YB3R33C(010AKA100)";

    if ($percentage == 100) {
        $flagsToShow = "$flag50, $flag75, $flag100";
        // Display the flags
        echo "<div class='result'>
        <h3>Congratulations!</h3>
        With your score of $percentage%, you have obtained the following flags for your CTF challenge! <br><br>
        50% Checkpoint flag: $flag50 <br>
        75% Checkpoint flag: $flag75 <br>
        100% Checkpoint flag: $flag100 <br>
        </div>";

    } elseif ($percentage >= 75) {
        // Display the flags
        echo "<div class='result'>
        <h3>Congratulations!</h3>
        With your score of $percentage%, you have obtained the following flags for your CTF challenge! <br><br>
        50% Checkpoint flag: $flag50 <br>
        75% Checkpoint flag: $flag75 <br>
        100% Checkpoint flag: Obtain 100% to unlock this flag. Try again! <br>
        </div>";

    } elseif ($percentage >= 50) {
        // Display the flags
        echo "<div class='result'>
        <h3>Congratulations!</h3>
        With your score of $percentage%, you have obtained the following flags for your CTF challenge! <br><br>
        50% Checkpoint flag: $flag50 <br>
        75% Checkpoint flag: Obtain 75% to unlock this flag. Try again! <br>
        100% Checkpoint flag: Obtain 100% to unlock this flag. Try again! <br>
        </div>";
    } else {
        // Try again message
        echo "<div class='result'>
        <h3>Try again!</h3>
        With your score of $percentage%, you did not obtain any flags for your CTF challenge. 
        You need to score at least 50% to obtain a flag for this challenge. <br><br>
        50% Checkpoint flag: Obtain 50% to unlock this flag. Try again! <br>
        75% Checkpoint flag: Obtain 75% to unlock this flag. Try again! <br>
        100% Checkpoint flag: Obtain 100% to unlock this flag. Try again! <br>
        </div>";
    }
    unset($questions, $options, $correctAns);
    session_unset();
    session_destroy();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["myButton"])) {
    // Call the shuffleQs function to shuffle and display qs
    shuffleQs();
}

if (session_status() == PHP_SESSION_NONE) {
    // Display the form only if the necessary session variables are not set
    echo '<div class="question-options-container">
        <form method="post" action="">
        <h3>Take the quiz here!</h3>
        <ul>
        <li>Obtain 50% to get 1 flag</li>
        <li>Obtain 75% to get 2 flags</li>
        <li>Obtain 100% to get all 3 flags!</li>
        </ul> <br>
        <input type="hidden" name="myButton" value="clicked required">
        <button type="submit">Attempt quiz</button>
    </form>';
} 
?>

</div>
</body>
</html>

