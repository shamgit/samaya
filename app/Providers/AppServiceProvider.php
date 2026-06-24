<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();

            /*
            |--------------------------------------------------------------------------
            | Super Admin
            |--------------------------------------------------------------------------
            */
            if ($user->role_id == 1) {

                $menus = DB::table('menus')
                    ->where('deleted', 0)
                    ->where('status', 1)
                    ->get();

            } else {

                /*
                |--------------------------------------------------------------------------
                | User Access Menus
                |--------------------------------------------------------------------------
                */

                $designation = DB::table('designations')
                    ->where('user_id', $user->id)
                    ->where('deleted', 0)
                    ->first();

                $access_menus_arr = array_filter(
                    explode(
                        ',',
                        str_replace('"', '', $designation->access_menus ?? '')
                    )
                );

                $menus = DB::table('menus')
                    ->whereIn('menu_id', $access_menus_arr)
                    ->where('deleted', 0)
                    ->where('status', 1)
                    ->get();
            }

            /*
            |--------------------------------------------------------------------------
            | Menu Groups
            |--------------------------------------------------------------------------
            */

            $menu_group_ids = $menus
                ->pluck('menu_group_id')
                ->unique()
                ->toArray();

            $menu_groups = DB::table('menu_groups')
                ->whereIn('menu_group_id', $menu_group_ids)
                ->where('deleted', 0)
                ->where('status', 1)
                ->get();

            foreach ($menu_groups as $group) {

                $group->menus = $menus
                    ->where('menu_group_id', $group->menu_group_id)
                    ->values();
            }

            $view->with([
                'menu_groups' => $menu_groups,
                'menus' => $menus,
            ]);
        });
    }
}