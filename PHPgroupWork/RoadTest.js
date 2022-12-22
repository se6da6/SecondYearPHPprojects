// IMP: can issue js statments in console tab of Chrome F12
//console.log(variable)
function showHideControls()
{ 
 let checkBox=document.getElementById("f_IncidentCheckbox");
 if(checkBox.checked==true)
    document.querySelector(".visible").style.visibility="hidden";
else
document.querySelector(".visible").style.visibility="visible";
    
}
function hideSaveButton(isValid)
{
    
    let btn=document.getElementById("saveButton");
    btn.disabled=isValid;
	 
}
function Validate()
{
    licensePlate = document.getElementById("f_LicensePlate").value;
let isValid=false;
    if(licensePlate == "")

    {

        alert("License Plate is empty, please enter something. ") ;
        isValid=true;
        hideSaveButton(isValid);
    }

    speed = document.getElementById("f_Speed").value;

    if(speed > 50)

    {

        alert("Thats too fast! ") ;
        isValid=true;
        hideSaveButton(isValid);
    }

    let requiredDate = new Date('2000-4-15');

    dateStamp = new Date(document.getElementById("f_DateStamp").value);

    if(dateStamp < requiredDate)

    {

        alert("Need to be later than 2000-4-15");
        isValid=true;
        hideSaveButton(isValid);
    }
    hideSaveButton(isValid);
}
 