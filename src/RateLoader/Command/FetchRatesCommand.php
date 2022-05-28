<?php
declare(strict_types=1);

namespace Iamvar\Rates\RateLoader\Command;

use Iamvar\Rates\RateLoader\Service\RateLoader;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'iamvar:fetch-rates',
    description: 'Fetch rates from available sources'
)]
class FetchRatesCommand extends Command
{
    private RateLoader $ratesLoader;

    public function __construct(RateLoader $ratesLoader)
    {
        parent::__construct();
        $this->ratesLoader = $ratesLoader;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->ratesLoader->saveRates();

        return self::SUCCESS;
    }
}
