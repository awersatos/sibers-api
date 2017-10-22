<?php

namespace Sibers\ApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SibersApiBundle extends Bundle
{
    public function getParent()
    {
        return 'ApiPlatformBundle';
    }
}
