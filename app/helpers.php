<?php

function watchersCount($id)
{
    $sessionId = session()->getId();
    $counterKey = "post-{$id}-counter";
    $usersKey = "post-{$id}-users";

    $users = Cache::get($usersKey, []);
    $usersUpdate = [];
    $difference = 0;
    $currentTime = now();

    collect($users)->each(function ($lastVisit, $session) use ($difference, $usersUpdate, $currentTime) {
        if ($currentTime->diffInMinutes($lastVisit) >= 1) {
            $difference--;
        } else {
            $usersUpdate[$session] = $lastVisit;
        }
    });

    if (!array_key_exists($sessionId, $users) || $currentTime->diffInMinutes($users[$sessionId]) >= 1) {
        $difference++;
    }

    $usersUpdate[$sessionId] = $currentTime;
    Cache::forever($usersKey, $usersUpdate);

    if (!Cache::has($counterKey)) {
        Cache::forever($counterKey, 1);
    } else {
        Cache::increment($counterKey, $difference);
    }

    return Cache::get($counterKey);
}
