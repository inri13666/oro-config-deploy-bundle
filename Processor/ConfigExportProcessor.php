<?php

namespace Oro\Bundle\ConfigDeployBundle\Processor;

use Oro\Bundle\ConfigBundle\Entity\ConfigValue;
use Oro\Bundle\ConfigDeployBundle\Event\ConfigDeployEvents;
use Oro\Bundle\ConfigDeployBundle\Event\ConfigValueExportEvent;
use Oro\Bundle\ConfigDeployBundle\Exception\UnsupportedValueException;
use Oro\Bundle\ConfigDeployBundle\Provider\ConfigValuesProvider;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ConfigExportProcessor implements LoggerAwareInterface
{
    /** @var ConfigValuesProvider */
    protected $configValuesProvider;

    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /** @var NullLogger */
    protected $logger;

    /**
     * @param ConfigValuesProvider $configValuesProvider
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ConfigValuesProvider $configValuesProvider, EventDispatcherInterface $dispatcher)
    {
        $this->configValuesProvider = $configValuesProvider;
        $this->dispatcher = $dispatcher;
        $this->logger = new NullLogger();
    }

    /**
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function process()
    {
        $values = $this->configValuesProvider->getValues();
        $data = [];
        /** @var ConfigValue $value */
        foreach ($values as $value) {
            $config = $value->getConfig();
            $event = new ConfigValueExportEvent($value);
            try {
                $this->dispatcher->dispatch(ConfigDeployEvents::EXPORT_EVENT, $event);
                $data[$config->getScopedEntity()][$value->getSection()][$value->getName()] = $event->getExportValue();
            } catch (UnsupportedValueException $e) {
                $this->logger->error($e->getMessage(), ['value' => $value]);
            }
        }

        return $data;
    }
}
