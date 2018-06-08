<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function saving(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function destroy(User $user, Reply $reply)
    {
//        if ($user->isAuthorOf($reply) || $reply->topic()->user_id == auth()->id()) {
            return true;
//        }
    }
}
