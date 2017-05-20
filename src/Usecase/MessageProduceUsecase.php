<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Usecase;

use Ytake\KafkaConsole\Foundation\Transfer\ProducerTransfer;
use Ytake\KafkaConsole\Producer\Producer;
use Ytake\KafkaConsole\Producer\AbstractProduceDefinition;

/**
 * Class MessageProduceUsecase
 */
class MessageProduceUsecase
{
    /** @var Producer */
    protected $producer;

    /**
     * MessageProduceUsecase constructor.
     *
     * @param Producer $producer
     */
    public function __construct(Producer $producer)
    {
        $this->producer = $producer;
    }

    /**
     * @param ProducerTransfer          $transfer
     * @param AbstractProduceDefinition $definition
     */
    public function execute(ProducerTransfer $transfer, AbstractProduceDefinition $definition)
    {
        $this->producer->topic($transfer->getTopic());
        $this->producer->produce($definition);
    }
}
