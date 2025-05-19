<?php

namespace App\Providers;

use App\Models\Committee;
use App\Models\EventGallery;
use App\Models\Notice;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Register the 'member' middleware
        $router = app(Router::class);
        $router->aliasMiddleware('member', \App\Http\Middleware\MemberMiddleware::class);
        $router->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);

        View::composer('*', function ($view) {
            $getForProfile = Person::find(Auth::id());
            $countUser = NewUserCount();

            $inactive_committee  = Committee::where('isActive', '=', 0)
            ->orderBy('id', 'desc')
            ->get();

            // $notices_notify = Notice::all();
            $notices_notify = Notice::where('valid_till', '>', Carbon::now())
            ->get();


            $event_notify = EventGallery::where('reg_valid_date', '>', Carbon::now())
            ->get();
    
            $view->with([
                'getForProfile' => $getForProfile,
                'countUser' => $countUser,
                'inactive_committee' => $inactive_committee,
                'notices_notify' => $notices_notify,
                'event_notify' => $event_notify,
            ]);
        });
    }
}
