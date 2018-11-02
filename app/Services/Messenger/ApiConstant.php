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

    const ACCESS_TOKEN = "EAAC8bkI13yUBAO92eHRVhtZAqbP6yWUbh6dW06TFSVlwo8372kPYZBYgNullVNdgXe2uWlkZCGqDZBwGeBN9VYR5IvkESvQenkHj8Hy8u9C9ZB977vZAcBm6dooygFyDy1BJpf6yiUlLskzEVBDNcZBWCZCL7y2dEZAdNuJKL1GN3z6bSTZCOqcNg7";

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
