<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Store;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Initialize stores collection
        $stores = collect();

        if (isset($user->roles)) {
            if ($user->roles->contains(1)) {
                // If the user is an admin, fetch all active stores
                $stores = Store::where('status', true)->get();
            } else {
                // If the user is a store manager, fetch only their assigned stores
                $stores = $user->stores()->where('status', true)->get();
            }
        }

        // Set the session variable for selected_store_id if not already set
        if ($stores->isNotEmpty() && !session()->has('selected_store_id')) {
            session(['selected_store_id' => $stores[0]->id]); // You can modify this logic if necessary
        }
    }
}
