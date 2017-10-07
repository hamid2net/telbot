<html>
<head>
	<meta charset="utf-8">

</head>
<body dir="rtl">


	<?php

	include "farsi.php";


	$telegram = json_decode(
		file_get_contents("https://api.telegram.org/bot437724431:AAEkhUJtPLYSj2ZSI3IhMKlWupYcLR_Ss60/getMe")
		);

	if($telegram->ok == true){
		echo "<h1>$accOK</h1>";
    /* echo "<h1>اطلاعات ربات</h1>";
    echo "<b>نام کاربري </b>: ".$telegram->result->username;
    echo "<br/><b> نام ربات </b>: ".$telegram->result->first_name."<br/>";
	
    echo "<p>".var_dump($telegram->result,true)."</p>"; */
}else{
	echo "$accErr";
}

define('BOT_TOKEN', '437724431:AAEkhUJtPLYSj2ZSI3IhMKlWupYcLR_Ss60');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

// read incoming info and grab the chatID
$content = file_get_contents("php://input");
$update = json_decode($content, true);
$chatID = $update["message"]["chat"]["id"];
$msgID = $update["message"]["message_id"];

if( isset( $update["message"]["sticker"] ) && isset($update["message"]["reply_to_message"] )){
	$txt=$stickRules;
	$reply =  $txt;
	$sendto =API_URL."sendmessage?chat_id=".$chatID."&reply_to_message_id=".$msgID."&text=".$reply;
	file_get_contents($sendto);
}

if( isset( $update["message"]["new_chat_participant"] ) ){
	sendReply($chatID,$wlc2Grp,$msgID);
	$userID=$update["message"]["new_chat_participant"]["id"];
	sendMessage($userID,$pvRules);
	
}

if( isset( $update["message"]["text"]) ){

	if(array_search($update["message"]["text"],$ruleCmd)!==FALSE)
	{
		sendMessage($chatID,$gRules);
	}
}

if( isset( $update["message"]["chat"]["type"] ) && isset( $update["message"]["text"]) ){

	if($update["message"]["chat"]["type"]=="private" && $update["message"]["text"]=="/start")
	{
		sendMessage($chatID,$comRules);
	}
}

function sendMessage($id,$txt)
{
	$sendto =API_URL."sendmessage?chat_id=".$id."&text=".$txt;
	file_get_contents($sendto);
}

function sendReply($id,$txt,$msgID)
{
	$sendto =API_URL."sendmessage?chat_id=".$id."&reply_to_message_id=".$msgID."&text=".$txt;
	file_get_contents($sendto);
}


//Keep other robot alive
$CafePoemBot=file_get_contents("http://telegram-hrahimi.rhcloud.com/NobodyRobot/hook.php?ref=CafePoemBot");

?>

</body>
</html>