<?php
// http://localhost/TeamCodingAsstGroup5/TCAmain.php
require_once("TCAinclude.php");
$mysqlObj = createConnectionObject();
// main
echo "<div class = \"centerHeader\">";

writeHeaders("Text Editor", "Text Editor");
echo "<h2> created by Joel Farid , Andrew Oh, Aibiike Omurzakova, Seda Dadak, 
 Noah Mackay and  Tyler Holmes</h2>";

echo "</div>";

if (isset($_POST['f_open'])) {
    $fileContents = openFile();
    displayMainPage($fileContents);
} else if (isset($_POST['f_new'])) {
    $textFileContents = "Opened a new file.";
    displayMainPage($textFileContents);
} else if (isset($_POST['f_save'])) {
    displayMainPage();
    saveFile($_POST['f_textFile']);
} else if (isset($_POST['f_findTextInFile'])) {
    $textFileContents = $_POST['f_textFile'];
    $wordToSearch = $_POST['f_findTextBox'];
    if (isset($_POST['f_caseSense']))
        $caseSense = TRUE;
    else
        $caseSense = FALSE;
    displayMainPage($textFileContents);
    $result = findTextInFile($wordToSearch, $textFileContents, $caseSense);
    echo $result;
} else displayMainPage();
WriteFooters();
//end of main


function displayMainPage($textFileContents = "")
{
    echo "<form action = ? method = post>";

    drawMenu();

    echo "</div>";

    echo "<div class=\"textFile\">";

    echo "<textarea id = \"textArea\" name=\"f_textFile\" 
        wrap=\"hard\" autofocus=\"true\" spellcheck=\"true\">";
    echo $textFileContents;
    echo "</textarea>";

    echo "</div>";
    echo "</form>";
}
function openFile()
{
    $fileOpen = fopen('editor.dat', 'r');
    $fileRead = fread($fileOpen, 10000);
    if (file_exists('editor.dat')) {

        while (!feof($fileOpen)) {
            echo "The file $fileOpen opened";
        }
    } else {
        echo "The file $fileOpen does not exist";
    }

    fclose($fileOpen);
    return $fileRead;
}
function saveFile($savedString)
{
    $fileOpen = fopen("editor.dat", "w"); //Open and save what is written into it 
    $fileWrite = fwrite($fileOpen, $savedString); //ReWritting into the file 
    if ($fileWrite == TRUE) {
        echo "<p>File Saved</p>";
    } else {
        echo "<p>Error saving file</p>";
    }
    fclose($fileOpen);
}
function drawMenu()
{
    echo "<div class=\"centerDiv\">";

    echo "<div class=drawMenu>";

    drawFileDropDown();
    drawEditDropDown();
    drawFontDropDown();

    echo "</div>";
}
function drawFileDropDown()
{
    echo "<div class=\"dropdown\">";

    DisplayButton("file_new", "File", "", "submit");

    //The File Button
    echo "<div class=\"dropdown-content\">";

    DisplayButton("f_new", "New"); //New button
    DisplayButton("f_open", "Open"); //Open button
    DisplayButton("f_save", "Save"); //Save button

    echo "</div>";
    echo "</div>";
}

function drawEditDropDown()
{
    echo "<div class=\"dropdown\">";

    DisplayButton("edit_new", "Edit", "", "submit"); //The Edit button

    echo "<div class=\"dropdown-content\">";

    DisplayLabel("Find:");
    DisplayTextBox("f_findTextBox", 10); //searchbox
    DisplayLabel("Case Sensitive?"); //Case Sensitive label

    echo "<input type = \"checkbox\" name = \"f_caseSense\"> </input>"; //checkbox for case sensitivity
    DisplayButton("f_findTextInFile", "Find", "", "submit"); //Find button

    echo "</div>";
    echo "</div>";
}
function findTextInFile($wordBeingSearchedFor, $userCurrentWordDoc, $caseSense)
{
    // function receives the word being searched for as well as the current working document.
    // case
    // will search through the document using a CASE SENS function

    if ($wordBeingSearchedFor == "") {
        return "<p> Can not search for empty field </p>";
    } else {
        if ($caseSense) {
            $positionOfFoundWord = strpos($userCurrentWordDoc, $wordBeingSearchedFor, 0);
        }
        // will search through the document using a NON CASE SENS function
        else {
            $positionOfFoundWord = stripos($userCurrentWordDoc, $wordBeingSearchedFor, 0);
        }
        if ($positionOfFoundWord === FALSE) {
            return "<p> $wordBeingSearchedFor does not exist in this document
             </p> ";
        } else {
            return "<p> Found $wordBeingSearchedFor at position "
                . $positionOfFoundWord + 1 . "</p>";
        }
    }
}

function drawFontDropDown()
{
    $mysqlObj = CreateConnectionObject();

    $query = "SELECT fontName
    FROM fontNames";
    $stmtObj = $mysqlObj->prepare($query);

    $fetchResult = $stmtObj->execute();

    $stmtObj->bind_result($FontName);

    echo "<div class=\"dropdown\">

        <button class=\"dropBtn\">Font</button>
        <div class=\"dropdown-content\">
        
            <label id=\"fontLabel\">Font</label>
            <select id=\"fontTextArea\" Name=\"fontListBox\" Size=\"5\" onChange=\"changeFontStyle(this.value);\">";
    $num = 1;
    while ($stmtObj->fetch()) {
        echo "
                <option value=$num> $FontName </option>";
        $num = $num + 1;
    }
    echo "
            </select>

            <label id=\"fontSizeLabel\">Font Size</label>
            <select id=\"fontSizeOptions\" Name=\"fontSizeListBox\" Size=\"5\" onChange=\"changeFontSize(this.value);\">
                <option value=\"small\">small</option>
                <option value=\"medium\">medium</option>;
                <option value=\"large\">large</option>;";
    echo "
            </select>
        </div>
    </div>";
    $stmtObj->close();
}