<?php

namespace app\Core;

final class RateLimiter
{
    public static function init(): void
    {        
        if (!SessionManager::has('requestTimeline')) {
            SessionManager::set('requestTimeline', [time() => 'start']);
        }
    }

    public static function addToTimeline(Request $request): void
    {
        if ($request->getPath() == '/favicon.ico'){
            return;
        }

        $requestTimeline = SessionManager::get('requestTimeline');

        $requestTimeline[time()] = $request->getMethod() . $request->getPath();

        SessionManager::set('requestTimeline', $requestTimeline);
    }

    public static function checkIfRequestWasRunIn(int $seconds, Request $request): bool
    {
        $requestTimeline = SessionManager::get('requestTimeline');

        $reversedTimeline = array_reverse($requestTimeline, true);

        $key = array_search(
            $request->getMethod() . $request->getPath(),
            $reversedTimeline
        );

        if (!$key) {
            return false;
        }

        if ((time() - $seconds) > $key) {
            return false;
        }

        return true;
    }
}