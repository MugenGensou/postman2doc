<?php

namespace App\Providers;


use App\Writer\Docx;
use App\Writer\Html;
use App\Writer\Markdown;
use Parsedown;
use Illuminate\Support\ServiceProvider;
use Overtrue\Pinyin\Pinyin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('markdown', Markdown::class);

        $this->app->singleton('html', Html::class);

        $this->app->singleton('docx', Docx::class);

        $this->app->singleton('parsedown', Parsedown::class);

        $this->app->singleton('pinyin', Pinyin::class);
    }
}
