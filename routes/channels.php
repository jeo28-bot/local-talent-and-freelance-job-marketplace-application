<?php


Broadcast::channel('video-call.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
