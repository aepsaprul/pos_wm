<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\NavAccess;
use App\Models\NavMain;
use App\Models\Notif;
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

                if (Auth::user()->employee != null) {
                    $current_cart = Cart::where('shop_id', Auth::user()->employee->shop_id)->get();
                    $count_cart = count($current_cart);

                    // notification
                    if (Auth::user()->employee->shop->category == "gudang") {
                        $current_notif = Notif::where('status', 'start')
                            ->get();
                        $count_notif = count($current_notif);

                        $current_notif_transaction = Notif::where('title', 'transaction')
                            ->where('status', 'start')
                            ->get();
                        $count_notif_transaction = count($current_notif_transaction);
                    } else {
                        $current_notif = Notif::where('shop_id', Auth::user()->employee->shop_id)
                            ->where('status', 'start')
                            ->get();
                        $count_notif = count($current_notif);

                        $current_notif_transaction = Notif::where('title', 'transaction')
                            ->where('shop_id', Auth::user()->employee->shop_id)
                            ->where('status', 'start')
                            ->get();
                        $count_notif_transaction = count($current_notif_transaction);
                    }


                } else {
                    $current_cart = null;
                    $count_cart = null;
                    $current_notif = null;
                    $count_notif = null;
                    $current_notif_transaction = null;
                    $count_notif_transaction = null;
                }



                //...with this variable
                $view->with('current_nav_mains', $current_nav_main);
                $view->with('current_menus', $current_menu);
                $view->with('current_carts', $current_cart);
                $view->with('current_count_carts', $count_cart);
                $view->with('current_notifs', $current_notif);
                $view->with('current_count_notifs', $count_notif);
                $view->with('current_notif_transactions', $current_notif_transaction);
                $view->with('current_count_notif_transactions', $count_notif_transaction);
            }else {
                $view->with('current_nav_mains', null);
                $view->with('current_menus', null);
                $view->with('current_carts', null);
                $view->with('current_count_carts', null);
                $view->with('current_notifs', null);
                $view->with('current_coun_notifs', null);
                $view->with('current_notif_transactions', null);
                $view->with('current_count_notif_transactions', null);
            }
        });
    }
}
