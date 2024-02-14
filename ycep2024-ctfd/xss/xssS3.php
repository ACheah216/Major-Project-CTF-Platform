<?php 
$flag = 'nil'; 
require_once '../utils/utils.php'
?>

<!-- html form -->
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
        <h1>Is Javascript the same as Java?</h1>
        <p>Anon_1453: No. Java is compiled, JS is not.</p>
        <p>Anon_1976: No. Idk why they both have java in it.</p>
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
    echo '<!-- attempting form retrieval... -->';
    $ans = $_POST["ans"];

    /* check for risky tags that are NOT script 
     * does so case-insensitively
     * 
     * see
     * https://cheatsheetseries.owasp.org/cheatsheets/XSS_Filter_Evasion_Cheat_Sheet.html
     * for more
     */
    $regex_arr = array(

        /* [action] means placeholder for js code to be executed
         * 
         * note that for these to work as xss (ASSUME WEBSITE DOES NOT ESCAPE CHARS):
         * 1. tags and brackets in placeholder must be closed
         * 2. js code in placeholder must be valid
         */

#       <SVG/ONLOAD=[action]
        '/<SVG\/ONLOAD=/i',
#       <BODY ONLOAD=[action]
        '/<BODY ONLOAD=/i',
#       <IMG SRC="javascript: [action]
        '/<IMG SRC="javascript:/i',
#       <IFRAME SRC="javascript: [action]
        '/<IFRAME SRC="javascript:/i', 
#       <BGSOUND SRC="javascript: [action]
        '/<BGSOUND SRC="javascript:/i', 
#       <FRAMESET><FRAME SRC="javascript: [action]
        '/<FRAMESET><FRAME SRC="javascript:/i', 
#       <TABLE BACKGROUND="javascript: [action]
        '/<TABLE BACKGROUND="javascript:/i', 
#       <TABLE><TD BACKGROUND="javascript: [action]
        '/<TABLE><TD BACKGROUND="javascript:/i', 
#       <DIV STYLE="background-image: url(javascript: [action]
        '/<DIV STYLE="background-image: url\(javascript:/i', 
#       <LINK REL="stylesheet" HREF="javascript:[action]
        '/<LINK REL="stylesheet" HREF="javascript:/i',
#       <IMG DYNSRC="javascript: [action]
        '/<IMG DYNSRC="javascript:/i',
#        <IMG LOWSRC="javascript: [action]
        '/<IMG LOWSRC="javascript:/i',
#       <META HTTP-EQUIV="refresh" CONTENT="0;url=javascript: [action]
        '/<META HTTP-EQUIV="refresh" CONTENT="0;url=javascript:/i',
#       <DIV STYLE="width: expression([action]
        '/<DIV STYLE="width: expression\(/i',
#       <BASE HREF="javascript:[action]
        '/<BASE HREF="javascript:/i',
#       <BODY BACKGROUND="javascript:[action]
        '/<BODY BACKGROUND="javascript:/i'
    );
    
    // if $ans has any of these risky tags
    if (checkregex($regex_arr, $ans)){
        $flag = "YCEP2024-X55L3N8UY"; 
        ?><script>
            alert('Congratulations! This is your flag: <?= $flag?>'); 
            window.location.href = 'xssS3.php';
        </script><?php
    }else{
        $ans=htmlspecialchars($ans);?>
        Your answer is: <span class="mono"><?= $ans?></span>
        <script>console.log(`
            Did not expect to see this?
            Try alternative inputs that can run js.
        `);</script><?php
    }
}

