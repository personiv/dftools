<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $primaryKey = 'credential_id';

    function functionName() {
        switch ($this->getAttribute("credential_type")) {
            case "DESGN": return "Web Designer";
            case "WML": return "Web Mods Line";
            case "VQA": return "Voice Quality Assurance";
            case "CUSTM": return "Senior Web Designer";
            case "PR": return "Website Proofreader";
            case "SPRVR": return "Supervisor";
            case "MANGR": return "Operation Manager";
            case "HEAD": return "Operation Head";
            case "ADMIN": return "Administrator";
            default: return "N/A";
        }
    }
}
