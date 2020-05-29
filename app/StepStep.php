<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StepStep extends Model
{
    //It's necessary to specified the dabase table name when 
    //You change the name by Laravel defines by default:
    protected $table = 'step_step';
}
