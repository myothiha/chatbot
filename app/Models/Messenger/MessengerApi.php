<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/17/2018
 * Time: 10:37 AM
 */

namespace App\Models\Messenger;

use App\Models\Base\BaseRepository;
use App\Models\Messenger\Interfaces\MessengerApiInterface;
use App\Services\Messenger\ApiConstant;
use Illuminate\Support\Collection;

abstract class MessengerApi extends BaseRepository
{

    public function transform(Collection $collection, $type, $lang = ApiConstant::ZAWGYI)
    {
        switch ($type) {
            case ApiConstant::TEXT :
                $function = "text";
                break;
            case ApiConstant::QUICK_REPLY :
                $function = "quickReply";
                break;
            case ApiConstant::BUTTON :
                $function = "button";
                break;
            case ApiConstant::IMAGE :
                $function = "image";
                break;
            case ApiConstant::GALLERY :
                $function = "gallery";
                break;
            default:
                $function = "text";
                break;
        }

        $response = $collection->map(function ($item, $index) use ($lang, $function) {

            return $this->$function($item, $lang);

        });

        return $response;
    }

    public function text(MessengerApiInterface $messengerApi, $lang)
    {
        return $messengerApi->message($lang);
    }

    public function quickReply(MessengerApiInterface $messengerApi, $lang)
    {
        return [
            "content_type"  => "text",
            "title"         => $messengerApi->message($lang),
            "payload"       => $messengerApi->id,
            "image_url"     => $messengerApi->apiImageSmall(),
        ];
    }

    public function postbackButton(MessengerApiInterface $messengerApi, $lang)
    {
        return [
            "type" => "postback",
            "title" => "English",
            "payload" => ApiConstant::ENGLISH,
        ];
    }

    public function image(MessengerApiInterface $messengerApi, $lang)
    {
        return $messengerApi->apiImageLarge();
    }

    public function gallery(MessengerApiInterface $messengerApi, $lang)
    {
        return [
            "title" => $messengerApi->message($lang),
            "image_url" => $messengerApi->apiImageSmall(),
            "subtitle" => "",
            "buttons" => [
                [
                    "type" => "postback",
                    "title" => $messengerApi->button($lang),
                    "payload" => $messengerApi->id,
                ]
            ]
        ];
    }
}
