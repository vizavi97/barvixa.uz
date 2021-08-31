<?php

use Illuminate\Support\Facades\Route;
use RainLab\User\Models\User as UserModel;
use Tim\Barviha\Models\Consumable;
use Tim\Barviha\Models\Hall;
use Tim\Barviha\Models\Place;
use Tim\Barviha\Models\Product;
use Tim\Barviha\Models\Request as AppRequest;
use Tim\Barviha\Models\ProductCategories;
use Tim\Barviha\Models\ProductConsumble;
use Tim\Barviha\Models\RequestProducts;
use Tim\Barviha\Models\RequestTypes;
use Tymon\JWTAuth\Facades\JWTAuth as JWT;
use Illuminate\Http\Request;
use Vdomah\JWTAuth\Models\Settings;
use Vdomah\Roles\Models\Role;

Route::group(['prefix' => 'api'], function () {

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

    Route::group(['prefix' => 'request'], function () {
        Route::get('/', function (Request $request) {
            $token = $request->header('Authorization');
            try {
                JWT::setToken($token); //<-- set token and check
                if (!$claim = JWT::getPayload()) {
                    return response()->json(array('message' => 'user_not_found'), 404);
                }

                $userData = JWT::toUser($token);
                $appRequests = AppRequest::with(['products','status', 'hall','place'])->where('waiter_id', $userData->id)->get();
                foreach ($appRequests as $ap) {
                    foreach ($ap->products as $product) {
                        $product->product = Product::with('preview_img')->find($product->product_id);
                    }
                }

                return response()->json($appRequests);

            } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(array('message' => 'token_expired'), 404);
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(array('message' => 'token_invalid'), 404);
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(array('message' => 'token_absent'), 404);
            }
        });
        Route::post('create', function (Request $request) {
            $data = $request->data;
            $place_id = $request->place_id;
            $hall_id = $request->hall_id;
            $user_token = $request->user_token;
            if(count($data) < 1) {
                return response()->json('error - empty data');
            }

            try {
                JWT::setToken($user_token); //<-- set token and check
                if (!JWT::getPayload()) {
                    return response()->json(array('message' => 'user_not_found'), 404);
                }
                $waiter = JWT::toUser($user_token);
                $status_id = RequestTypes::where('code', 'new')->pluck('id')->first();
                $amount = array_reduce($data, function($carry, $item) {
                    $carry += $item['count'] * $item['cost'];
                    return $carry;
                });
                $app = new AppRequest;
                $app->waiter_id = $waiter->id;
                $app->hall_id = $hall_id;
                $app->place_id = $place_id;
                $app->amount = $amount;
                $app->status_id = $status_id;

                $app->save();

                foreach ($data as $item) {
                    $product_cost = Product::where('id', $item['id'])->pluck('cost')->first();
                    $requestProduct = new RequestProducts;
                    $requestProduct->request_id = $app->id;
                    $requestProduct->product_id = $item['id'];
                    $requestProduct->count = $item['count'];
                    $requestProduct->total_value = $item['count'] * $product_cost;
                    $requestProduct->save();
                }

                return response()->json('success', 200);


            } catch (Exception $e) {

                return response()->json('error', 400);

            }
        });
    });
    Route::group(['prefix' => 'consumables'], function () {
        Route::get('/', function () {
            return response()->json(Consumable::all());
        });
        Route::get('/{id}', function ($id) {
            $product_id = $id;
            $resp = [];
            $pc = ProductConsumble::where('product_id', $product_id)->with('product', 'consumable')->get();
            if (count($pc) > 0) {
                foreach ($pc as $p) {
                    (object)$r = $p->consumable;
                    $r->count = $p->value;
                    array_push($resp, $r);
                }
            }
            return response()->json($resp);
        });
        Route::post('/create', function (Request $request) {
            $product = $request->product_id;
            $cons = $request->cons;
            if (count($cons) > 0) {
                foreach ($cons as $c) {
                    ProductConsumble::updateOrCreate(
                        ['product_id' => $product, "consumable_id" => $c['id']],
                        ['value' => (float)$c['count']]);
                }
            }
        });
        Route::delete('/delete', function (Request $request) {
            $product = $request->product_id;
            $cons = $request->cons;
            try {
                $pc = ProductConsumble::where('product_id', $product)->where('consumable_id', $cons)->firstOrFail();
                $pc->delete();
                return response()->json("deleted");

            } catch (Exception $e) {
                return response()->json("not found");
            }
        });
    });
});
