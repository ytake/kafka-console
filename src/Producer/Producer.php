<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Producer;

use Psr\Log\LoggerInterface;
use RdKafka\ProducerTopic;
use RdKafka\Producer as RdkafkaProducer;
use Ytake\KafkaConsole\Foundation\ConfigRepository;

/**
 * Class Producer
 */
class Producer
{
    /** @var RdkafkaProducer */
    protected $producer;

    /** @var string */
    protected $topic = 'default';

    /** @var null|LoggerInterface  for optional logger */
    protected $logger;

    /** @var ConfigRepository */
    protected $repository;

    /**
     * Producer constructor.
     *
     * @param ConfigRepository $repository
     */
    public function __construct(ConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $topic
     */
    public function topic(string $topic)
    {
        $this->topic = $topic;
    }

    /**
     * @param AbstractProduceDefinition $definition
     */
    public function produce(AbstractProduceDefinition $definition)
    {
        $kafkaTopic = $this->producerTopic();
        $kafkaTopic->produce(RD_KAFKA_PARTITION_UA, 0, $definition->payload());
        if ($this->logger instanceof LoggerInterface) {
            $this->logger->info($definition->payload());
        }
        $this->producer->poll(0);
    }

    /**
     * @return ProducerTopic
     */
    protected function producerTopic(): ProducerTopic
    {
        $configure = $this->repository->find($this->topic);
        $this->producer = $configure->producer();
        $this->producer->setLogLevel(LOG_DEBUG);
        $this->producer->addBrokers($configure->brokers());

        return $this->producer->newTopic($this->topic);
    }
}
