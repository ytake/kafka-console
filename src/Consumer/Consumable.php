<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Consumer;

use RdKafka\Message;

/**
 * Interface Consumable
 */
interface Consumable
{
    /**
     * @param Message $message
     *
     * @return mixed
     */
    public function __invoke(Message $message);
}
