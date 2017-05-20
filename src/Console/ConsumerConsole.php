<?php
declare(strict_types=1);

namespace Ytake\KafkaConsole\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ytake\KafkaConsole\Consumer\Consumable;
use Ytake\KafkaConsole\Foundation\Transfer\ConsumerTransfer;
use Ytake\KafkaConsole\Usecase\MessageConsumeUsecase;

/**
 * Class ConsumerConsole
 */
class ConsumerConsole extends Command
{
    /** @var string  command name */
    protected $command = 'kafka:consume';

    /** @var string  command description */
    protected $description;

    /** @var MessageConsumeUsecase */
    protected $usecase;

    /**
     * ConsumerConsole constructor.
     *
     * @param MessageConsumeUsecase $usecase
     */
    public function __construct(MessageConsumeUsecase $usecase)
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
        $transfer = new ConsumerTransfer;
        $transfer->setTopic($input->getArgument('topic'));
        $transfer->setOffset($input->getArgument('offset'));
        $transfer->setPartition($input->getArgument('partition'));
        $this->usecase->execute(
            $transfer,
            new class implements Consumable
            {
                public function __invoke(\RdKafka\Message $message)
                {
                    var_dump(json_decode($message->payload));
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
        $this->addArgument('partition', InputArgument::OPTIONAL, 'topic partition', 0);
        $this->addArgument('offset', InputArgument::OPTIONAL, 'find offsets for partitions', RD_KAFKA_OFFSET_BEGINNING);
    }
}
