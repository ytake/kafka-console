<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Console;

use Interop\Container\ContainerInterface;
use Ytake\KafkaConsole\Usecase\MessageConsumeUsecase;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ConsumerConsoleFactory
 */
class ConsumerConsoleFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface|ServiceManager $container
     * @param string                            $requestedName
     * @param array|null                        $options
     *
     * @return ConsumerConsole
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): ConsumerConsole
    {
        return new ConsumerConsole($container->get(MessageConsumeUsecase::class));
    }
}
