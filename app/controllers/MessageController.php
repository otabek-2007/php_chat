<?php

namespace App\Controllers;

require_once __DIR__ . '/../../config/pusher.php';
require_once __DIR__ . '/../../config/db_params.php';
require_once __DIR__ . '/../models/Message.php';

use Exception;
use Message;
use Pusher\Pusher;

class MessageController
{
    public static function sendMessage($fromUserId, $toUserId, $messageText)
    {
        try {
            // Xabarni saqlash
            $message = new Message();
            $message->saveMessage($fromUserId, $toUserId, $messageText);

            // Pusher orqali xabarni yuborish
            $pusherConfig = require __DIR__ . '/../config/pusher.php';

            $pusher = new Pusher(
                $pusherConfig['app_key'],
                $pusherConfig['app_secret'],
                $pusherConfig['app_id'],
                [
                    'cluster' => $pusherConfig['app_cluster'],
                    'useTLS' => true,
                ]
            );

            $data = [
                'from_user_id' => $fromUserId,
                'to_user_id' => $toUserId,
                'message' => $messageText,
                'timestamp' => date('Y-m-d H:i:s'),
            ];

            // Pusher trigger qilish
            $pusher->trigger('user.' . $toUserId, 'message.sent', $data);

            // Success javobi qaytarish
            return json_encode(['status' => 'success', 'message' => 'Xabar yuborildi!']);
        } catch (Exception $e) {
            // Xato haqida javob qaytarish
            return json_encode(['status' => 'error', 'message' => 'Xabar yuborishda xato: ' . $e->getMessage()]);
        }
    }
}
