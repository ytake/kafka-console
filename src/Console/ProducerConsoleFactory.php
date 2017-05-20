<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Console;

use Interop\Container\ContainerInterface;
use Ytake\KafkaConsole\Usecase\MessageProduceUsecase;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ProducerConsole
 */
class ProducerConsoleFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface|ServiceManager $container
     * @param string                            $requestedName
     * @param array|null                        $options
     *
     * @return ProducerConsole
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ProducerConsole
    {
        return new ProducerConsole($container->get(MessageProduceUsecase::class));
    }
}
