<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $primaryKey = 'tag_id';
    public static function EmployeeTypes() { return self::where("tag_type", "AGENT")->orWhere("tag_type", "LEADER")->orWhere("tag_type", "SYSTEM")->get(); }
    public static function AgentTypes() { return self::where("tag_type", "AGENT")->get(); }
    public static function LeaderTypes() { return self::where("tag_type", "LEADER")->get(); }
    public static function SessionTypes() { return self::where("tag_type", "SESSION")->get(); }

    function Name() { return $this->getAttribute("tag_name"); }
    function Type() { return $this->getAttribute("tag_type"); }
    function Description() { return $this->getAttribute("tag_desc"); }
}
