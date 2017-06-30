<?php

namespace Oro\Bundle\ConfigDeployBundle\Provider;

use Oro\Bundle\ConfigBundle\Entity\ConfigValue;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ConfigValuesProvider
{
    /** @var ManagerRegistry */
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return array|ConfigValue[]
     */
    public function getValues()
    {
        return $this->registry->getManagerForClass(ConfigValue::class)->getRepository(ConfigValue::class)->findAll();
    }
}
