<?php /*
Level 2 SQL Injection: 
   > Test ability to execute 1 command that in theory, 
     might be able to obtain all data stored in a database. 

No database available here so it's emulated via arrays & regexes*/

require '../utils/utils.php';
$flag = 'nil'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .mono{
            font-family: "Courier New", monospace;
            font-weight: 700;
        }
    </style>
    <title>Search Username</title>
</head>
<body>
    <h1>Search Username</h1>
    <form action="" method='POST' autocomplete="off" enctype="multipart/form-data">
        <label for="userID">Enter user ID: </label><br>
        <input type="text" id="userID" name="userID" required><br><br>
        <input type="submit" name="submit" value="Submit">
    </form> 
</body>

<?php
$hint_str = "Did you manage to solve sqlS2.php? If so, how can TRUE be derived?";

// process form response
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST["userID"];

    // create array of users with
    $user_arr = array(
    #          username  , password                      , id no
        array('Anon_1453', 'password-'                   , '1'),
        array('User_1963', 'TV801nK&qo'                  , '2'),
        array('Anon_1462', '1234Qwerty'                  , '3'),
        array('User_1917', 'QWERTY-asdfg12345-'          , '4'),
        array('Anon_1933', '8xe3G)73@8u879h9j78+M]JPAxd-', '5'),
        array('Anon_1976', 'qwertyUIOP'                  , '6')
    );

    /* regex to emulate database
     * the below may work as sql injection payload if 
     * website treats "[0-9]+ OR 1=1" as valid sql injection payload */
    $regex_arr = array('/[0-9]+\s+OR\s+NOT\s+FALSE/i');
    
    // if initial sql attack is successful
    if (checkregex($regex_arr, $userID)){
        renderflag($user_arr);
    }else{
        $regex_arr = array(
            '/[0-9]+\s+OR\s+[0-9]+\s*=\s*[0-9]+/i',
            '/[0-9]+\s+OR\s+\'.*\'\s*=\s*\'.*\'/i',
            '/[0-9]+\s+OR\s+".*"\s*=\s*\'.*\'/i',
            '/[0-9]+\s+OR\s+\'.*\'\s*=\s*".*"/i',
            '/[0-9]+\s+OR\s+".*"\s*=\s*".*"/i',
            '/[0-9]+\s+OR\s+TRUE/i'
        );
        if (checkregex($regex_arr, $userID)){
            rendererror($hint_str, $userID);
        }else{
            $count = 0; 
            $found = FALSE;
            foreach($user_arr as $row){
                $count++;
            
                // if id number can be accessed
                if ($userID == $row[2]){
                    ?>
                    Username: <span class="mono">
                    <?= htmlspecialchars($user_arr[$count-1][0])?></span>
                    <script>
                        console.log("Did not expect to see this? <?= $hint_str?>"); 
                    </script>
                    <?php
                    $found = TRUE;
                    break;
                }
            }
            if (!$found){
                rendererror($hint_str, $userID);
            }
        }
    }
}
?>
</html>

<?php
// extra functions for display
function renderflag($user_arr){
    $flag = 'YCEP2024-5QLI3U2F6';?>
    <script>
        console.log(`
            <?php foreach ($user_arr as $row): ?>
                \n
                User id: <?= htmlspecialchars($row[2]) ?>\n
                Username: <?= htmlspecialchars($row[0]) ?>\n
                Password: <?= htmlspecialchars($row[1]) ?>\n
            <?php endforeach; ?>
        `);
        alert('Congratulations! This is your flag: <?= $flag?>');
        window.location.href = 'sqlS2.php';
    </script><?php
}

function rendererror($hint_str, $userID){ ?>
     Error: User with ID 
     <span class="mono">
        <?= htmlspecialchars($userID) ?>
    </span> doesn't exist.
    <script>
        console.log("Did not expect to see this? <?= $hint_str?>"); 
    </script><?php
}