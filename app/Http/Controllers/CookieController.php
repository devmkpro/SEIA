<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    /**
     * Set Cookie in browser
     */
    public function setCookie($name, $value, $minutes = 60): void
    {
        Cookie::queue($name, $value, $minutes);
        return;
    }

    /**
     * Delete Cookie in browser
     */
    public function deleteCookie($name): void
    {
        Cookie::queue(Cookie::forget($name));
        return;
    }

}
