<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    protected $primaryKey = 'exception_id';

    function Agent() { return Credential::where("credential_user", $this->getAttribute("exception_agent"))->first(); }
    function AgentLeader() { return $this->Agent()->TeamLeader(); }
}
