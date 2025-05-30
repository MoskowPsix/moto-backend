<?php

namespace App\Providers;

use App\Actions\Controllers\Transaction\GetUserTransactionsAction;
use App\Contracts\Actions\Controllers\Transaction\GetUserTransactionsActionContract;
use App\Contracts\Services\PaymentServiceContract;
use App\Contracts\Services\PDFServiceContract;
use App\Contracts\Services\SecondCheckServiceContract;
use App\Models\FavoriteUser;
use App\Observers\FavoriteUserObserver;
use App\Repositories\Search\Track\TrackElasticRepository;
use App\Repositories\Search\Track\TrackElasticRepositoryInterface;
use App\Repositories\Search\Track\TrackEloquentRepository;
use App\Services\Payment\PaymentService;
use App\Services\Payment\SecondCheckService;
use App\Services\PDF\PDFService;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
//            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
//            $this->app->register(TelescopeServiceProvider::class);
//        }
        $this->app->bind(TrackElasticRepositoryInterface::class, function ($app) {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (! config('services.search.enabled')) {
                return new TrackEloquentRepository();
            }

            return new TrackElasticRepository(
                $app->make(Client::class)
            );
        });
        $this->bindSearchClient();
        $this->app->bind(PdfServiceContract::class, PdfService::class);
        $this->app->bind(PaymentServiceContract::class, PaymentService::class);
        $this->app->bind(SecondCheckServiceContract::class, SecondCheckService::class);
        $this->app->bind(GetUserTransactionsActionContract::class, GetUserTransactionsAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        FavoriteUser::observe(FavoriteUserObserver::class);
        JsonResource::withoutWrapping();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }
}
