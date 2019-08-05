<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/8/2018
 * Time: 4:30 PM
 */

namespace App\Services\Messenger;


class ApiConstant
{
    const BASE_URL = "https://graph.facebook.com";

    const MESSAGE = "/v2.6/me/messages";

    const CREATIVE = "/v2.11/me/message_creatives";

    const BROADCAST = "/v2.11/me/broadcast_messages";

    const ACCESS_TOKEN = "EAAC8bkI13yUBAHOPufOAIGHqRu9hXx7jjAnqXS1n0xX5fTpYxrHAeBmbcwOu16P7W0rGI97P1gKYh8GLvZBZCeQ7ZA8sB8RZCJ9ah3HY6rkvmVkeGW4Sz1yAukgGzZB1ZBEy3uj0uGTtBP5Wn7md00ZCJTXpeS0pU3tOb4xnYlvZCDaD0EWAZAWPy";

    const ZAWGYI = "zg";

    const MYANMAR3 = "mm3";

    const ENGLISH = "en";

    //API Template Types

    const TEXT = 1;
    const QUICK_REPLY = 2;
    const BUTTON = 3;
    const IMAGE = 4;
    const GALLERY = 5;

    const TYPES = [
        self::TEXT          => 'Text',
        self::QUICK_REPLY   => 'Quick Reply',
        self::BUTTON        => 'Button',
        self::IMAGE         => 'Image',
        self::GALLERY       => 'Gallery',
    ];

    const CONVERSATION_ON = 1;
    const CONVERSATION_OFF = 0;

    const SEEN = 1;
    const NOT_SEEN = 0;
}
