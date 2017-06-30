<?php

namespace Oro\Bundle\ConfigDeployBundle\Command;

use Oro\Bundle\ConfigDeployBundle\Processor\ConfigExportProcessor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class ConfigExportCommand extends Command
{
    const NAME = 'oro:config:export';
    const INLINE_DEPTH = 13;

    /** @var ConfigExportProcessor */
    protected $exportProcessor;

    public function __construct(ConfigExportProcessor $exportProcessor)
    {
        parent::__construct(self::NAME);

        $this->exportProcessor = $exportProcessor;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName(self::NAME);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->exportProcessor->process();

        $output->write(Yaml::dump($data, self::INLINE_DEPTH), true);
    }
}
