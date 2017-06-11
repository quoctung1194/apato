<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    /**
     * Change password function
     *
     * @param $request: request param
     */
    public function changePass(Request $request)
    {
        // get current user
        $user = \Auth::guard('api')->user();
        // get form data
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;

        $isMatch = \Hash::check($oldPassword, $user->password);

        if(!$isMatch) {
            return response()->json([
                'status' => false,
                'message' => Lang::get('main.user_notMatchOldPassword')
            ]);
        }

        // set new password
        $user->password = \Hash::make($newPassword);
        if($user->save()) {
            return response()->json([
                'status' => true,
                'message' => Lang::get('main.user_changePassSuccessful')
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => Lang::get('main.user_unsuccessful')
            ]);
        }
    }
}