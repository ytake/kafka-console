<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Foundation;

use Psr\Container\ContainerInterface;
use Ytake\KafkaConsole\Console\ConsumerConsole;
use Ytake\KafkaConsole\Console\ProducerConsole;
use Zend\ServiceManager\ServiceManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Application
 */
final class Application extends \Symfony\Component\Console\Application
{
    const APPLICATION_NAME    = 'kafka-console';
    const APPLICATION_VERSION = 'dev';

    /** @var ContainerInterface|ServiceManager */
    private $container;

    /** @var string[] */
    private $commands = [
        ProducerConsole::class,
        ConsumerConsole::class,
    ];

    /**
     * Application constructor.
     *
     * @param ContainerInterface|ServiceManager $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct(self::APPLICATION_NAME, self::APPLICATION_NAME);
        $this->container = $container;
    }

    /**
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     *
     * @return int
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->setAutoExit(false);

        foreach ($this->commands as $command) {
            $this->add($this->container->get($command));
        }

        return parent::run($input, $output);
    }
}
