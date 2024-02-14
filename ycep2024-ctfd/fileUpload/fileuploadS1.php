<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask a Question - Stage 1</title>
</head>
<body>
    <h1>Ask a Question - Stage 1</h1>

    <form action="" method='POST' autocomplete="off" enctype="multipart/form-data">

        <label for="question">Ask a Question:</label><br>
        <textarea name="question" id="question" rows="4" cols="50" required></textarea><br><br>

        <label for="image">Image</label><br>
        <input type="file" id="image" name="image"><br><br>

        <input type="submit" name="submit" value="Submit">
    </form> 

</body>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['question'])) {
        $question = $_POST['question'];

        // Check if a file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            // There is an image
            $uploadedFile = $_FILES['image']; // Store information related to the uploaded file
            $uploadedFileName = $uploadedFile['name']; // Store original name of the uploaded file
            $uploadedFileTmp = $uploadedFile['tmp_name']; // Temp filename on server
            $uploadedFileSize = $uploadedFile['size']; // File size
            $filenameParts = explode('.', $uploadedFileName);

            // Check if the file extension is disallowed (Cheks only the last ext)
            //$uploadedExt = strtolower(substr($uploadedFileName, strrpos($uploadedFileName, '.') + 1));

            $disallowedExtensions = array(
                "php", "php2", "php3", "php4", "php5", "phtml", // PHP files
                "cgi", "pl", "py", // Script files
                "sh", "bash", "cmd", // Shell script files
                "exe", "bat", "com", // Executable files
                "js", "html", "htm", "css", // Web-related files
                "jar", "war", "ear", // Java archive files
                "asp", "aspx", "ascx", "asx", // ASP files
                "jsp", "jspx", // JSP files
                "cgi", // CGI script files
                "htaccess", "htpasswd", // Apache configuration files
                "ini", // Configuration files
                "sql", "sqlite", "db", // Database files
                "ini", "log", "env", // Configuration and log files
                "yml", "yaml", // YAML configuration files
                "json", // JSON files
                "xml", // XML files
                "ini", // INI files
                "ini", // INI files
                "dll", "so", "dylib", // Dynamic library files
                "phtml", "phar", // Potentially harmful PHP-related files
                "inc", "bak", // Backup files
                "swp", "swo", // Vim swap files
                "ini", // INI files
                "ini", // INI files
            );

            if (count($filenameParts) == 2) {
                // Normal file name with 1 ext, check if ext is allowed
                $allowedExtensions = array("jpg", "JPG", "jpeg", "JPEG");
                
                if (isset($filenameParts[1]) && in_array($filenameParts[1], $allowedExtensions)) {
                    // File ext is allowed, proceed
                    unset($question, $uploadedFile, $uploadedFileName, $uploadedFileTmp, $uploadedFileSize, $destination, $filenameParts);
                    echo "<script>alert('Question posted successfully'); window.location.href = 'fileuploadS1.php';</script>"; 

                } elseif(in_array($filenameParts[1], $disallowedExtensions)) {
                    // File ext is not allowed
                    unset($question, $uploadedFile, $uploadedFileName, $uploadedFileTmp, $uploadedFileSize, $destination, $filenameParts);
                    $flag = "YCEP2024-F1L3UPLO4DVULN3RAB1L1TY(ST4G30N31)";
                    echo "<script>alert('Congratulations! This is your flag: $flag'); window.location.href = 'fileuploadS1.php';</script>";
                    exit(); // Exit to prevent further processing
                } else {
                    unset($question, $uploadedFile, $uploadedFileName, $uploadedFileTmp, $uploadedFileSize, $destination, $filenameParts, $flag);
                    echo "<script>alert('Error posting question. Please check your file extension and try again'); window.location.href = 'fileuploadS1.php';</script>";
                }

            } elseif (count($filenameParts) > 2) {
                for ($i = 1; $i < count($filenameParts); $i++) {
                    if (in_array($filenameParts[$i], $disallowedExtensions)) {
                        // Found disallowed extension, echo fail
                        $flag = "YCEP2024-F1L3UPLO4DVULN3RAB1L1TY(ST4G30N31)";
                        echo "<script>alert('Congratulations! This is your flag: $flag'); window.location.href = 'fileuploadS1.php';</script>";
                        exit(); // Exit to prevent further processing
                    } 
                }
                unset($question, $uploadedFile, $uploadedFileName, $uploadedFileTmp, $uploadedFileSize, $destination, $filenameParts, $flag);
                echo "<script>alert('Error posting question. Please check your file extension and try again'); window.location.href = 'fileuploadS1.php';</script>";
            }

        } else {
            // There is no image, only text
            echo "<script>alert('Question posted successfully'); window.location.href = 'fileuploadS1.php';</script>";
            unset($question);
        }
    } else {
        // There is no text
        echo "<script>alert('Please fill in the question you have and try again'); window.location.href = 'fileuploadS1.php';</script>";
        unset($question);
    }
}
?>

