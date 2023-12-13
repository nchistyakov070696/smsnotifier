<?php

namespace App\Tests;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $kernel = new Kernel('test', false);
        $kernel->boot();

        return new Application($kernel);
    }
}
