<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Return a response to the user.
     */

    public function response(
        $request,
        $route,
        $message = null,
        $withMessage = 'message',
        $status = 200,
        $routeDataName = null,
        $routeData = null,
        $jsonResponse = false,
        $backRoute = false
    ): mixed {
        if ($request->bearerToken() || $jsonResponse) {
            return response()->json([
                'status' => $status,
                'message' => $message,
            ]);
        }

        if ($backRoute) {
            return redirect()->back()->with($withMessage, $message);
        }

        return redirect()->route($route, [$routeDataName => $routeData])->with($withMessage, $message);
    }
}
