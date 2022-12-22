function changeFontSize(pFontSize)
    {
        document.getElementById("textArea").style.fontSize = pFontSize;
    }

function changeFontStyle(pFontStyle)
    {
        var fontListBox = document.getElementById("fontTextArea");
        fontStyle = (fontListBox[pFontStyle - 1].text);
        document.getElementById("textArea").style.fontFamily = fontStyle;
    }
