<?php

namespace App;

use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Exception;

class FbUser extends Model
{
    const TIMEOUT_TRUE = 1;
    const TIMEOUT_FALSE = 0;
    const TIMEOUT_DURATION_IN_MINUTES = 1;

    const CONVERSATION_SEEN = 1;
    const CONVERSATION_UNSEEN = 0;

    protected $dates = [
        'created_at',
        'updated_at',
        'active_at',
    ];

    protected $fillable = ['psid'];

    public function scopeNotSeen($query)
    {
        return $query->where('seen', self::CONVERSATION_UNSEEN);
    }

    public function scopeSeen($query)
    {
        return $query->where('seen', self::CONVERSATION_SEEN);
    }

    public function scopeActive($query)
    {
        return $query->where('timeout', self::TIMEOUT_FALSE);
    }

    public function isTimeout(): bool
    {
        return $this->active_at->diffInMinutes(now()) > self::TIMEOUT_DURATION_IN_MINUTES;
    }

    public function setTimeout($value)
    {
        $this->timeout = $value;
        $this->save();
    }

    public function getNameAttribute()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function saveProfileData($profile)
    {
        $this->firstName = $profile->first_name;
        $this->lastName = $profile->last_name;
        $this->profilePic = $profile->profile_pic;
        $this->locale = $profile->locale;
        $this->timezone = $profile->timezone;
        $this->gender = $profile->gender;

        $this->save();
    }

    public function conversationMode($mode)
    {
        $this->conversation = $mode;
        $this->save();
    }

    public function seenMode($mode)
    {
        $this->seen = $mode;
        $this->save();
    }

    public function isConversationOn()
    {
        return $this->conversation == ApiConstant::CONVERSATION_ON;
    }

    public function conversations()
    {
        return $this->hasMany('App\Conversation');
    }
}
