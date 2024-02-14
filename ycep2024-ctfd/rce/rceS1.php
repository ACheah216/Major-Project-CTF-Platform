<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNS Lookup - Stage 1</title>
</head>
<body>
    <h1>DNS Lookup - Stage 1</h1>

    <form action="" method='POST' autocomplete="off" enctype="multipart/form-data">

        <label for="question">IP Address:</label><br>
        <input type="text" id="ip" name="ip" required><br><br>

        <input type="submit" name="submit" value="Submit">
    </form> 

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['ip'])) {
        $target = $_POST['ip'];
        $target = stripslashes( $target ); // Remove backslash as it may be used to escape special characters

        // Split the IP into 4 octects
        $octet = explode(".", $target);

        if (sizeof($octet) == 4) {
            // Check if each octet is an integer
            if ((is_numeric($octet[0])) && (is_numeric($octet[1])) && (is_numeric($octet[2])) && (is_numeric($octet[3]))) {
                // If all 4 octets are integers, piece the IP back together.
                $target = $octet[0].'.'.$octet[1].'.'.$octet[2].'.'.$octet[3];
                
                // Determine OS and execute the ping command.
                if (stristr(php_uname('s'), 'Windows NT')) { 

                    $cmd = shell_exec( 'ping  ' . $target );
                    echo '<pre style="color: red; font-weight: bold;">'.$cmd.'</pre>';
                    unset($target, $octet, $cmd);

                } else { 

                    $cmd = shell_exec( 'ping  -c 3 ' . $target );
                    echo '<pre style="color: red; font-weight: bold;">'.$cmd.'</pre>';
                    unset($target, $octet, $cmd);

                } 
            } else if (!is_numeric($octet[3])) {
                
                $disallowedChar = array(
                    ';',   // Command separator
                    '&',   // Command separator and background execution
                    '|',   // Pipe to another command
                    '<',   // Input redirection
                    '>',   // Output redirection
                    '`',   // Command substitution
                    '$',   // Variable expansion
                    '(',   // Command grouping
                    ')',   // Command grouping
                    '{',   // Command grouping
                    '}',   // Command grouping
                    '[',   // Command grouping
                    ']',   // Command grouping
                    '<',   // Input redirection
                    '>',   // Output redirection
                    '\'',  // Single quote
                    '"',   // Double quote
                    '*',   // Wildcard for filename expansion
                    '?',   // Wildcard for single character expansion
                    '!',   // History expansion (bash)
                    '\\',  // Escape character
                );
                
                $octetChars = str_split($octet[3]); // Convert the string to an array of characters for checking
                $blockedChar = false;
                
                foreach ($octetChars as $key => $char) {
                    // Check if the character is disallowed
                    if (in_array($char, $disallowedChar)) {
                        $blockedChar = true;
                        break;
                    }
                }
                
                if ($blockedChar) {
                    // User input has the blocked character
                    $flag = "YCEP2024-R3M0T3C0MM4ND3X3CUT10N(ST4G33N0)";
                    echo "<script>alert('Congratulations! This is your flag: $flag'); window.location.href = 'rceS1.php';</script>";
                    unset($target, $octet, $cmd);
                } else {
                    // User input does not have the blocked character, but may have others (; or & , etc)
                    unset($target, $octet, $cmd);
                    echo "<script>alert('Invalid IP Address format provided'); window.location.href = 'rceS1.php';</script>";
                }
            } else {
                unset($target, $octet, $cmd);
                echo "<script>alert('Invalid IP Address format provided'); window.location.href = 'rceS1.php';</script>";
            }
        } else {
            unset($target, $octet, $cmd);
            echo "<script>alert('Invalid IP Address format provided'); window.location.href = 'rceS1.php';</script>";
        }
        
    } else {
        // There is no ip
        echo "<script>alert('Please enter an IP Address and try again'); window.location.href = 'rceS1.php';</script>";
    }
}
?>

