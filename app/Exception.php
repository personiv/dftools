<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exception extends Model
{
    protected $primaryKey = 'exception_id';
    static function IsExceptedThisWeek($agentID) { return self::where("exception_agent", $agentID)->where("exception_week", (int)date("W"))->first() != null; }

    function Agent() { return Credential::where("credential_user", $this->getAttribute("exception_agent"))->first(); }
    function AgentLeader() { return $this->Agent()->TeamLeader(); }
}
