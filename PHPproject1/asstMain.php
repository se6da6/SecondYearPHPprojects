<?php
// http://localhost/DadakSedaCodingAsst/asstmain.php 
require_once("asstInclude.php");
require_once("clsDeleteSunglassRecord.php");

function displayMainForm()
{
    echo "<form action= ? method=post>";
    echo DisplayButton("f_CreateTable","Create Table","createTable.jpg","createTable");
    echo DisplayButton("f_AddRecord", "Add records","addRecord.jpg","addRecords");
    echo DisplayButton("f_DeleteRecord", "Delete Records","deleteRecord.jpg","deleteRecord");
    echo DisplayButton("f_DisplayData", "Display Data","displayData.jpg","displayData");
    echo"</form>";

}

function createTableForm(&$mysqlObj, $TableName)
{
    echo "<form action= ? method=post>";
    $stmtObj = $mysqlObj->prepare("drop table if exists $TableName");
    $stmtObj ->execute();
    $BrandName = "BrandName varchar(20) Primary Key";
    $Date = "DateManufactured date";
    $CameraMp = "CameraMp int";
    $Color = "Color varchar(30)";
    $SQLStatement = "Create table $TableName($BrandName, $Date, $CameraMp, $Color);";

    $stmtObj = new mysqli_stmt($mysqlObj);
    $stmtObj = $mysqlObj->prepare($SQLStatement);
    if($stmtObj==false)
    {
        echo "Prepare failed on query $SQLStatement";
        exit;
    }
    $CreateResult = $stmtObj->execute();
    if($CreateResult)
        echo "Table $TableName created";
    else
        echo "Cannot create table$TableName.Query $SQLStatement failed.";
    
    echo DisplayButton("f_Home", "Home","home.jpg","home");
echo"</form>";
}

function addRecordForm(&$mysqlObj, $TableName)
{

    echo "
        <form action= ? method=post>";
            echo "<div class=\"DataPair\">";
            echo DisplayLabel("Brand Name");
            echo DisplayTextbox("text", "f_BrandName", 20, "");
            echo "</div>";
            echo "<div class=\"DataPair\">";
            echo DisplayLabel("Date Manufactured");
            echo DisplayTextbox("date","f_DateManufactured", "", date("Y-m-d"));
            echo "</div>";
            echo "<div class=\"DataPair\">";
            echo DisplayLabel("Camera MP");
            echo "<div>
                    <input type=\"radio\" id=\"5 Mp\" name=\"f_CameraMp\" value=\"5 Mp\" checked>
                <label for=\"5Mp\">5 MP</label>
                </div>     
                <div>
                    <input type=\"radio\" id=\"10 Mp\" name=\"f_CameraMp\" value=\"10 Mp\">
                <label for=\"10 Mp\">10 Mp</label>
                </div>";
            echo "</div>";
            echo "<div class=\"DataPair\">";
            echo DisplayLabel("Colour");
            echo DisplayTextbox("color", "f_Color", "", "#FFFCE7");
            echo "</div>";
        echo DisplayButton("f_Save","Save Records","saveRecord.jpg","saveRecord");
        echo DisplayButton("f_Home","Home","home.jpg","home");
        echo "</form>";

}

function saveRecordToTableForm(&$mysqlObj, $TableName)
{
    echo "<form action= ? method=post>";
    $BrandName = $_POST["f_BrandName"];
    $Date = $_POST["f_DateManufactured"];
    $CameraMp = $_POST["f_CameraMp"];
    $Color = $_POST["f_Color"];
    $query = "Insert into $TableName 
            (BrandName, DateManufactured, CameraMp, Color) Values (?,?,?,?)";
    $stmtObj = $mysqlObj -> prepare($query);
    $BindSuccess = $stmtObj -> 
                 bind_param("ssis", $BrandName, $Date, $CameraMp, $Color);
    if($BindSuccess)
        $success = $stmtObj-> execute();
    else
        echo "Bind failed : " . $stmtObj -> error;
    if($success)
        echo $mysqlObj -> affected_rows . " records successfully added ";
    else   
        echo $mysqlObj -> error; 
    
    echo DisplayButton("f_Home","Home","home.jpg","home");
    echo"</from>";
}

function displayDataForm(&$mysqlObj,$TableName)
{
    echo "<form action= ? method=post>";
    $stmtObj = $mysqlObj->prepare("Select BrandName, DateManufactured, CameraMp, Color from $TableName");
    $bindSuccess=$stmtObj->bind_result($BrandName, $Date, $CameraMp,$Color);
    if ($bindSuccess){
        $succes = $stmtObj -> execute();
    }else{
        echo"Bind failed.".$stmtObj->error;
    }
    if($succes){
        echo "
            <table>
                <tr>
                    <th>BrandName</th>
                    <th>DateManufactured</th>
                    <th>CameraMp</th>
                    <th>Color</th>
                </tr>";
        while($stmtObj->fetch())
        {
            echo "          
                <tr>
                    <td>$BrandName</td>
                    <td>$Date</td>
                    <td>$CameraMp</td>
                    <td><input type = color value = $Color></td>
                </tr>"
            ;

        }
      echo "</table>";
    }
    
    echo DisplayButton("f_Home","Home","home.jpg","home");
    echo"</from>";
}

function deleteRecordForm(&$mysqlObj, $TableName)
{
    echo "<form action= ? method=post>";
    echo "<div class=\"DataPair\">";
    echo DisplayLabel("What brand would you like to delete?");
    echo DisplayTextbox("text", "f_BrandName", "", "");
    echo "</div>";
    echo "<div class=\"DataPair\">";
    echo DisplayLabel("Last warning this record will be deleted completely?");
    echo "</div>";  
    echo DisplayButton("f_IssueDelete","Delete ","delete.jpg","delete");
    echo DisplayButton("f_Home","Home","home.jpg","home");
    echo "</form>";
}

function issueDeleteForm(&$mysqlObj, $TableName)
{
    echo "<form action= ? method=post>";
    $BrandName = $_POST["f_BrandName"];
    $deleteRecord = new clsDeleteSunglassRecord();
    $numberOfDeletedRecords = $deleteRecord -> 
                            deleteTheRecord($mysqlObj,$TableName,$BrandName);
    if($numberOfDeletedRecords==0)
        echo "$BrandName record does not exist.";
    else
        echo "$BrandName record deleted. ";
    echo DisplayButton("f_Home","Home","home.jpg","home");
    echo "</form>";
}
// main
date_default_timezone_set ('America/Toronto');
$mysqlObj=CreateConnectionObject(); 
$TableName = "Sunglasses"; 
WriteHeaders("Sunglassses Company Records", "SunGlasses' Records","asstStyle.css");// writeHeaders call  
if (isset($_POST['f_CreateTable']))
  createTableForm($mysqlObj,$TableName);
 else if (isset($_POST['f_Save'])) saveRecordtoTableForm($mysqlObj,$TableName) ;
    else if (isset($_POST['f_AddRecord'])) addRecordForm($mysqlObj,$TableName) ;	   
 	  else if (isset($_POST['f_DeleteRecord'])) deleteRecordForm($mysqlObj,$TableName) ;	 
          else if (isset($_POST['f_DisplayData'])) displayDataForm ($mysqlObj,$TableName);
     		else if (isset($_POST['f_IssueDelete'])) issueDeleteForm ($mysqlObj,$TableName);
 		        else displayMainForm();
if (isset($mysqlObj)) $mysqlObj->close();


writeFooters();


?>