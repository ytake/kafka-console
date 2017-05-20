<?php

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
