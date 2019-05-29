<?php

namespace Fastwebmedia\AwsWorker\Wrappers;

/**
 * Interface WorkerInterface
 * @package Fastwebmedia\AwsWorker\Wrappers
 */
interface WorkerInterface
{
    /**
     * @param $queue
     * @param $job
     * @param array $options
     * @return mixed
     */
    public function process($queue, $job, array $options);
}