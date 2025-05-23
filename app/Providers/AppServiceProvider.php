<?php

namespace App\Providers;

use App\Http\Controllers\Api\WeeklyController;
use App\Repositories\Eloquent\AuthRepository;
use App\Repositories\Eloquent\SemesterGoalRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\ClassRepository;
use App\Repositories\Eloquent\SemesterRepository;
use App\Repositories\Eloquent\SelfStudyPlanRepository;
use App\Repositories\Eloquent\WeeklyRepository;
use App\Repositories\Interfaces\IWeeklyRepository;
use App\Repositories\Interfaces\IClassRepository;
use App\Repositories\Interfaces\ISemesterGoalRepository;
use App\Repositories\Interfaces\ISemesterRepository;
use App\Repositories\Interfaces\IAuthRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\ISelfStudyPlanRepository;
use App\Repositories\Eloquent\HelpRequestRepository;
use App\Repositories\Interfaces\IHelpRequestRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IClassRepository::class, ClassRepository::class);
        $this->app->bind(ISemesterRepository::class, SemesterRepository::class);
        $this->app->bind(ISelfStudyPlanRepository::class, SelfStudyPlanRepository::class);
        $this->app->bind(ISemesterGoalRepository::class, SemesterGoalRepository::class);
        $this->app->bind(IWeeklyRepository::class, WeeklyRepository::class);
        $this->app->bind(IHelpRequestRepository::class,HelpRequestRepository::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
