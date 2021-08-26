<?php

use Illuminate\Support\Facades\Route;
use RainLab\User\Models\User as UserModel;
use Tim\Barviha\Models\Consumable;
use Tim\Barviha\Models\ConsumablesCategories;
use Tim\Barviha\Models\Hall;
use Tim\Barviha\Models\Place;
use Tim\Barviha\Models\Product;
use Tim\Barviha\Models\ProductCategories;
use Tim\Barviha\Models\ProductConsumble;
use Tim\Vavilon\Classes\VavilonController;
use Tim\Vavilon\Models\Refs;
use Tymon\JWTAuth\Facades\JWTAuth as JWT;
use Illuminate\Http\Request;
use Vdomah\JWTAuth\Models\Settings;
use Vdomah\Roles\Models\Role;

Route::group(['prefix' => 'api'], function () {
    Route::post('barvixa', "\Tim\Barviha\Helpers\TelegramController@index");


    Route::post('login', function (Request $request) {
        if (Settings::get('is_login_disabled'))
            App::abort(404, 'Page not found');

        $login_fields = Settings::get('login_fields', ['email', 'password']);

        $credentials = Input::only($login_fields);

        try {
            // verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $userModel = JWTAuth::authenticate($token);

        if ($userModel->methodExists('getAuthApiSigninAttributes')) {
            $user = $userModel->getAuthApiSigninAttributes();
        } else {
            $user = [
                'id' => $userModel->id,
                'name' => $userModel->name,
                'surname' => $userModel->surname,
                'username' => $userModel->username,
                'email' => $userModel->email,
                'is_activated' => $userModel->is_activated,
                'phone' => $userModel->phone,
                "soc" => [
                    "soc_facebook" => $userModel->soc_facebook,
                    "soc_instagram" => $userModel->soc_instagram,
                    "soc_telegram" => $userModel->soc_telegram
                ]
            ];
        }
        // if no errors are encountered we can return a JWT
        return response()->json(compact('token', 'user'));
    });

    Route::post('refresh', function (Request $request) {
        if (Settings::get('is_refresh_disabled'))
            App::abort(404, 'Page not found');

        $token = Request::get('token');

        try {
            // attempt to refresh the JWT
            if (!$token = JWTAuth::refresh($token)) {
                return response()->json(['error' => 'could_not_refresh_token'], 401);
            }
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_refresh_token'], 500);
        }

        // if no errors are encountered we can return a new JWT
        return response()->json(compact('token'));
    });

    Route::post('invalidate', function (Request $request) {
        if (Settings::get('is_invalidate_disabled'))
            App::abort(404, 'Page not found');

        $token = Request::get('token');

        try {
            // invalidate the token
            JWTAuth::invalidate($token);
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_invalidate_token'], 500);
        }

        // if no errors we can return a message to indicate that the token was invalidated
        return response()->json('token_invalidated');
    });

    Route::post('signup', function (Request $request) {
        if (Settings::get('is_signup_disabled'))
            App::abort(404, 'Page not found');

        $login_fields = Settings::get('signup_fields', ['email', 'password', 'password_confirmation']);
        $credentials = Input::only($login_fields);

        try {
            $userModel = UserModel::create($credentials);

            if ($userModel->methodExists('getAuthApiSignupAttributes')) {
                $user = $userModel->getAuthApiSignupAttributes();
            } else {
                $user = [
                    'id' => $userModel->id,
                    'name' => $userModel->name,
                    'surname' => $userModel->surname,
                    'username' => $userModel->username,
                    'email' => $userModel->email,
                    'is_activated' => $userModel->is_activated,
                    'phone' => $userModel->phone,
                ];
            }
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage()], 401);
        }

        $token = JWTAuth::fromUser($userModel);

        return Response::json(compact('token', 'user'));
    });

    Route::get('profile', function (Request $request) {
        $token = $request->header('Authorization');
        try {
            JWT::setToken($token); //<-- set token and check
            if (!$claim = JWT::getPayload()) {
                return response()->json(array('message' => 'user_not_found'), 404);
            }

            $userData = JWT::toUser($token);
            $user = [
                'id' => $userData->id,
                'name' => $userData->name,
                'surname' => $userData->surname,
                'username' => $userData->username,
                'email' => $userData->email,
                'is_activated' => $userData->is_activated,
                'phone' => $userData->phone,
                "role" => Role::find($userData->vdomah_role_id)->first(['name', 'code'])
            ];
            return response()->json(["user" => $user]);

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(array('message' => 'token_expired'), 404);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(array('message' => 'token_invalid'), 404);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(array('message' => 'token_absent'), 404);
        }
    });

    Route::get('/info', function () {
        $halls = Hall::with('preview_img')->get();
        $places = Place::all()->groupBy('hall_id');
        $food = Product::with('preview_img')->get();
        $food_categories = ProductCategories::with('preview_img')->get();
        return response()->json(
            [
                "halls" => $halls,
                "places" => $places,
                "food" => $food,
                "food_categories" => $food_categories
            ]
        );
    });
    Route::get('/consumables', function () {
        return response()->json(Consumable::all());
    });
    Route::get('/price', function () {
        return response()->json('test');
    });
    Route::post('/consumables-creating', function(Request $request) {
        $product = $request->product_id;
        $cons = $request->cons;
        if(count($cons) > 0) {
            foreach ($cons as $c) {
                ProductConsumble::updateOrCreate(
                    ['product_id' => $product, "consumable_id" => $c['id']],
                    ['value' => (float)$c['count']]);
            }
        }
    });
});
