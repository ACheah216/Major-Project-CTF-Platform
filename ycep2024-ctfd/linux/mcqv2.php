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
    <a href="mcqv2.php">MCQv2</a>
    <a href="leaderboard.php">Leaderboard</a>
    <a href="contact.php">Contact</a>
    </nav>

    <?php
        // Questions array
        $questions = array(
            "What is the command to check what user are you logged in as?",
            "How do you display the contents of a file in the terminal?",
            "In Linux, what does the command 'pwd' stand for?",
            "Which command is used to display the manual page for a specific command in Linux?",
            "Which command is used to remove a directory in Linux?",
            "What does the command 'mkdir' do in Linux?",
            "What command is used to search for a specific string within a file?",
            "What does the 'chmod' command do in Linux?",
            "In Linux, what does the 'cp' command do?",
            "In Linux, file and directory names are case-insensitive",
        );

        // Options array
        $options = array(
            array("check", "ip -a", "echo", "whoami"),
            array("open filename", "show filename", "cat filename", "display filename"),
            array("Print Working Directory", "Present White Directory", "Present Working Directory", "Print White Directory"),
            array("man", "info", "help", "docs"),
            array("delete", "remove", "del", "rmdir"),
            array("Move a file", "Merge directories", "Make a new directory", "Rename a file"),
            array("search", "grep", "find", "grab"),
            array("Change file ownership", "Change file permissions", "Create a new file", "Copy a file"),
            array("Concatenate files", "Crop file", "Change file", "Copy files or directories"),
            array("True", "False"),
        );

        // Correct answers array
        $correctAnswers = array(3, 2, 0, 0, 3, 2, 1, 1, 3, 1);
    
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
            echo '<p> <span style="color: #e74c3c;"> Congratulations! <br> By achieving at least 50%, you have earned the following flag: <br></p>';
            echo '<p>50% Checkpoint Flag: YCEP2024-15AZUMA-21072021</p>';
        }
        elseif ($percentage >= 75 && $percentage < 100)
        {
            echo '<p> <span style="color: #e74c3c;"> Congratulations! <br> By achieving at least 75%, you have earned the following flags: <br></p>';
            echo '<p>50% Checkpoint Flag: YCEP2024-15AZUMA-21072021</p>';
            echo '<p>75% Checkpoint Flag: YCEP2024-5UM3RU5AH1DA-24082022</p>';
        }
        elseif ($percentage == 100)
        {
            echo '<p> <span style="color: #e74c3c;"> Congratulations! <br> By achieving 100%, you have earned the following flags: <br></p>';
            echo '<p>50% Checkpoint Flag: YCEP2024-15AZUMA-21072021</p>';
            echo '<p>75% Checkpoint Flag: YCEP2024-5UM3RU5AH1DA-24082022</p>';
            echo '<p>100% Checkpoint Flag: YCEP2024-F0NTA153EG3R1A-16082023</p>';
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

