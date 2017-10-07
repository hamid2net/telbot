<?php
// Load composer
require __DIR__ . '/vendor/autoload.php';

$API_KEY = '357388466:AAEpqWvEp0K969Az35PoBHwJXVJFWuQwj4A';
$BOT_NAME = 'NobodyRobot';
$hook_url = 'https://telegram-hrahimi.rhcloud.com/NobodyRobot/hook.php';
try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($API_KEY, $BOT_NAME);

    // Set webhook
    $result = $telegram->setWebHook($hook_url);

    // Uncomment to use certificate
    //$result = $telegram->setWebHook($hook_url, $path_certificate);

    if ($result->isOk()) {
        echo $result->getDescription();
    }
} catch (Longman\TelegramBot\Exception\TelegramException $e) {
    echo $e;
}
