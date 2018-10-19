<?php
/**
 * Created by PhpStorm.
 * User: myothiha
 * Date: 10/17/2018
 * Time: 10:52 AM
 */

namespace App\Models\Messenger\Interfaces;


interface MessengerApiInterface
{
    function message($lang);
    function button($lang);
    function apiImageLarge();
    function apiImageSmall();
}
