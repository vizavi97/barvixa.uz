<?php
//
//
//use Illuminate\Support\Facades\Route;
//use RainLab\User\Models\User as UserModel;
//use Tim\Vavilon\Classes\VavilonController;
//use Tim\Vavilon\Models\Refs;
//use Tymon\JWTAuth\Facades\JWTAuth as JWT;
//use Illuminate\Http\Request;
//use Vdomah\JWTAuth\Models\Settings;
//
//use Tim\Vavilon\Models\Mining;
//use Tim\Vavilon\Models\Stacking;
//
//
//Route::group(['prefix' => 'api'], function () {
//    Route::get('mining', function () {
//        $mining = Mining::with('preview_img')->where('is_active', 1)->get();
//        return response()->json($mining);
//    });
//    Route::get('stacking', function () {
//        $stacking = Stacking::with('preview_img')->where('is_active', 1)->get();
//        return response()->json($stacking);
//    });
//
//    Route::post('login', function (Request $request) {
//        if (Settings::get('is_login_disabled'))
//            App::abort(404, 'Page not found');
//
//        $login_fields = Settings::get('login_fields', ['email', 'password']);
//
//        $credentials = Input::only($login_fields);
//
//        try {
//            // verify the credentials and create a token for the user
//            if (!$token = JWTAuth::attempt($credentials)) {
//                return response()->json(['error' => 'invalid_credentials'], 401);
//            }
//        } catch (JWTException $e) {
//            // something went wrong
//            return response()->json(['error' => 'could_not_create_token'], 500);
//        }
//
//        $userModel = JWTAuth::authenticate($token);
//
//        if ($userModel->methodExists('getAuthApiSigninAttributes')) {
//            $user = $userModel->getAuthApiSigninAttributes();
//        } else {
//            $user = [
//                'id' => $userModel->id,
//                'name' => $userModel->name,
//                'surname' => $userModel->surname,
//                'username' => $userModel->username,
//                'email' => $userModel->email,
//                'is_activated' => $userModel->is_activated,
//                'phone' => $userModel->phone,
//                "soc" => [
//                    "soc_facebook" => $userModel->soc_facebook,
//                    "soc_instagram" => $userModel->soc_instagram,
//                    "soc_telegram" => $userModel->soc_telegram
//                ]
//            ];
//        }
//        // if no errors are encountered we can return a JWT
//        return response()->json(compact('token', 'user'));
//    });
//
//    Route::post('refresh', function (Request $request) {
//        if (Settings::get('is_refresh_disabled'))
//            App::abort(404, 'Page not found');
//
//        $token = Request::get('token');
//
//        try {
//            // attempt to refresh the JWT
//            if (!$token = JWTAuth::refresh($token)) {
//                return response()->json(['error' => 'could_not_refresh_token'], 401);
//            }
//        } catch (Exception $e) {
//            // something went wrong
//            return response()->json(['error' => 'could_not_refresh_token'], 500);
//        }
//
//        // if no errors are encountered we can return a new JWT
//        return response()->json(compact('token'));
//    });
//
//    Route::post('invalidate', function (Request $request) {
//        if (Settings::get('is_invalidate_disabled'))
//            App::abort(404, 'Page not found');
//
//        $token = Request::get('token');
//
//        try {
//            // invalidate the token
//            JWTAuth::invalidate($token);
//        } catch (Exception $e) {
//            // something went wrong
//            return response()->json(['error' => 'could_not_invalidate_token'], 500);
//        }
//
//        // if no errors we can return a message to indicate that the token was invalidated
//        return response()->json('token_invalidated');
//    });
//
//    Route::post('signup', function (Request $request) {
//        if (Settings::get('is_signup_disabled'))
//            App::abort(404, 'Page not found');
//
//        $login_fields = Settings::get('signup_fields', ['email', 'password', 'password_confirmation']);
//        $credentials = Input::only($login_fields);
//
//        try {
//            $userModel = UserModel::create($credentials);
//
//            if ($userModel->methodExists('getAuthApiSignupAttributes')) {
//                $user = $userModel->getAuthApiSignupAttributes();
//            } else {
//                $user = [
//                    'id' => $userModel->id,
//                    'name' => $userModel->name,
//                    'surname' => $userModel->surname,
//                    'username' => $userModel->username,
//                    'email' => $userModel->email,
//                    'is_activated' => $userModel->is_activated,
//                    'phone' => $userModel->phone,
//                    "soc" => [
//                        "soc_facebook" => $userModel->soc_facebook,
//                        "soc_instagram" => $userModel->soc_instagram,
//                        "soc_telegram" => $userModel->soc_telegram
//                    ]
//                ];
//            }
//            if ($request->ref) {
//                $ref = new Refs;
//                $ref->user_id = $request->ref;
//                $ref->ref_id = $userModel->id;
//                $ref->save();
//            }
//        } catch (Exception $e) {
//            return Response::json(['error' => $e->getMessage()], 401);
//        }
//
//        $token = JWTAuth::fromUser($userModel);
//
//        return Response::json(compact('token', 'user'));
//    });
//
//    Route::get('profile', function (Request $request) {
//        $token = $request->header('Authorization');
//        try {
//            JWT::setToken($token); //<-- set token and check
//            if (!$claim = JWT::getPayload()) {
//                return response()->json(array('message' => 'user_not_found'), 404);
//            }
//
//            $userData = JWT::toUser($token);
//            $user = [
//                'id' => $userData->id,
//                'name' => $userData->name,
//                'surname' => $userData->surname,
//                'username' => $userData->username,
//                'email' => $userData->email,
//                'is_activated' => $userData->is_activated,
//                'phone' => $userData->phone,
//                "soc" => [
//                    "soc_facebook" => $userData->soc_facebook,
//                    "soc_instagram" => $userData->soc_instagram,
//                    "soc_telegram" => $userData->soc_telegram
//                ]
//            ];
//            return response()->json(["user" => $user]);
//
//        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
//            return response()->json(array('message' => 'token_expired'), 404);
//        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
//            return response()->json(array('message' => 'token_invalid'), 404);
//        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
//            return response()->json(array('message' => 'token_absent'), 404);
//        }
//    });
//
//    Route::get('register-ref', function (Request $request) {
//        $user = UserModel::where('id', $request->ref)->first();
//        $resp = [
//            "name" => $user->name,
//            "surname" => $user->surname
//        ];
//        return response()->json($resp);
//    });
//
//    Route::post('change-user-info', function (Request $request) {
//        $token = $request->header('Authorization');
//        try {
//            JWT::setToken($token); //<-- set token and check
//            if (!$claim = JWT::getPayload()) {
//                return response()->json(array('message' => 'user_not_found'), 404);
//            }
//
//            $userData = JWT::toUser($token);
//
//
//            $user = UserModel::find($userData->id);
//            $user->name = $request->name;
//            $user->email = $request->email;
//            $user->phone = $request->phone;
//            $user->soc_facebook = $request->facebook;
//            $user->soc_instagram = $request->instagram;
//            $user->soc_telegram = $request->telegram;
//            $user->save();
//
//            $response = [
//                'name' => $userData->name,
//                'surname' => $userData->surname,
//                'username' => $userData->username,
//                'email' => $userData->email,
//                'is_activated' => $userData->is_activated,
//                'phone' => $userData->phone,
//                "soc" => [
//                    "soc_facebook" => $userData->soc_facebook,
//                    "soc_instagram" => $userData->soc_instagram,
//                    "soc_telegram" => $userData->soc_telegram
//                ]
//            ];
//            return response()->json(["user" => $response]);
//
//        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
//            return response()->json(array('message' => 'token_expired'), 404);
//        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
//            return response()->json(array('message' => 'token_invalid'), 404);
//        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
//            return response()->json(array('message' => 'token_absent'), 404);
//        }
//    });
//
//    Route::get('contacts', "Tim\Vavilon\Classes\VavilonController@getContacts");
//});