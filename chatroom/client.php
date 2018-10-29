<?php

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    return;
}

// get the name from cookie
$name = $_COOKIE["name"];

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript">
        //<![CDATA[
        function load() {
            var name = "<?php print $name; ?>";

            //delete this line 
            //window.parent.frames["message"].document.getElementById("username").setAttribute("value", name)
            window.parent.frames["message"].location.reload();

            setTimeout("document.getElementById('msg').focus()",100);
        }

        function select_color(color) {
            document.getElementById("color").value = color;
        }
        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()">
        <form action="add_message.php" method="post">
            <table border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td colspan='3'>What is your message?</td>
                </tr>
                <tr>
                    <td colspan='3'><input class="text" type="text" name="message" id="msg" style= "width: 780px" /></td>
                </tr>
                <tr>
                    <td><input class="button" type="submit" value="Send Your Message" style="width: 200px" /></td>
                    <td valign="middle" align="right">Choose your color:</td>
                    <td> 
                        <button style="background-color:white;width:30px;height:30px" onclick="select_color('#ffffff'); return false;" />
                        <button style="background-color:#ff0000;width:30px;height:30px" onclick="select_color('#ff0000'); return false;" />
                        <button style="background-color:#0000ff;width:30px;height:30px" onclick="select_color('#0000ff'); return false;" />
                    </td>
                </tr>
                <input type='hidden' id='color' name='color' value="#000000" />
            </table>
        </form>
        
        <!--logout button-->
        <form action="logout.php" method="post" onsubmit="alert('Goodbye')">
            <table>
            <tr><td>
            <input class="button" type='submit' value="Logout" style="width: 200pt"/>
            </td></tr>
            <table>
        </form>

    </body>
</html>
