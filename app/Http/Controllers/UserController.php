<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Exists;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Types\Null_;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'sendResetLinkResponse', 'verify', 'sendResetResponse']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username'    => 'required',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $token_validity = (24 * 60);

        $this->guard()->factory()->setTTL($token_validity);

        if (!$token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    //
    public function profile_pic_upload(Request $request)
    {
        $rules = array(
            "image" => "required|mimes:jpg,bmp,png,jpeg|min:5",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $profile = $valid->validated()['image']->store('profile_pics');
            DB::table('profiles')
                ->where('user_id', $request->user()->id)
                ->update(['profile_pic' => $profile]);
            return response()->json(['message' => "Profile Updated"]);
        }
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out successfully']);
    }
    protected function sendResetLinkResponse(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if ($response == Password::RESET_LINK_SENT) {
            $message = "Mail send successfully";
        } else {
            $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data' => '', 'message' => $message];
        return response($response, 200);
    }
    protected function sendResetResponse(Request $request)
    {
        //password.reset
        $input = $request->only('email', 'token', 'password');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            //$user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        });
        if ($response == Password::PASSWORD_RESET) {
            $message = "Password reset successfully";
            $secuss = true;
        } else {
            $message = "Password reset Not successfully";
            $secuss = false;
        }
        $response = ['data' => '', 'message' => $message, "Secusss" => $secuss];
        return response()->json($response);
    }
    public function profile(Request $request)
    {
        $user = DB::table('users')
            ->where('id', $request->user()->id)
            ->select('id', 'username', 'email', 'role', 'email_verified_at')->get();
        $profile = DB::table('profiles')
            ->where('user_id', $request->user()->id)->get();
        return response()->json(["Errors" => "", "seccuss" => true, "User" => $user, "Profile" => $profile], 200);
    }
    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
    public function profile_update(Request $request)
    {
        $errors = [];
        $user = $request->user();
        $valid_phone = true;
        $profile = User::find($user['id'])->setProfiles;
        $users = User::find($user['id']);
        $rules = array(
            "name" => "nullable|min:5",
            "Description" => "nullable|min:30",
            "Type_of_Business" => "nullable|ends_with:Restaurant,Home-Based",
            "Phone" => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            "email" => "nullable|email",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            if ($valid->validated()['Phone'] != Null) {
                if (!is_numeric($valid->validated()['Phone'])) {
                    $errors = "Invalid Phone";
                    $valid_phone = false;
                }
            }
            try {
                $profile = User::find($user['id'])->setProfiles;
                $users = User::find($user['id']);
                DB::table('profiles')
                    ->where('user_id', $request->user()->id)
                    ->update([
                        'Description' => $valid->validated()['Description'] ?? $profile['Description'],
                        'name' => $valid->validated()['name'] ?? $profile['name'],
                        'Phone' => $valid->validated()['Phone'] ?? $profile['Phone'],
                        'Type_of_Business' => $valid->validated()['Type_of_Business'] ?? $profile['Type_of_Business'],
                    ]);
                DB::table('users')
                    ->where('id', $request->user()->id)
                    ->update(['email' => $valid->validated()['email'] ?? $users['email']]);
                return response()->json(['message' => "Profile Updated Secussfully", "errors" =>  $errors]);
            } catch (Exception $e) {
                return response()->json(['message' => "Error"], 302);
            }
        }
    }

    public function register(Request $request)
    {
        # code...
        $rules = array(
            "name" => "required",
            "username" => "required|unique:users,username",
            "password" => "required|min:6",
            'c_password' => 'required|same:password',
            "email" => "required|email|unique:users,email",
        );
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json(['error' => $valid->errors()], 401);
        } else {
            $user = User::create(
                array_merge(
                    $valid->validated(),
                    ['password' => bcrypt($request->password)]
                )
            )->sendEmailVerificationNotification();
            $user = User::where('username', $request->username)->get();
            foreach ($user  as $id) {
                $is_for = $id['id'];
                $profile = new Profile;
                $profile->name = $valid->validated()['name'];
                $profile->user_id = $is_for; //User::where('username', $request->username)->get()['id'];
                $profile->save();
                return response()->json(['message' => "Opration Secussfull", 'user' => $user]);
            }
        }
    }
    protected function guard()
    {
        return Auth::guard();
    }
    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token'          => $token,
                'token_type'     => 'bearer',
                'token_validity' => ($this->guard()->factory()->getTTL() * 60),
            ]
        );
    } //end respondWithToken()

}