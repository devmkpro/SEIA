<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CookieController extends Controller
{
    /**
     * Set Cookie in browser
     */
    public function setCookie($name, $value, $minutes = 60)
    {
        Cookie::queue($name, $value, $minutes);
        return;
    }

    /**
     * Delete Cookie in browser
     */
    public function deleteCookie($name)
    {
        Cookie::queue(Cookie::forget($name));
        return;
    }
}
