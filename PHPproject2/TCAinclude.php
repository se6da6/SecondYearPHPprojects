<?php
function WriteHeaders($Heading = "Welcome", $TitleBar = "MySite")
{

    echo "
    <!doctype html>
    <html lang = \"en\">
    <link rel =\"stylesheet\" type = \"text/css\" href=\"./TCA.css\"/>
    <script type = \"text/javascript\" src = \"./TCA.js\"></script>
    <head>
        <meta charset = \"UTF-8\">
        <title>$TitleBar</title>\n
    </head>
    <body>\n
    <h1>$Heading</h1>\n
    ";
}
function WriteFooters()
{

    echo "</body>\n";
    echo "</html>\n";
}
function DisplayLabel($prompt)
{

    echo "<label>" . $prompt . "</label>";
}
function DisplayTextBox($name, $size)
{

    echo "<input class = \"textBoxStyles\" type=text name=$name size=$size>";
}
function DisplayButton($name, $text = "", $filename = "", $alt = "")
{

    if ($filename == "") {
        echo "<button class=\"dropBtn\" type=submit name=$name> $text </button>";
    } else {
        echo "<button class=\"dropBtn\" type=submit name=$name>";
        DisplayImage($filename, $height = 50, $width = 150, $alt);
        echo "</button>";
    }
}
function DisplayImage($filename, $height, $width, $alt)
{

    echo "<img src=\"$filename\" height=\"$height\" width=\"$width\" alt=\"$alt\"/>";
}
function createConnectionObject()
{
    $fh = fopen("auth.txt", "r");
    $Host =  trim(fgets($fh));
    $UserName = trim(fgets($fh));
    $Password = trim(fgets($fh));
    $Database = trim(fgets($fh));
    $Port = trim(fgets($fh));
    fclose($fh);
    $mysqlObj = new mysqli($Host, $UserName, $Password, $Database, $Port);
    // if the connection and authentication are successful, 
    // the error number is 0
    // connect_errno is a public attribute of the mysqli class.
    if ($mysqlObj->connect_errno != 0) {
        echo "<p>Connection failed. Unable to open database $Database. Error: "
            . $mysqlObj->connect_error . "</p>";
        // stop executing the php script
        exit;
    }
    return ($mysqlObj);
}