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
     * Store a new created resource from req.
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $req)
    {
        try {
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Delete a created resource from req Account.
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
                $accountRes = User::where('Account', '=', $req['Account'])->firstOrFail()->delete();

                if ($accountRes) {
                    return response()->json($this->successMessage, 200);
                } else {
                    return response()->json($this->errorMessage, 400);
                }
            }
            else {
                return response()->json($this->invalidMessage, 400);
            }
        }
        catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }
}
