<?php

// get the name from cookie
$name = "";
if (isset($_COOKIE["name"])) {
    $name = $_COOKIE["name"];
}

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script language="javascript" type="text/javascript">
        //<![CDATA[
        var loadTimer = null;
        var request;
        var datasize;
        var lastMsgID;

        function load() {
            var username = document.getElementById("username");
            if (username.value == "") {
                // loadTimer = setTimeout("load()", 100);
                return;
            }

            loadTimer = null;
            datasize = 0;
            lastMsgID = 0;


            
            var node = document.getElementById("chatroom");
            node.style.setProperty("visibility", "visible", null);

            getUpdate();
        }

        function unload() {
            var username = document.getElementById("username");
            if (username.value != "") {
                // //request = new ActiveXObject("Microsoft.XMLHTTP");
                // request =new XMLHttpRequest();
                // request.open("POST", "logout.php", true);
                // request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                // request.send(null);
                // username.value = "";
            }
            if (loadTimer != null) {
                loadTimer = null;
                clearTimeout("load()", 100);
            }
        }

        function getUpdate() {
            //request = new ActiveXObject("Microsoft.XMLHTTP");
            request =new XMLHttpRequest();
            request.onreadystatechange = stateChange;
            request.open("POST", "server.php", true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("datasize=" + datasize);
            
        }

        function stateChange() {
            // readyState 4: finish
            if (request.readyState == 4 && request.status == 200 && request.responseText) {
                var xmlDoc;
                try {
                    xmlDoc =new XMLHttpRequest();
                    xmlDoc.loadXML(request.responseText);
                } catch (e) {
                    var parser = new DOMParser();
                    xmlDoc = parser.parseFromString(request.responseText, "text/xml");
                }

                if (datasize != request.responseText.length){
                    updateChat(xmlDoc);
                }
                datasize = request.responseText.length;
                getUpdate();
            }
        }

        function updateChat(xmlDoc) {

            var node = document.getElementById("chattext");
            // remove all child
            while (node.hasChildNodes()) {
                node.removeChild(node.lastChild);
            }

            //point to the message nodes
            var messages = xmlDoc.getElementsByTagName("message");

            // create a string for the messages
            /* Add your code here */
            for (var i = 0; i < messages.length; i++){
                var nameStr = messages[i].getAttribute("name");
                var contentStr = messages[i].firstChild.nodeValue;
                showMessage(nameStr, contentStr, messages[i].getAttribute("color"));
            }
            lastMsgID = messages.length;

            var newHeight = ((lastMsgID + 1) * 20) + 35;
            if (newHeight < 340){
                newHeight = 340;
            }

            var svg_doc = document.getElementById("svg_doc");
            svg_doc.setAttribute("height", newHeight);
            var chatroom_bg = document.getElementById("chatroom_bg");
            chatroom_bg.setAttribute("height", newHeight);

            svg_docd.scrollTo(0, newHeight);
        }

        function showMessage(nameStr, contentStr, color) {
               
                var node = document.getElementById("chattext");
                // Create the name text span
                var nameNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

                // Set the attributes and create the text
                nameNode.setAttribute("x", 100);
                nameNode.setAttribute("dy", 20);
                nameNode.setAttribute("fill", color);
                nameNode.appendChild(document.createTextNode(nameStr));

                // Add the name to the text node
                node.appendChild(nameNode);

                // Create the score text span
                var contentNode = document.createElementNS("http://www.w3.org/2000/svg", "tspan");

                // Set the attributes and create the text
                contentNode.setAttribute("x", 200);
                contentNode.setAttribute("fill", color);
                // contentNode.appendChild(document.createTextNode(contentStr));
                var curr_index = 0;
                while (curr_index != -1){
                    var non_url_str = null;
                    var url_str = null;

                    var index_of_http = contentStr.indexOf("http://", curr_index);
                    if (index_of_http == -1){
                        non_url_str = contentStr.substring(curr_index);
                        curr_index = -1;
                    } else {
                        non_url_str = contentStr.substring(curr_index, index_of_http);
                        var index_of_space = contentStr.indexOf(" ", index_of_http);
                        if (index_of_space == -1){
                            url_str = contentStr.substring(index_of_http);
                        } else {
                            url_str = contentStr.substring(index_of_http, index_of_space);
                        }
                        curr_index = index_of_space;
                    }

                    if (non_url_str != null && non_url_str != ""){
                        contentNode.appendChild(document.createTextNode(non_url_str));
                    }

                    if (url_str != null && url_str != ""){
                        var link_node = document.createElementNS("http://www.w3.org/2000/svg", "a");
                        link_node.setAttributeNS("http://www.w3.org/1999/xlink", "xlink:href", url_str);
                        link_node.setAttribute("target", "_blank");
                        link_node.setAttribute("style", "cursor: pointer;text-decoration: underline");
                        link_node.appendChild(document.createTextNode(url_str));
                        contentNode.appendChild(link_node);
                    }
                }
                // Add the name to the text node
                node.appendChild(contentNode);
                
        }

        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()" onunload="unload()">

    <div id="svg_docd" style="overflow-y:scroll;height:340px;width:540px;overflow-x:hidden">
    <svg width="800px" height="340px" id="svg_doc" 
     xmlns="http://www.w3.org/2000/svg"
     xmlns:xhtml="http://www.w3.org/1999/xhtml"
     xmlns:xlink="http://www.w3.org/1999/xlink"
     xmlns:a="http://www.adobe.com/svg10-extensions" a:timeline="independent"
     >

        <g id="chatroom" style="visibility:hidden">                
        <rect id="chatroom_bg" width="520" height="340" style="fill:white;stroke:red;stroke-width:2"/>
        <text x="260" y="40" style="fill:red;font-size:30px;font-weight:bold;text-anchor:middle">Chat Window</text> 
        <text id="chattext" y="45" style="font-size: 20px;font-weight:bold"/>
      </g>
  </svg>
  
         <form action="">
            <input type="hidden" value="<?php print $name; ?>" id="username" />
        </form>
    </div>
    </body>
</html>
