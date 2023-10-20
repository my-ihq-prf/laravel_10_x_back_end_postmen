<?php

namespace App\Providers;

use App\Actions\Models\UpdateArticle as UpdateArticleAction;
use App\Contracts\Actions\Models\UpdateArticle;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->updateArticleUsing(UpdateArticleAction::class);
        $this->camelizeItUsing();
    }

    /**
     * Register a class / callback that should be used to updateArticle.
     *
     * @param string $class
     * @return void
     */
    private function updateArticleUsing(string $class): void
    {
        app()->scoped(UpdateArticle::class, $class);
    }

    /**
     * Register a method / callback that should be used to camelizeIt.
     * @return void
     */
    private function camelizeItUsing(): void
    {
        app()->scoped('camelizeIt', function ($objIn) {
            return function (object|array $objIn) {
                $obj = [];
                foreach ($objIn as $key => $value) {
                    $obj[Str::camel($key)] = $value;
                }
                return is_array($objIn) ? $obj : (object)$obj;
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }


}
