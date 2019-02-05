<?php

namespace App;

use App\Services\Messenger\ApiConstant;
use App\Services\Messenger\ChatBot;
use Illuminate\Database\Eloquent\Model;

class FbUser extends Model
{

    const TIMEOUT_TRUE = 0;
    const TIMEOUT_FALSE = 0;
    const TIMEOUT_DURATION_IN_MINUTES = 3;

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

    public function isTimeout() : bool
    {
        return $this->active_at->diffInMinutes(now()) > self::TIMEOUT_DURATION_IN_MINUTES;
    }

    public function getNameAttribute()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function getProfilePicAttribute($value)
    {
        $lastUpdate = $this->updated_at->diff(now())->days;

        if ($lastUpdate > 15)
        {
            $chatbot = new ChatBot();
            $chatbot->setFbUser($this);
            $chatbot->getProfile();
        }

        return $value;
    }

    public function saveProfileData($profile)
    {
        $this->firstName = $profile->first_name;
        $this->lastName = $profile->last_name;
        $this->profilePic = $profile->profile_pic;
        $this->locale = $profile->locale ?? '';
        $this->timezone = $profile->timezone ?? '';
        $this->gender = $profile->gender ?? '';

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
