<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Foundation\Transfer;

/**
 * Class ProduceTransfer
 */
final class ProducerTransfer
{
    /** @var string */
    private $topic;

    /**
     * @param string $topic
     */
    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }
}
