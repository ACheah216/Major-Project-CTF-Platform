<?php $flag = 'nil'?>

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
        <h1>How long should my password be?</h1>
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
     * <tag>optional_content</tag> format
     * 
     * regex adapted from 
     * https://gist.github.com/gavin-asay/6cd089ca72b9810957254ec6a0cfced7 
     */
    if (preg_match('/^<([A-Za-z0-9]+)([^>]+)*(?:>(.*)<\/\1>|\s+\/>)$/', $ans) != 0){
        $flag = "YCEP2024-X55L1T8DA"; 
        ?><script>
        alert('Congratulations! This is your flag: <?= $flag?>'); 
        window.location.href = 'xssS1.php';
        </script><?php
    }else{
        $ans=htmlspecialchars($ans);?>
        Your answer is: <span class="mono"><?= $ans ?></span>
        <script>console.log(
            'Did not expect to see this? Try other inputs'
        )</script>
        <?php
    }
}