<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    //
      protected $table = 'userlog';
        protected $fillable = [
        'oauth_token', 'login_date', 'is_loggedin','user_id',
    ];
}
