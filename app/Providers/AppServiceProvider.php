<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\NavAccess;
use App\Models\NavMain;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('*', function ($view)
        {
            if (Auth::check()) {
                $current_nav_main = NavMain::whereHas('navAccess' , function ($query) { $query->where('user_id', Auth::user()->employee_id)->where('tampil', 'y'); })->get();
                $current_menu = NavAccess::whereHas('navSub' , function ($query) { $query->where('link', '!=', '#'); })->where('user_id', Auth::user()->employee_id)->where('tampil', 'y')->get();
                $current_cart = Cart::where('shop_id', Auth::user()->employee->shop_id)->get();
                $count_cart = count($current_cart);


                //...with this variable
                $view->with('current_nav_mains', $current_nav_main);
                $view->with('current_menus', $current_menu);
                $view->with('current_carts', $count_cart);
            }else {
                $view->with('current_nav_mains', null);
                $view->with('current_menus', null);
                $view->with('current_carts', null);
            }
        });
    }
}
