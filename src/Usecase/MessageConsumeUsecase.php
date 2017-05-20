<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Usecase;

use Ytake\KafkaConsole\Consumer\Consumer;
use Ytake\KafkaConsole\Consumer\Consumable;
use Ytake\KafkaConsole\Foundation\Transfer\ConsumerTransfer;

/**
 * Class MessageConsumeUsecase
 */
class MessageConsumeUsecase
{
    /** @var Consumer */
    protected $consumer;

    /**
     * MessageConsumeUsecase constructor.
     *
     * @param Consumer $consumer
     */
    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * @param ConsumerTransfer $transfer
     * @param Consumable       $consumable
     */
    public function execute(ConsumerTransfer $transfer, Consumable $consumable)
    {
        $this->consumer->topic($transfer->getTopic());
        $this->consumer->partition($transfer->getPartition());
        $this->consumer->offset($transfer->getOffset());
        $this->consumer->handle($consumable);
    }
}
