<?php

namespace Fastwebmedia\AwsWorker\Integrations;

use Fastwebmedia\AwsWorker\Wrappers\DefaultWorker;
use Fastwebmedia\AwsWorker\Wrappers\Laravel53Worker;
use Fastwebmedia\AwsWorker\Wrappers\WorkerInterface;
use Fastwebmedia\PlainSqs\Sqs\Connector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\QueueManager;

/**
 * Class CustomQueueServiceProvider
 * @package App\Providers
 */
class LaravelServiceProvider extends ServiceProvider
{
    use BindsWorker, RegistersConfig;

    /**
     * @return void
     */
    public function register()
    {
        if (!config('aws-worker.register_worker_routes')) {
            return;
        }

        $this->bindWorker();
        $this->addRoutes();
    }

    /**
     * @return void
     */
    protected function addRoutes()
    {
        $this->app['router']->post('/worker/schedule', 'Fastwebmedia\AwsWorker\Controllers\WorkerController@schedule');
        $this->app['router']->post('/worker/queue', 'Fastwebmedia\AwsWorker\Controllers\WorkerController@queue');
    }

    /**
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerConfig();
        }

        $this->app->singleton(QueueManager::class, function () {
            return new QueueManager($this->app);
        });
    }
}
