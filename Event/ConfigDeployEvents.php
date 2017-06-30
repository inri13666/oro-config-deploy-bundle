<?php

namespace Oro\Bundle\ConfigDeployBundle\Event;

interface ConfigDeployEvents
{
    const EXPORT_EVENT = 'config.value.export';
    const IMPORT_EVENT = 'config.value.import';
}
