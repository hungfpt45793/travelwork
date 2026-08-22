<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 2/28/2019
 * Time: 2:27 PM
 */

namespace App\Http\Controllers\Admin;


use App\Entity\User;
use Illuminate\Support\Facades\Auth;

class SellersController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'sales');

            return $next($request);
        });


    }

    public function excellentSellers() {
        return view('sales.seller.excellent');
    }

}