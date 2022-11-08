<?php

namespace Salex\SMS\Models;

use Illuminate\Database\Eloquent\Model;
use Salex\SMS\Contracts\SMS as SMSContract;

class SMS extends Model implements SMSContract
{
    protected $fillable = ['response','text','to','sent','event_key','recipient_user_id'];
}
