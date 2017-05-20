<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Foundation;

use RdKafka\Conf;
use RdKafka\Producer;
use RdKafka\Consumer;

/**
 * Class Configure
 */
final class Configure
{
    /** @var string */
    private $brokers;

    /** @var string */
    private $topic;

    const DEFAULT_TOPIC = 'testing';

    /** @var array */
    private $producerConfigure = [
        'socket.blocking.max.ms'       => '1',
        'queue.buffering.max.ms'       => '1',
        'queue.buffering.max.messages' => '1000',
    ];

    /** @var array */
    private $consumerConfigure = [];

    /**
     * Connection constructor.
     *
     * @param string $brokers
     * @param string $topic
     */
    public function __construct($brokers, $topic = self::DEFAULT_TOPIC)
    {
        $this->brokers = $brokers;
        $this->topic = $topic;
    }

    /**
     * @return string
     */
    public function brokers()
    {
        return $this->brokers;
    }

    /**
     * @return string
     */
    public function topic()
    {
        return $this->topic;
    }

    /**
     * @return Producer
     */
    public function producer(): Producer
    {
        $conf = new Conf();
        foreach ($this->producerConfigure as $key => $item) {
            $conf->set($key, $item);
        }

        return new Producer($conf);
    }

    /**
     * @return Consumer
     */
    public function consumer(): Consumer
    {
        $conf = new Conf();
        foreach ($this->consumerConfigure as $key => $item) {
            $conf->set($key, $item);
        }

        return new Consumer($conf);
    }

    /**
     * @param array $attributes
     */
    public function producerConfigure(array $attributes)
    {
        $this->producerConfigure = array_merge($this->producerConfigure, $attributes);
    }

    /**
     * @param array $attributes
     */
    public function consumerConfigure(array $attributes)
    {
        $this->consumerConfigure = $attributes;
    }
}
