<?php

namespace App\Http\Controllers;

use App\UserData;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class UserDataController extends Controller
{
    /**
     * Update user details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apiUpdate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|max:60|min:1',
            'show_email' => 'required|boolean',
            'country' => 'required',
            'gender' => 'required|string|max:74|min:1',
            'date_of_birth' => 'required|date_format:Y-m-d|before:today',
        ]);

        $userData = UserData::where('user_id', '=', $request->user('api')->id)->first();

        if (Gate::allows('user-detail-update', $userData)) {
            $request->user('api')->email = $request->email;
            $userData->show_email = $request->show_email;
            $userData->country = $request->country;
            $userData->gender = $request->gender;
            $userData->date_of_birth = $request->date_of_birth;

            $request->user('api')->save();
            $userData->save();

            return response('Update Success', 202)
            ->header('Content-Type', 'text/plain');

        }else{
            return response('Access Denided', 401)
                ->header('Content-Type', 'text/plain');
        }
    }
}
