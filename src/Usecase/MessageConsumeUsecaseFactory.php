<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Usecase;

use Interop\Container\ContainerInterface;
use Ytake\KafkaConsole\Consumer\Consumer;
use Ytake\KafkaConsole\Foundation\ConfigRepository;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class MessageConsumeUsecaseFactory
 */
class MessageConsumeUsecaseFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $requestedName
     * @param array|null         $options
     *
     * @return MessageConsumeUsecase
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ): MessageConsumeUsecase {
        return new MessageConsumeUsecase(
            new Consumer(new ConfigRepository($container->get('config')))
        );
    }
}
