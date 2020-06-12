<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{   
    protected $primaryKey = ['id','flow_id'];
    /**
     * One step belongs to a flow
    */

    //Esto es necesario cuando un id no es de tipo int
    public $incrementing = false;
    //protected $primaryKey = ['id','flow_id'];

    public function flow() {
        return $this->belongsTo('App\Flow');
    }

    /**
     * The steps that belong to the step.
     */
    public function steps() {
        return $this->belongsToMany('App\Step','next_step_id','prev_flow_id','prev_step_id','next_flow_id');
    }


}
