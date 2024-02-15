<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YCEP MCQ Questions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>MCQ Questions Page</h1>
    </header>

    <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="mcq.php">MCQ</a>
    <a href="leaderboard.php">Leaderboard</a>
    <a href="contact.php">Contact</a>
    </nav>

    <?php
        // Questions array
        $questions = array(
            "What does HTML stand for?",
            "Which HTML tag is used for creating a paragraph?",
            "Which HTML tag is used for creating a hyperlink?",
            "What type of CSS requires the use of a separate file?",
            "Which property is used to change the text color?",
            "Which HTML tag is used to change my font to italic?",
            "CSS Comments can be used to add notes or explanations within the stylesheet.",
            "Which symbol(s) indicate the beginning and end of a CSS comment?",
            "Can CSS comments be viewed in the browser when rendering a web page?",
            "Which purpose(s) do CSS comments serve?",
            "Arithmetic operations are supported in JavaScript.",
            "Which data type allows you to store multiple values in a single variable?",
            "What is the correct way to declare a variable in JavaScript?",
            "What is the correct way to declare a string variable named 'myString' in JavaScript?",
            "What is the correct way to declare an empty array in JavaScript?",
            "Which purpose(s) do Functions in JavaScript serve?",
        );

        // Options array
        $options = array(
            array("High Technical Markup Language", "HyperText Markup Language", "Home Tool Markup Language", "Hyperlinks and Text Markup Language"),
            array("a", "h1", "u", "p"),
            array("a", "h1", "img", "form"),
            array("Internal", "Inline", "Hybrid", "External"),
            array("background-color", "text-style", "color", "word-color"),
            array("font-style", "font-weight", "text-style", "word-style"),
            array("True", "False"),
            array("'//'", "'/* */'", "'//* *//'", "'*/* */*'"),
            array("Yes, they are visible as part of the web page content", "Comments are partially visible but in a different color", "No, comments are ignored and not displayed", "Depends on the browser settings"),
            array("Better organization", "Better readability", "Document and explain code for future reference", "All of the above"),
            array("True", "False"),
            array("Numbers", "Strings", "Functions", "Arrays"),
            array("myVar == 10;", "variable myVar = 10;", "let myVar = 10;", "int myVar = 10;"),
            array("string myString = 'Hello';", "str myString = 'Hello';", "myString = 'Hello';", "let myString = 'Hello';"),
            array("var myArray = [];", "myArray == [];", "array myArray = ();", "let myArray = {};"),
            array("Break down blocks of code into smaller, manageable parts", "Can reuse code multiple times", "Improve code organization", "All of the above"),
        );

        // Correct answers array
        $correctAnswers = array(1, 3, 0, 3, 2, 0, 0, 1, 2, 3, 0, 3, 2, 3, 0, 3);
    
        // Checks if form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $score = 0;
            $userAnswers = array();
        
        // Once submitted, get user answers from the form and store in array
        for ($i = 0; $i < count($questions); $i++) {
            $userAnswers[$i] = isset($_POST["q" . ($i + 1)]) ? $_POST["q" . ($i + 1)] : null;
        }

        // Checks user answers against correct answers, plus score if correct
        for ($i = 0; $i < count($questions); $i++) {
            if ($userAnswers[$i] == $correctAnswers[$i]) {
                $score++;
            }
        }
        
        // Calculate percentage of user score
        $totalQuestions = count($questions);
        $percentage = ($score / $totalQuestions) * 100;

        // Display the user's score and display percentage
        echo '<div class="result-container">';
        echo '<p>Your score: <span style="color: #e74c3c;">' . $score . '</span> out of ' . count($questions) . '</p>';
        echo '<p>Percentage: <span style="color: #e74c3c;">' . $percentage . '%</span></p>';
        echo '</div>';

        // Generate flags based on percentage
        echo '<div class="flag-container">';
        if ($percentage <= 49)
        {
            echo '<p> <span style="color: #e74c3c;"> You didn\'t earn any flags. Try again.</p>';
        }
        elseif ($percentage >= 50 && $percentage < 75)
        {
            echo '<p> <span style="color: #e74c3c;"> Congratulations! <br> By achieving at least 50%, you have earned the following flag: YCEP2024-M05DV35T1-28072020</p>';
        }
        elseif ($percentage >= 75 && $percentage < 100)
        {
            echo '<p> <span style="color: #e74c3c;"> Congratulations! <br> By achieving at least 75%, you have earned the following flags: <br></p>';
            echo '<p>YCEP2024-M05DV35T1-28072020</p>';
            echo '<p>YCEP2024-1IYU3R3X1AP15-10082020</p>';
        }
        elseif ($percentage == 100)
        {
            echo '<p> <span style="color: #e74c3c;"> Congratulations! <br> By achieving 100%, you have earned the following flags: <br></p>';
            echo '<p>YCEP2024-M05DV35T1-28072020</p>';
            echo '<p>YCEP2024-1IYU3R3X1AP15-10082020</p>';
            echo '<p>YCEP2024-WA1C6R5H0MA-02032021</p>';
        }
        echo '</div>';
}
    // Loop through questions and options

?>
<div class="submit-button-container">
    <form method="post" action="">
        <?php for ($i = 0; $i < count($questions); $i++) {
        echo '<div class="question-container">';
        echo '<div class="question">';
        echo '<p>' . ($i + 1) . '. ' . $questions[$i] . '</p>';
        echo '</div>';
        echo '<div class="options">';
        
        // Loop through options for each question
        foreach ($options[$i] as $key => $option) {
            echo '<div class="option">';
            echo '<input type="radio" name="q' . ($i + 1) . '" value="' . $key . '" required>';
            echo '<label for="">' . $option . '</label>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    }
        ?>
        <button class="submit-button" type="submit">Submit Answers</button>
    </form>
</div>

