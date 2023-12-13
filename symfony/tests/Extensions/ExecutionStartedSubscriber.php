<?php

declare(strict_types=1);

namespace App\Tests\Extensions;


use App\Tests\CreatesApplication;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Event\TestRunner\Started;
use PHPUnit\Event\TestRunner\StartedSubscriber as StartedSubscriberInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;


final class ExecutionStartedSubscriber implements StartedSubscriberInterface
{
    use CreatesApplication;

    #[NoReturn]
    public function notify(Started $event): void
    {
        $application = $this->createApplication();

        print_r("Execute on Start Event\n");

        $output = new ConsoleOutput();

        $input = new ArrayInput([
            'command' => 'doctrine:database:drop',
            '--force' => true,
        ]);
        $application->doRun($input, $output);

        $input = new ArrayInput([
            'command' => 'doctrine:database:create',
        ]);
        $application->doRun($input, $output);

        $input = new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
        ]);
        $input->setInteractive(false);
        $application->doRun($input, $output);

        $input = new ArrayInput([
            'command' => 'doctrine:fixtures:load',
        ]);
        $input->setInteractive(false);
        $application->doRun($input, $output);

        print_r("Executing tests...\n");
    }
}
