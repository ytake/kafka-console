<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Foundation\Transfer;

/**
 * Class ConsumerTransfer
 */
final class ConsumerTransfer
{
    /** @var string */
    private $topic;

    /** @var int */
    private $partition;

    /** @var int */
    private $offset;

    /**
     * @param string $topic
     */
    public function setTopic(string $topic)
    {
        $this->topic = $topic;
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * @param int $partition
     */
    public function setPartition(int $partition)
    {
        $this->partition = $partition;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getPartition(): int
    {
        return $this->partition;
    }
}
