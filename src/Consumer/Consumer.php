<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Consumer;

use RdKafka\Message;
use RdKafka\TopicConf;
use RdKafka\ConsumerTopic;
use Ytake\KafkaConsole\Foundation\ConfigRepository;

/**
 * Class Consumer
 */
class Consumer
{
    /** @var string */
    protected $topic;

    /** @var ConfigRepository */
    protected $repository;

    /** @var \RdKafka\Consumer */
    protected $consumer;

    /** @var int */
    protected $partition = 0;

    /** @var int */
    protected $offset = RD_KAFKA_OFFSET_BEGINNING;

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
     * @param int $partition
     */
    public function partition(int $partition)
    {
        $this->partition = $partition;
    }

    /**
     * @param int $offset
     */
    public function offset(int $offset)
    {
        $this->offset = $offset;
    }

    /**
     * @param Consumable $callable
     *
     * @throws \Exception
     */
    public function handle(Consumable $callable)
    {
        $topic = $this->consumerTopic();
        $topic->consumeStart($this->partition, $this->offset);
        while (true) {
            $message = $topic->consume($this->partition, 120 * 10000);
            if ($message instanceof Message) {
                switch ($message->err) {
                    case RD_KAFKA_RESP_ERR_NO_ERROR:
                        call_user_func($callable, $message);
                        break;
                    case RD_KAFKA_RESP_ERR__TIMED_OUT:
                        throw new \Exception("time out.");
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * @return ConsumerTopic
     */
    protected function consumerTopic(): ConsumerTopic
    {
        $configure = $this->repository->find($this->topic);
        $this->consumer = $configure->consumer();
        $this->consumer->addBrokers($configure->brokers());

        return $this->consumer->newTopic($this->topic, $this->topicConf());
    }

    /**
     * @return TopicConf
     */
    protected function topicConf(): TopicConf
    {
        $topicConf = new TopicConf();
        $topicConf->set('auto.commit.interval.ms', '100');
        $topicConf->set('offset.store.method', 'file');
        $topicConf->set('offset.store.path', sys_get_temp_dir());
        $topicConf->set('auto.offset.reset', 'smallest');

        return $topicConf;
    }
}
