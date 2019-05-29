<?php

namespace Fastwebmedia\AwsWorker\Integrations;

use Fastwebmedia\AwsWorker\Wrappers\WorkerInterface;
use Fastwebmedia\AwsWorker\Wrappers\DefaultWorker;
use Fastwebmedia\AwsWorker\Wrappers\Laravel53Worker;

/**
 * Class BindsWorker
 * @package Fastwebmedia\AwsWorker\Integrations
 */
trait BindsWorker
{
    /**
     * @var array
     */
    protected $workerImplementations = [
        '5\.[345678]\.\d+' => Laravel53Worker::class
    ];

    /**
     * @param $version
     * @return mixed
     */
    protected function findWorkerClass($version)
    {
        foreach ($this->workerImplementations as $regexp => $class) {
            if (preg_match('/' . $regexp . '/', $version)) return $class;
        }

        return DefaultWorker::class;
    }

    /**
     * @return void
     */
    protected function bindWorker()
    {
        $this->app->bind(WorkerInterface::class, $this->findWorkerClass($this->app->version()));
    }
}
