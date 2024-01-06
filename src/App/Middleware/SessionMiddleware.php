<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\SessionException;
use Framework\Contracts\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        //needs to be checked if there is some active session
        //if so throw an exception
        if (session_status() == PHP_SESSION_ACTIVE) {
            throw new SessionException("Session is already active");
        }

        //another check if data has been sent to the client
        //php send data in pieces, doesnt wait
        if (headers_sent($filename, $line)) {
            throw new SessionException("Headers already sent. Consider enabling output buffering. Line {$line}, file {$filename}.");
        }
        //start new session
        session_start();
        $next();
        //after next is called and response from controller is generated we dont need to have active session,
        //so close the session
        session_write_close();
    }
}