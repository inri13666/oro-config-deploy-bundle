<?php

namespace Oro\Bundle\ConfigDeployBundle\Subscriber;

use Oro\Bundle\ConfigDeployBundle\Event\ConfigDeployEvents;
use Oro\Bundle\ConfigDeployBundle\Event\ConfigValueExportEvent;
use Oro\Bundle\ConfigDeployBundle\Exception\UnsupportedValueException;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConfigValueSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigDeployEvents::EXPORT_EVENT => 'export',
            ConfigDeployEvents::IMPORT_EVENT => 'import',
        ];
    }

    public function import()
    {
    }

    /**
     * @param ConfigValueExportEvent $event
     */
    public function export(ConfigValueExportEvent $event)
    {
        if (!$event->getExportValue()) {
            $value = $event->getValue();

            if (!is_object($value->getValue())) {
                $event->setExportValue($value->getValue());
            } else {
                throw new UnsupportedValueException();
            }
        }

        $event->stopPropagation();
    }
}
