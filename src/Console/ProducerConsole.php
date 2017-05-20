<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ytake\KafkaConsole\Foundation\Transfer\ProducerTransfer;
use Ytake\KafkaConsole\Usecase\MessageProduceUsecase;
use Ytake\KafkaConsole\Producer\AbstractProduceDefinition;

/**
 * Class ProducerConsole
 */
class ProducerConsole extends Command
{
    /** @var string  command name */
    protected $command = 'kafka:produce';

    /** @var string  command description */
    protected $description;

    /** @var MessageProduceUsecase */
    protected $usecase;

    /**
     * ProducerConsole constructor.
     *
     * @param MessageProduceUsecase $usecase
     */
    public function __construct(MessageProduceUsecase $usecase)
    {
        parent::__construct(null);
        $this->usecase = $usecase;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $transfer = new ProducerTransfer;
        $transfer->setTopic($input->getArgument('topic'));
        $this->usecase->execute(
            $transfer,
            new class($input->getArgument('message')) extends AbstractProduceDefinition
            {
                private $message;

                public function __construct(string $message)
                {
                    $this->message = $message;
                }

                public function message(): string
                {
                    return strval($this->message);
                }
            }
        );
    }

    /**
     * command interface configure
     */
    protected function configure()
    {
        $this->setName($this->command);
        $this->setDescription($this->description);
        $this->addArgument('topic', InputArgument::REQUIRED, 'specified kafka topic');
        $this->addArgument('message', InputArgument::REQUIRED, 'produce message');
    }
}
