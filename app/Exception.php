<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    protected $primaryKey = 'exception_id';

    function Agent() { return self::where("exception_agent", $this->getAttribute("exception_agent"))->first(); }
}
