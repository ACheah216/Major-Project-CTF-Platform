<?php /*
Level 2 SQL Injection: 
   > Test ability to execute commands that in theory, 
     might be able to obtain all data stored in a database. 

No database available here so it's emulated via arrays, regexes & eval()*/

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
$hint_str = 'Check hint in sqlS1.php & refer to lab sheet.';

// process form response
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST["userID"];

    /* prevent unsafe input from being passed to eval 
     * see https://www.php.net/manual/en/function.eval.php as to why */
    $regex_arr = array(
        // regex , literal 
        # php tags
        '/<\?/'  , /* <? */
        '/\?>/'  , /* ?> */

        # anything that can be used to make comments
        '/\//'   , /* / */
        '/\#/'   , /* # */

        # escape character (https://stackoverflow.com/a/15369828)
        "/\\\\/" , /* \ */

        # variable marker
        '/\$/'   , /* $ */

        # semicolon as this might cause false positive
        '/;/'    , /* ; */

        # various brackets
        '/\(/'   , /* ( */
        '/\)/'   , /* ) */
        '/\{/'   , /* { */
        '/\}/'   , /* ) */
        '/\[/'   , /* ) */
        '/\]/'   , /* ) */
    );
    if (checkregex($regex_arr, $userID)){
        $hint_str = 'You might have entered a blacklisted symbol. Try again.';
        rendererror($hint_str, $userID);
        exit;
    }else{
        echo '<!-- moving on... -->';
    }

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

    // regex to emulate database
    $regex_arr = array(
        '/[0-9]+\s+OR\s+TRUE/i',
        '/[0-9]+\s+OR\s+NOT\s+FALSE/i'
    );
    
    // if initial sql attack is successful
    if (checkregex($regex_arr, $userID)){
        renderflag($user_arr);
    }else{

        // check another set of known sql attacks that will work
        $regex_arr = array(
            // note that only the part after 0-9 or gets eval'ed
#           0-9 OR 0-9 = 0-9
            '/[0-9]+\s+OR\s+[0-9]+\s*=\s*[0-9]+/i',

#           0-9 OR 'string' = 'string'
            '/[0-9]+\s+OR\s+\'.*\'\s*=\s*\'.*\'/i',

#           0-9 OR "string" = 'string'
            '/[0-9]+\s+OR\s+".*"\s*=\s*\'.*\'/i',

#           0-9 OR 'string' = "string"
            '/[0-9]+\s+OR\s+\'.*\'\s*=\s*".*"/i',

#           0-9 OR "string" = "string"
            '/[0-9]+\s+OR\s+".*"\s*=\s*".*"/i',
        );
        if (checkregex($regex_arr, $userID)){

            // create array of characters separated by space
            $sql_attack = explode(' ', $userID);
            echo '<!--'; // begin debug comment
            echo 'input: '; 
            print_r($sql_attack); 
            echo 'type: '.gettype($sql_attack);

            /* remove 1st item in input
            https://www.w3schools.com/php/php_arrays_remove.asp */
            unset($sql_attack[0]);
            echo ' payload: '; 
            var_dump($sql_attack);

            // remove everything including "or" but go no further
            $count = 0;
            foreach ($sql_attack as $phrase){
                echo " count: $count ";
                if (preg_match('/or/i', $phrase)){
                    unset($sql_attack[$count]);
                    break;
                }else{
                    unset($sql_attack[$count]);
                }
                $count++;
            }
            echo ' payload - or: '; 
            var_dump($sql_attack);
            unset($sql_attack[$count+1]);

            /* reset array index
            https://stackoverflow.com/a/52678284 */
            $sql_attack = array_values($sql_attack);
            echo 'resetted ';
            var_dump($sql_attack);
            echo '-->'; // end debug comment

            switch (count($sql_attack)){

                // format of $val_1=$val_2
                case 1:
                    echo "<!-- case 1: \n"; // begin debug comment

                    // replace characters
                    $sql_attack = str_split($sql_attack[0]);
                    $sql_attack = replacechar($sql_attack, '', ' ');
                    $sql_attack = replacechar($sql_attack, '=', '==');

                    // make stmt and eval it
                    $sql_str = implode($sql_attack);
                    echo "stmt 2 be eval'ed: $sql_str\n";
                    $attack_stmt='return '.$sql_str.';';
                    echo '-->'; // end debug comment
                    rendereval($attack_stmt, $user_arr, $hint_str, $userID);
                    break;
                
                // format of $val_1= $val_2 || $val_1 =$val_2
                case 2:
                    echo "<!-- case 2: \n"; // begin debug comment
                    echo 'arr 1:';
                    var_dump(str_split($sql_attack[0]));
                    echo 'arr 2:';
                    var_dump(str_split($sql_attack[1]));

                    // replace chars
                    $arr1 = replacechar(str_split($sql_attack[0]), '', ' ');
                    $arr2 = replacechar(str_split($sql_attack[1]), '', ' ');
                    $arr1 = replacechar(str_split($sql_attack[0]), '=', '==');
                    $arr2 = replacechar(str_split($sql_attack[1]), '=', '==');

                    // make stmt and eval it
                    $sql_str=implode($arr1).implode($arr2);
                    echo "initial stmt: $sql_str\n";
                    $attack_stmt='return '.$sql_str.';';
                    echo '-->'; // end debug comment
                    rendereval($attack_stmt, $user_arr, $hint_str, $userID);
                    break;
                
                // any other format
                default:
                    echo "<!-- case default: \n"; // begin debug comment

                    // change = to ==
                    for ($i=0; $i<count($sql_attack); $i++){
                        echo 'type: '.gettype($sql_attack[$i])."\n";
                        $sql_attack[$i]=replacechar(
                            str_split($sql_attack[$i]), '=', '=='
                        );
                    }
                    echo 'dumping data 1d: ';
                    var_dump($sql_attack);

                    $sql= '';
                    for ($i=0; $i<count($sql_attack); $i++){

                        // adds space as array of arrays
                        if (count($sql_attack[$i])==0){
                            $sql_attack[$i]=array(' ');
                        }

                        // flattens it to str so it's array of strs
                        $sql_attack[$i]=implode($sql_attack[$i]);
                        $sql_attack[$i].=' ';
                    }
                    echo 'dumping data 2d: ';
                    var_dump($sql_attack);

                    // make stmt & eval it
                    $sql_str = implode($sql_attack);
                    echo "stmt 2 be eval'ed: $sql_str\n";
                    $attack_stmt='return '.$sql_str.';'; 
                    echo "string: $attack";
                    echo '-->'; // end debug comment
                    rendereval($attack_stmt, $user_arr, $hint_str, $userID);
                    break;
            }
        // no successful sql attack
        }else{
            $count = 0; 
            $found = FALSE;
            foreach($user_arr as $row){
                $count++;
        
                // if id number can be accessed
                if ($userID == $row[2]){
                    renderuser($user_arr[$count-1][0], $hint_str);
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
function rendereval($attack_stmt, $user_arr, $hint_str, $userID){
    // https://stackoverflow.com/a/38745310
    try{
        // https://www.oreilly.com/library/view/php-in-a/0596100671/re47.html
        $evaled = eval($attack_stmt);
    }catch (ParseError $e) {
        $msg = 'An unexpected error occurred. See below for details';
        rendererror($msg, $userID);
        ?>
        <script>
            console.log('>>> <?=$e->getMessage()?>');
            console.log('Please try another input');
        </script>
        <?php
        exit;
    }
    // if sql attack successful
    echo '<!-- result:';
    var_dump($evaled);
    echo '-->';
    if ($evaled){
        renderflag($user_arr);

    // if sql attack unsuccessful
    }else{
        echo "<!-- \n";
        $user = array();

        // get first number (id) and check with array of users
        foreach (explode(' ',$userID) as $char){
            if (preg_match('/[0-9]+/', $char)!=0){
                echo "dumping char: $char, ".gettype($char);

                // returns user as an array with int indexes
                $user = $user_arr[intval($char)-1];
                break;
            }else{
                echo "no int found \n";
            }
        }
        var_dump($user);
        echo '-->';

        // see if user exists and render appriopriate message
        if ($user != NULL){
            renderuser($user[0], $hint_str);
        }else{
            rendererror($hint_str, $userID);
        }
    }
}

function renderflag($user_arr){
    $flag = 'YCEP2024-5QLI2E6YW';
    ?>
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
    </script>
    <?php
}

function rendererror($hint_str, $userID){ 
    ?>
    Error: User with ID 
     <span class="mono">
        <?= htmlspecialchars($userID) ?>
    </span> doesn't exist.
    <script>
        console.log("Did not expect to see this? <?= $hint_str?>"); 
    </script>
    <?php
}

function renderuser($username, $hint_str){
    ?>
    Username: 
    <span class="mono">
        <?= htmlspecialchars($username)?>
    </span>
    <script>
        console.log("Did not expect to see this? <?= $hint_str?>"); 
    </script>
    <?php
}

function replacechar($array, $original, $replacement){
    echo 'type in func rc: '.gettype($array)."\n";
    for ($j=0; $j<count($array); $j++){
        echo "array @ $j; \n content: {$array[$j]}\n";
        if($array[$j]==$original){
            echo "index replaced: $j\n ";
            $array[$j]=$replacement;
        }else{
            echo "no change \n";
        }
    }
    echo "processed array:";
    var_dump($array);
    return $array;
}