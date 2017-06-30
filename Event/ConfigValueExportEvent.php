<?php

namespace Oro\Bundle\ConfigDeployBundle\Event;

use Oro\Bundle\ConfigBundle\Entity\ConfigValue;
use Symfony\Component\EventDispatcher\Event;

class ConfigValueExportEvent extends Event
{
    /** @var ConfigValue */
    protected $value;

    /** @var  string|int|float|array */
    protected $exportValue;

    public function __construct(ConfigValue $configValue)
    {
        $this->value = $configValue;
    }

    /**
     * @return ConfigValue
     */
    public function getValue()
    {
        return $this->value;
    }


    /**
     * @return array|float|int|string
     */
    public function getExportValue()
    {
        return $this->exportValue;
    }

    /**
     * @param array|float|int|string $exportValue
     *
     * @return $this
     */
    public function setExportValue($exportValue)
    {
        $this->exportValue = $exportValue;

        return $this;
    }
}
