# PHP Kafka Console Application Example

*required ext-rdkafka*

use Symfony Console Component, Zend ServiceManager

## Application Factory Configuration

use factory.php (zendframework/zend-servicemanager)

```php
return [
    'factories'  => [
        \Ytake\KafkaConsole\Console\ProducerConsole::class       =>
            \Ytake\KafkaConsole\Console\ProducerConsoleFactory::class,
        \Ytake\KafkaConsole\Console\ConsumerConsole::class       =>
            \Ytake\KafkaConsole\Console\ConsumerConsoleFactory::class,
        \Ytake\KafkaConsole\Usecase\MessageProduceUsecase::class =>
            \Ytake\KafkaConsole\Usecase\MessageProduceUsecaseFactory::class,
        \Ytake\KafkaConsole\Usecase\MessageConsumeUsecase::class =>
            \Ytake\KafkaConsole\Usecase\MessageConsumeUsecaseFactory::class,
    ],
    'invokables' => [

    ],
    'aliases'    => [

    ],
];

```

## Kafka Configuration

use config.yaml

```yaml
kafka:
  topics:
    -  topic: message-topic
       brokers: 'localhost'
  producer:
    socket.blocking.max.ms: '1'
    queue.buffering.max.ms: '1'
    queue.buffering.max.messages: '1000'
    client.id: testingClient
  consumer:
    heartbeat.interval.ms: '10000'
    session.timeout.ms: '30000'
    topic.metadata.refresh.interval.ms: '60000'
    topic.metadata.refresh.sparse: 'true'
    log.connection.close: 'false'
    group.id: testingConsumer
```


## Usage

### kafka:produce 

```bash
$ php kafka-console kafka:produce message-topic hello
```

#### Arguments
 - topic: specified kafka topic
 - message: produce message
 
### kafka:consume 

```bash
$ php kafka-console kafka:consume message-topic
```

#### Arguments
 - topic: specified kafka topic
 - partition: topic partition [default: 0]
 - offset: find offsets for partitions [default: -2]

## Other

[Apache Kafka](https://kafka.apache.org/)

[ldaniels528/trifecta](https://github.com/ldaniels528/trifecta)
Trifecta is a web-based and CLI tool that simplifies inspecting Kafka messages and Zookeeper data

[yahoo/kafka-manager](https://github.com/yahoo/kafka-manager)
A tool for managing Apache Kafka.
