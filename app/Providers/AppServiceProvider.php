<?php

namespace App\Providers;

use App\AdminPhp\Modules\ArticleModule;
use App\AdminPhp\Modules\PageModule;
use App\AdminPhp\Settings\SiteSettings;
use App\View\Composers\SiteLayoutComposer;
use Gmarineau\AdminPhp\AdminPhp;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SiteLayoutComposer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $adminPhp = app(AdminPhp::class);

        $adminPhp->registerModules([ArticleModule::class, PageModule::class]);
        $adminPhp->registerSettings(SiteSettings::class);

        View::composer('components.layouts.site', SiteLayoutComposer::class);
    }
}
