<?php /* 
Level 1 SQL Injection: 
   > Test ability to execute commands that in theory, might 
        1. damage database or 
        2. obtain data from it 
This is to simulate attacking a database. */

require '../utils/utils.php';
$flag = 'nil';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset password</h1>
    <form action="" method='POST' autocomplete="off" enctype="multipart/form-data">
        <label for="passwd">Enter new password: </label><br>
        <input type="text" id="passwd" name="passwd" required><br><br>
        <label for="passwdnew">Enter new password again: </label><br>
        <input type="text" id="passwdnew" name="passwdnew" required><br><br>
        <input type="submit" name="submit" value="Submit">
    </form> 
</body>

<?php
// process form response
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwd = $_POST["passwd"];
    $newpasswd = $_POST["passwdnew"];
    
    // array of possible sql injection queries
    $regex_arr = array(

        /* [] in comments is a placeholder; 
         * {} means optional to include 
         * 
         * Note that for these sqli attacks to work on other sites: 
         *  1. opened brackets must be closed
         *  2. at the end of the statement, ; -- characters must be present
         * 
         * Disclaimer: the sites must have the vulnerability 
         * and it must allow for multiple sql statements to be executed. 
         * if not, an error will be returned */
// --------------------------------------------------------------------------

#   Obtain data
#       [any input]; SELECT * FROM ycepctfsqlinjection.users
            /* return everything in users table */
            '/.; SELECT \* FROM ycepctfsqlinjection\.users/i',
#       [any input]; SELECT username, passwd FROM ycepctfsqlinjection.users
            /* return all usernames and passwords in users table */
            '/.; SELECT username, passwd FROM ycepctfsqlinjection\.users/i',

#   Damage table
#       [any input]; DROP TABLE users
            /* deletes entire users table*/
            '/.; DROP TABLE users/i',
#       [any input]; ALTER TABLE users [instruction to change table structure]
            /* changes table structure 
            (add column, change existing column...) */
            '/.; ALTER TABLE users/i',

#   Alter table data
#       [any input]; INSERT INTO users VALUES ([username, passwd]
            /* create additional user */
            '/.; INSERT INTO users VALUES \(/i',
#       [any input]; INSERT INTO users ([columns to fill]
            /* create additional user */
            '/.; INSERT INTO users \(/i',
#       [any input]; UPDATE users SET [instruction to update data]
            /* changes user's info */
            '/.; UPDATE users SET/i',
#       [any input]; DELETE FROM users {instruction to delete data}
            /* deletes a user */
            '/.; DELETE FROM users/i',
    
#   Damage database
#       [any input]; DROP DATABASE ycepctfsqlinjection
            /* deletes entire database */
            '/.; DROP DATABASE ycepctfsqlinjection/i',
#       [any input]; CREATE TABLE [table name] [instruction to create columns]
            /* creates additional table */
            '/.; CREATE TABLE ./i',
    );
    ?>
    
    <?php if (checkregex($regex_arr, $passwd) || checkregex($regex_arr, $newpasswd)):
        $flag = "YCEP2024-5QLI1XO44"; ?>
        <script>
            alert('Congratulations! This is your flag: <?= $flag ?>'); 
            window.location.href = 'sqlS1.php';
        </script>
    <?php else: ?>
        <?php if ($passwd === $newpasswd): ?>
            Error: Password unable to be reset at this time.
            <script>console.log('Try other SQL Injection methods');</script>
        <?php else: ?>
            Error. Passwords do not match.
        <?php endif; ?>
        <script>
            console.log(`
                Not expecting to see this? 
                See JSON schematics below for help:

                {
                "db_name" : "ycepctfsqlinjection",
                "tables" : "users",
                "column_info" : [
                    {
                        "name": "id",
                        "data_type": "int",
                        "size": "UNSIGNED INT"
                    },
                    {
                        "name": "username",
                        "data_type": "string",
                        "size": 32
                    },
                    {
                        "name": "passwd",
                        "data_type": "string",
                        "size": 256
                    }]
                }
                
                also see the lab sheet 
            `)  
        </script>
    <?php endif; 
}
?>
</html>