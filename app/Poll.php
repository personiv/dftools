<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $primaryKey = 'poll_id';
    static function Queue($sender, $receiver, $message) {
        $poll = new Poll;
        $poll->setAttribute("poll_sender", $sender);
        $poll->setAttribute("poll_receiver", $receiver);
        $poll->setAttribute("poll_message", $message);
        $poll->save();
    }
    static function Get($receiver) {
        $polls = array();
        $pollAvailable = self::where("poll_receiver", $receiver)->get();
        foreach ($pollAvailable as $poll) {
            array_push($polls, $poll);
        }
        return $polls;
    }

    function Sender() { return $this->getAttribute("poll_sender"); }
    function ReceiverID() { return $this->getAttribute("poll_receiver"); }
    function Message() { return $this->getAttribute("poll_message"); }
}
