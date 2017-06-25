<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}