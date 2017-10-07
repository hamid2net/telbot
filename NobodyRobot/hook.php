<?php
/**
 * README
 * This configuration file is intended to run the bot with the webhook method.
 * Uncommented parameters must be filled
 *
 * Please note that if you open this file with your browser you'll get the "Input is empty!" Exception.
 * This is a normal behaviour because this address has to be reached only by Telegram server.
 */
// Load composer
require __DIR__ . '/vendor/autoload.php';

// Add you bot's API key and name
$API_KEY = '357388466:AAEpqWvEp0K969Az35PoBHwJXVJFWuQwj4A';
$BOT_NAME = 'NobodyRobot';

//Debug
define('CHAT_ID','288889800');
define('TEXT','An Error Ocurred!');
// $data=['chat_id'=>CHAT_ID,'text'=>TEXT];
// $telegram = new Longman\TelegramBot\Telegram($API_KEY, $BOT_NAME);
// $result = Longman\TelegramBot\Request::sendMessage($data);

// Define a path for your custom commands
//$commands_path = __DIR__ . '/Commands/';

// Enter your MySQL database credentials
$mysql_credentials = [
   'host'     => '127.9.76.130:3306',
   'user'     => 'admingbtmjRd',
   'password' => 'bZMh_R7TvwY5',
   'database' => 'telegram',
];

//if is set 
if(isset($_GET['ref']) && $_GET['ref']=='CafePoemBot') die();

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($API_KEY, $BOT_NAME);

    // Error, Debug and Raw Update logging
    //Longman\TelegramBot\TelegramLog::initialize($your_external_monolog_instance);
    //Longman\TelegramBot\TelegramLog::initErrorLog($path . '/' . $BOT_NAME . '_error.log');
    //Longman\TelegramBot\TelegramLog::initDebugLog($path . '/' . $BOT_NAME . '_debug.log');
    //Longman\TelegramBot\TelegramLog::initUpdateLog($path . '/' . $BOT_NAME . '_update.log');

    // Enable MySQL
    //$telegram->enableMySql($mysql_credentials);

    // Enable MySQL with table prefix
    //$telegram->enableMySql($mysql_credentials, $BOT_NAME . '_');

    // Add an additional commands path
    //$telegram->addCommandsPath($commands_path);

    // Enable admin user(s)
    //$telegram->enableAdmin(your_telegram_id);
    //$telegram->enableAdmins([your_telegram_id, other_telegram_id]);

    // Add the channel you want to manage
    //$telegram->setCommandConfig('sendtochannel', ['your_channel' => '@type_here_your_channel']);

    // Here you can set some command specific parameters,
    // for example, google geocode/timezone api key for /date command:
    //$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);

    // Set custom Upload and Download path
    //$telegram->setDownloadPath('../Download');
    //$telegram->setUploadPath('../Upload');

    // Botan.io integration
    //$telegram->enableBotan('your_token');

    // Handle telegram webhook request
    // echo Longman\TelegramBot\Request::getMe().'</br>';
    // echo implode("|", Longman\TelegramBot\Request::generateGeneralFakeServerResponse()).'</br>';
    $telegram->handle();
    // echo $telegram->getCustomInput();
    $update=$telegram->getUpdate();
    $message=$update->getMessage();
    $chat_id=$update->getMessage()->getChat()->getId();
    //$result = Longman\TelegramBot\Request::sendMessage(['chat_id' => $chat_id, 'text' =>$telegram->getCustomInput()]);
    //$message=json_decode($telegram->getCustomInput(),true);
     //$message=$message['message'];
     //$message=$message->getType();
     //$result = Longman\TelegramBot\Request::send('sendMessage',$message);
    //$data=['chat_id'=>$chat_id,'text'=>$message->getType().'+C'];
    //$result = Longman\TelegramBot\Request::sendMessage($data);
