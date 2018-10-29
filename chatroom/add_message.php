<?php

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    return;
}

// get the name from cookie
$name = $_COOKIE["name"];

// get the message content
$message = $_POST["message"];
if (trim($message) == "") $message = "__EMPTY__";

require_once('xmlHandler.php');

// create the chatroom xml file handler
$xmlh = new xmlHandler("chatroom.xml");
if (!$xmlh->fileExist()) {
    header("Location: error.html");
    exit;
}

// create the following DOM tree structure for a message
// and add it to the chatroom XML file
//
// <message name="...">...</message>
//

/* Add your code here */
// open the existing XML file
$xmlh->openFile();

// get the 'users' element
$messages_element = $xmlh->getElement("messages");

// create a 'user' element
$message_element = $xmlh->addElement($messages_element, "message");

// add the user name
$xmlh->setAttribute($message_element, "name", $name);

$xmlh->setAttribute($message_element, "color", $_POST["color"]);


$xmlh->addText($message_element, $message);

// save the XML file
$xmlh->saveFile();

header("Location: client.php");

?>
