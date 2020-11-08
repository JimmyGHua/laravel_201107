<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $successMessage = [
        "code" => 0,
        "Message" => "",
        "Result" => [
            "IsOK" => true,
        ]
    ];

    protected $errorMessage = [
        "code" => 0,
        "Message" => "error",
        "Result" => [
            "IsOK" => false,
        ]
    ];

    protected $invalidMessage = [
        "code" => 0,
        "Message" => "req invalid",
        "Result" => [
            "IsOK" => false,
        ]
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a new member created from post req
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $req)
    {
        try {
            // unique account
            $checkReq = $req->validate([
                'Account' => ['required', 'unique:user'],
                'Password' => ['required'],
            ]);

            // prevent adding increment id
            if ($checkReq) {
                $create = User::create([
                    'Account' => $req['Account'],
                    'Password' => $req['Password'],
                ]);
                if ($create) {
                    return response()->json($this->successMessage, 200);
                } else {
                    return response()->json($this->errorMessage, 400);
                }
            } else {
                return response()->json($this->invalidMessage, 400);
            }
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    /**
     * show a member
     * @param User $user
     * @return UserResource
     */
    public function show(Request $req)
    {

    }

    /**
     * Update the specified account's password from post req
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $req)
    {
        try {
            $checkReq = $req->validate([
                'Account' => ['required'],
                'Password' => ['required'],
            ]);

            if ($checkReq) {
                $accountRes = User::where('Account', '=', $req['Account'])->firstOrFail();

                $accountRes->update([
                    'Password' => $req['Password'],
                ]);
                return response()->json($this->successMessage, 200);
            } else {
                return response()->json($this->invalidMessage, 400);
            }

        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    /**
     * Delete a created member with Account from post req
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $req)
    {
        try {
            $checkReq = $req->validate([
                'Account' => ['required'],
            ]);

            if ($checkReq) {
                User::where('Account', '=', $req['Account'])->firstOrFail()->delete();

                return response()->json($this->successMessage, 200);
            } else {
                return response()->json($this->invalidMessage, 400);
            }
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    /**
     * Auth member with account and password from get req
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $req)
    {
        $authSuccessMessage = [
            "code" => 0,
            "Message" => "",
            "Result" => null,
        ];

        $authFailMessage = [
            "code" => "2",
            "Message" => "Login Failed",
            "Result" => null,
        ];

        try {
            $checkReq = $req->validate([
                'Account' => ['required'],
                'Password' => ['required'],
            ]);

            if ($checkReq) {
                $memberExist = User::where([
                    ['Account', '=', $req['Account']],
                    ['Password', '=', $req['Password']],
                ])->exists();

                if ($memberExist) {
                    return response()->json($authSuccessMessage, 200);
                } else {
                    return response()->json($authFailMessage, 400);
                }
            } else {
                return response()->json($this->invalidMessage, 400);
            }
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
