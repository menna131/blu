<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\TwoNumbsRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function twoNumbs(Request $request)
    {
        // if it is a POST request
            // $validator = Validator::make($request->all(),
            // [
            //     'number_one' => 'required|lt:number_two',
            //     'number_two' => 'required|gt:number_one',
            // ]);
            // if ($validator->fails())
            // {
            //     return [
            //         'success' => 0,
            //         'message' => $validator->errors()
            //     ];
            // }
            // $fNum = $request->all()['number_one'];
            // $sNum = $request->all()['number_two'];

        // if it is a GET request
            $fNum = $request->get('number_one');
            $sNum = $request->get('number_two');
            $inputs = ['number_one'=>$fNum, 'number_two'=>$sNum];
            $validator = Validator::make($inputs,
            [
                'number_one' => 'required|lt:number_two',
                'number_two' => 'required|gt:number_one',
            ]);
            if ($validator->fails())
            {
                return [
                    'success' => 0,
                    'message' => $validator->errors()
                ];
            }
        $result = [];
        $range = range($fNum, $sNum);
        foreach ($range as $elem) {
            if(!str_contains(strval($elem),"5")){
                array_push($result,$elem);
            }
        }
        dd($result);
    }

    public function letters(Request $request)
    {
        // if it is a POST
            // $validator = Validator::make($request->all(),
            // [
            //     'string' => 'required',
            // ]);
            // if ($validator->fails())
            // {
            //     return [
            //         'success' => 0,
            //         'message' => $validator->errors()
            //     ];
            // }
        // if it is a GET request
            $string = $request->get('string');
            $inputs = ['string'=>$string];
            $validator = Validator::make($inputs,
            [
                'string' => 'required',
            ]);
            if ($validator->fails())
            {
                return [
                    'success' => 0,
                    'message' => $validator->errors()
                ];
            }
        $string = $request->all()['string'];
        $letters = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U", "V", "W","X","Y","Z"];
        $result = 0;
        $j=0;
        for ($i=(strlen($string)-1); $i >= 0 ; $i--) {
            $result += (array_search($string[$i], $letters) +1) * (pow(26,$j));
            $j++;
        }
        dd($result);
    }

    public function toZero(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'array' => 'required|array',
            'length' => 'required|integer'
        ]);
        if ($validator->fails())
        {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        }
        $array = $request->all()['array'];
        $length = $request->all()['length'];
        $result = [];
        for ($i=0; $i < count($array) ; $i++) {
            $count=0;
            while($array[$i] > 0){
                if($array[$i] % 2 == 0){
                    $array[$i] = $array[$i] /2;
                }else{
                    $array[$i] = $array[$i] -1;
                }
                $count++;
            }
            array_push($result, $count);
        }
        dd($result);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'email' => 'required|email|unique:users,email',//|unique:users,email
            'userName' => 'required|string',
            'dateOfBirth' => 'required|date|regex:/\d{1,2}\/\d{1,2}\/\d{4}/|before:today',
            'phoneNumber' => 'required|regex:/(01)[0-9]{9}/',
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()]
        ]);
        if ($validator->fails())
        {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        }
        // create the user
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        // dd($input['password']);
        try {
            // DB::table('users')->insert($input);
            User::create($input);
            $user = DB::table('users')->orderByDesc('created_at', 'desc')->first();
            return response(['message'=>"user is added successfully", "user"=>$user], 201);
        } catch (\Throwable $e) {
            echo($e);
        }
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token =  $user->createToken('MyApp')->accessToken;
            $response = [
                'user'    => $user,
                'token' => $token,
            ];
            return response()->json($response, 200);
        }
        else{
            $response = [
                'message' => "Unauthorized login",
            ];
            return response()->json($response, 403);
        }
    }

    public function showUser($id) // id
    {
        if(!is_numeric($id)){
            $response = [
                'message' => "user id should be integer",
            ];
            return response()->json($response);
        }
        try {
            $user = User::find($id);
            if($user){
                $response = [
                    'user'    => $user
                ];
                return response()->json($response);
            }else{
                $response = [
                    'message' => "user not found",
                ];
                return response()->json($response);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $response = [
                'message' => "something went wrong",
                'error' => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }

    public function getUsers() // all
    {
        try {
            $users = User::get();
            $response = [
                'user'    => $users
            ];
            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response = [
                'message' => "something went wrong",
                'error' => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }


    public function updateUser(Request $request, $id)
    {
        if(!is_numeric($id)){
            $response = [
                'message' => "user id should be integer",
            ];
            return response()->json($response);
        }
        $validator = Validator::make($request->all(),
        [
            'email' => 'email|unique:users,email',
            'userName' => 'string',
            'dateOfBirth' => 'date|regex:/\d{1,2}\/\d{1,2}\/\d{4}/|before:today',
            'phoneNumber' => 'regex:/(01)[0-9]{9}/',
            'password' => [Password::min(8)->mixedCase()->letters()->numbers()->symbols()]
        ]);
        if ($validator->fails())
        {
            return [
                'success' => 0,
                'message' => $validator->errors()
            ];
        }
        try {
            User::where('id', $id)->update($request->only('email', 'userName', 'dateOfBirth', 'phoneNumber', 'password'));
            $user = DB::table('users')->orderByDesc('updated_at', 'desc')->first();
            $response = [
                'message' => 'user is successfully updated',
                'user'    => $user,
            ];
            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response = [
                'message' => "something went wrong",
                'error' => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }


    public function deleteUser($id)
    {
        if(!is_numeric($id)){
            $response = [
                'message' => "user id should be integer",
            ];
            return response()->json($response);
        }
        try {
            User::where('id', $id)->delete();
            $response = [
                'message' => 'user is successfully deleted',
            ];
            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response = [
                'message' => "something went wrong",
                'error' => $e->getMessage(),
            ];
            return response()->json($response);
        }
    }
}
