<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StepUser extends Model
{
    //It's necessary to specified the dabase table name when 
    //You change the name by Laravel defines by default
    protected $table = 'step_user';


    /**
     * One step belongs to a flow
    */
    public function steps() {
        return $this->hasMany('App\Step');
    }

    /**
     * One step belongs to a flow
    */
    public function users() {
        return $this->hasMany('App\Users');
    }
}
