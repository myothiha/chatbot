<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FbUser extends Model
{
    protected $fillable = ['psid'];

    public function getNameAttribute()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function saveProfileData($profile)
    {
        $this->firstName    = $profile['first_name'];
        $this->lastName     = $profile['last_name'];
        $this->profilePic   = $profile['profile_pic'];
        $this->locale       = $profile['locale'];
        $this->timezone     = $profile['timezone'];
        $this->gender       = $profile['gender'];

        $this->save();
    }
}
