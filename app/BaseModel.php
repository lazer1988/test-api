<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    // validation rules
    protected $rules = array();

    // validation errors
    private $errors;

    public function validate()
    {
        $data = $this->getAttributes();

        // make a new validator object
        $v = \Validator::make($data, $this->rules);

        // check for failure
        if ($v->fails())
        {
            // set errors and return false
            $this->errors = $v->messages();
            return false;
        }

        // validation pass
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}