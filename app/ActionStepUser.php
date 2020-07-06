<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionStepUser extends Model
{
    //It's necessary to specified the dabase table name when 
    //You change the name by Laravel defines by default
    protected $table = 'action_step_user';

//   public function stepUsers() {
 //       return $this->hasMany('App\StepUser');
  //  }

    public function action() {
        return $this->belongsTo('App\Action');
    }

    public function user() {
        return $this->belongsTo('App\User','username');
    }
}