// try{

    if(!empty($message->getReplyToMessage()))
    {
        $reply=$message->getReplyToMessage();
        // if(!empty($message->getText()) && $message->getText()=='ConvertToVideoNote')
        // {
        //     $data=['chat_id'=>$chat_id,'video_note'=>$message->getVideo()->getFileId(),'reply_markup'=>$force_reply];
        //     $result = Longman\TelegramBot\Request::sendVideoNote($data);
        //     die();
        // }
        if(!empty($message->getText())&&!empty($reply->getText()))
        {
            $text=$message->getText();
            $reply->setText($text);
            $message=$reply;
        }
        elseif (!empty($message->getText()))
        {
            $text=$message->getText();
            $reply->setCaption($text);
            $message=$reply;
        }

        // $reply->setCaption('From Code');
        // $data=['chat_id'=>$chat_id,'text'=>$reply->getCaption()];
        // $result = Longman\TelegramBot\Request::sendMessage($data);

        // $data=['chat_id'=>$chat_id,'text'=>implode('|', $reply)];
        // $result = Longman\TelegramBot\Request::sendMessage($data);
    }

    $force_reply=new Longman\TelegramBot\Entities\ForceReply();
     switch ($message->getType()) {
        case 'text':
            $data=['chat_id'=>$chat_id,'text'=>$message->getText(),'reply_markup'=>$force_reply];
            //echo implode('|', $data);
            $result = Longman\TelegramBot\Request::sendMessage($data);
            break;

        case 'photo':
            if(!empty($message->getCaption()))   
                $data=['chat_id'=>$chat_id,'photo'=>$message->getPhoto()[0]->getFileId(),'caption'=>$message->getCaption(),'reply_markup'=>$force_reply];
            else $data=['chat_id'=>$chat_id,'photo'=>$message->getPhoto()[0]->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendPhoto($data);
            //$data=['chat_id'=>$chat_id,'text'=>implode('|',$data),'reply_markup'=>$force_reply];
            //echo implode('|', $data);
            //$result = Longman\TelegramBot\Request::sendMessage($data);
            break;

        case 'audio':
            if(!empty($message->getCaption()))
                $data=['chat_id'=>$chat_id,'audio'=>$message->getAudio()->getFileId(),'caption'=>$message->getCaption(),'reply_markup'=>$force_reply];
            else $data=['chat_id'=>$chat_id,'audio'=>$message->getAudio()->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendAudio($data);
            break;

        case 'document':
            if(!empty($message->getCaption()))
                $data=['chat_id'=>$chat_id,'document'=>$message->getDocument()->getFileId(),'caption'=>$message->getCaption(),'reply_markup'=>$force_reply];
            else $data=['chat_id'=>$chat_id,'document'=>$message->getDocument()->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendDocument($data);
            break;

        case 'sticker':
            $data=['chat_id'=>$chat_id,'sticker'=>$message->getSticker()->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendSticker($data);
            break;

        case 'video':
            if(!empty($message->getCaption()))
                $data=['chat_id'=>$chat_id,'video'=>$message->getVideo()->getFileId(),'caption'=>$message->getCaption(),'reply_markup'=>$force_reply];
            else $data=['chat_id'=>$chat_id,'video'=>$message->getVideo()->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendVideo($data);
            break;

        case 'voice':
            if(!empty($message->getCaption()))
                $data=['chat_id'=>$chat_id,'voice'=>$message->getVoice()->getFileId(),'caption'=>$message->getCaption(),'reply_markup'=>$force_reply];
            else $data=['chat_id'=>$chat_id,'voice'=>$message->getVoice()->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendVoice($data);
            break;

        case 'location':
            $data=['chat_id'=>$chat_id,'latitude'=>$message->getLocation()->getLatitude(),'longitude'=>$message->getLocation()->getLongitude(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendLocation($data);
            break;

        case 'venue':
            $data=['chat_id'=>$chat_id,'latitude'=>$message->getVenue()->getLatitude(),'longitude'=>$message->getVenue()->getLongitude(),'title'=>$message->getVenue()->getTitle(),'address'=>$message->getVenue()->getAddress(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendVenue($data);
            break;

        case 'contact':
            $data=['chat_id'=>$chat_id,'phone_number'=>$message->getContact()->getPhoneNumber(),'first_name'=>$message->getContact()->getFirstName(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendContact($data);
            break;

        case 'video_note':
            if(!empty($message->getCaption()))
                $data=['chat_id'=>$chat_id,'video_note'=>$message->getVideoNote()->getFileId(),'caption'=>$message->getCaption(),'reply_markup'=>$force_reply];
            else 
            $data=['chat_id'=>$chat_id,'video_note'=>$message->getVideoNote()->getFileId(),'reply_markup'=>$force_reply];
            $result = Longman\TelegramBot\Request::sendVideoNote($data);
            // $data=['chat_id'=>$chat_id,'text'=>implode('|',$data),'reply_markup'=>$force_reply];
            // //echo implode('|', $data);
            // $result = Longman\TelegramBot\Request::sendMessage($data);
            break;
        
        default:
            $data=['chat_id'=>$chat_id,'text'=>$message->getType()];
            $result = Longman\TelegramBot\Request::sendMessage($data);
            break;
    }
// }catch(Exception $e)
// {
//     $data=['chat_id'=>$chat_id,'text'=>$e->getMessage()];
//     $result = Longman\TelegramBot\Request::sendMessage($data);
// }catch (Longman\TelegramBot\Exception\TelegramException $e)
// {
//     $data=['chat_id'=>$chat_id,'text'=>$e->getMessage()];
//     $result = Longman\TelegramBot\Request::sendMessage($data);
// }catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
//     $data=['chat_id'=>$chat_id,'text'=>$e->getMessage()];
//     $result = Longman\TelegramBot\Request::sendMessage($data);
// }finally {
//     $data=['chat_id'=>$chat_id,'text'=>'Finally'];
//     $result = Longman\TelegramBot\Request::sendMessage($data);
// }
// }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    $data=['chat_id'=>CHAT_ID,'text'=>$e];
    $result = Longman\TelegramBot\Request::sendMessage($data);
    // Silence is golden!
    echo $e;
    // Log telegram errors
    Longman\TelegramBot\TelegramLog::error($e);
} catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
    $data=['chat_id'=>CHAT_ID,'text'=>$e];
    $result = Longman\TelegramBot\Request::sendMessage($data);
    // Silence is golden!
    // Uncomment this to catch log initilization errors
    echo $e;
} catch (Exception $e) {
    $data=['chat_id'=>CHAT_ID,'text'=>$e];
    $result = Longman\TelegramBot\Request::sendMessage($data);
    // Silence is golden!
    // Uncomment this to catch log initilization errors
    echo $e;
}

