<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Foundation;

/**
 * Class ConfigRepository
 */
class ConfigRepository
{
    /** @var array */
    protected $config;

    /**
     * ConfigFactory constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Generator
     */
    public function all(): \Generator
    {
        $serviceConfig = $this->config;
        foreach ($serviceConfig['kafka']['topics'] as $topic) {
            $kafkaConfig = new Configure($topic['brokers'], $topic['topic']);
            $kafkaConfig->producerConfigure($serviceConfig['kafka']['producer']);
            $kafkaConfig->consumerConfigure($serviceConfig['kafka']['consumer']);
            yield $kafkaConfig;
        }
    }

    /**
     * @param string $topic
     *
     * @return Configure
     */
    public function find(string $topic): Configure
    {
        /** @var Configure $item */
        foreach ($this->all() as $item) {
            if ($item->topic() === $topic) {
                return $item;
            }
        }

        return new Configure('');
    }
}
