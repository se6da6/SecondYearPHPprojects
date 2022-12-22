<?php
// http://localhost/DadakSedaCodingAsst/asstmain.php
function WriteHeaders($Heading = "Welcome", $TitleBar = "MySite",$CssFile="")
{
    echo "
        <!doctype html>
        <html lang = \"en\">
        <head>
            <meta cahrset = \"UTF-8\">
            <title>$TitleBar</title\n
        </head>
        <body>\n
        <h1>$Heading-Seda Dadak </h1>\n
        <link rel =\"stylesheet\" type = \"text/css\" href= $CssFile />
        ";
}
function DisplayLabel($prompt)
{
    echo "<label>". $prompt . "</label>";
}
function DisplayTextbox($InputType, $Name , $Size , $Value = 0)
{
    echo "
    <input type = \"$InputType\" name = \"$Name\" Size = $Size
        value = \"$Value\" > ";

}

function DisplayImage($FileName, $Alt, $Height, $Width)
{
    echo "<img src = $FileName " . " alt = $Alt " . " height =  $Height " ." width= $Width " . "/>";
}

function DisplayButton($Name, $Text, $FileName = "", $Alt = "")
{
    if($FileName==="")
    {
        echo " <button type=Submit name= $Name>". $Text. "</button> ";
    }else{
        echo " <button type=Submit name= $Name >" ;
        DisplayImage( $FileName , $Alt , " 50", " 80");  
        echo "</button> ";
    } 
    
}
function DisplayContactInfo()
{
    echo "<footer>Questions? Comments!<a href = mailto: \"seda.dadak@student.sl.on.ca\"> seda.dadak@student.sl.on.ca </a></footer>";
}

function WriteFooters()
{
    echo " </body>\n";
    echo " </html>\n";
    echo DisplayContactInfo();
}

function CreateConnectionObject()
{
    $fh = fopen('auth.txt','r');
    $Host =  trim(fgets($fh));
    $UserName = trim(fgets($fh));
    $Password = trim(fgets($fh));
    $Database = trim(fgets($fh));
    $Port = trim(fgets($fh)); 
    fclose($fh);
    $mysqlObj = new mysqli($Host, $UserName, $Password,$Database,$Port);
    // if the connection and authentication are successful, 
    // the error number is 0
    // connect_errno is a public attribute of the mysqli class.
    if ($mysqlObj->connect_errno != 0) 
    {
     echo "<p>Connection failed. Unable to open database $Database. Error: "
              . $mysqlObj->connect_error . "</p>";
     // stop executing the php script
     exit;
    }
    return ($mysqlObj);
}

?>