<?php $flag = 'nil'; ?>

<!-- html form-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>.mono{
            font-family: "Courier New", monospace;
            font-weight: 700;
        }</style>
        <title>Answer a question</title>
    </head>
    <body>
        <h1>
            Is it ok to reuse my long, random password for all my accounts? 
            Coz its too difficult to recall all my passwords.
        </h1>
        <p>
            Anon_1933: IT IS NOT OK. 
            If a hacker gets ANY one of your so-called strong passwords, they can 
            access ALL your accounts. 
            Use password managers to make life easier for you :)
        </p>
        <form action="" method='POST' autocomplete="off" enctype="multipart/form-data">

            <label for="ans">Answer:</label><br>
            <input type="text" id="ans" name="ans" required><br><br>

            <input type="submit" name="submit" value="Submit">
        </form> 
    </body>
</html>

<?php
// process form response
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ans = $_POST["ans"];

    /* check that html input used has 
     * <TAG>optional_content</TAG> format
     * 
     * regex adapted from 
     * https://gist.github.com/gavin-asay/6cd089ca72b9810957254ec6a0cfced7 
     */
    if (preg_match('/^<([A-Z0-9]+)([^>]+)*(?:>(.*)<\/\1>|\s+\/>)$/', $ans) != 0){
        $flag = "YCEP2024-X55L2N15D"; ?>
        <script>
            alert('Congratulations! This is your flag: <?= $flag?>'); 
            window.location.href = 'xssS2.php';
        </script><?php
    }else{
        $ans=htmlspecialchars($ans);?>
        Your answer is: <span class="mono"><?= $ans ?></span>
        <script>
            console.log('Did not expect to see this? CASE MATTERS.');
        </script><?php
    }
}