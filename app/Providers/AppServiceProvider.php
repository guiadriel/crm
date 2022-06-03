<?php

namespace App\Providers;

use App\Helpers\OnlyNumbersOfString;
use App\Models\Status;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::directive('money', function ($expression) {
            return "<?php echo 'R$ ' . number_format({$expression}, 2); ?>";
        });

        Blade::directive('whatsapp', function ($expression) {
            return "<?php echo 'https://wa.me/' . preg_replace('/[^0-9]/', '', {$expression}); ?>";
        });

        Blade::directive('cpf', function ($expression) {
            return "<?php if ($expression) { echo substr($expression, 0, 3) . '.' . substr($expression, 3, 3) . '.' .substr($expression, 6, 3) . '-' . substr($expression, 9, 2); } ?>";
        });

        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

    }
}
