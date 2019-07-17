<?php

namespace Squadron\FileUploads\Tests;

use Squadron\FileUploads\ServiceProvider;

class TestCase extends \Squadron\Tests\TestCase
{
    protected function getServiceProviders(): array
    {
        return [ServiceProvider::class];
    }
}
