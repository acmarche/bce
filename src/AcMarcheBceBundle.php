<?php

namespace AcMarche\Bce;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcMarcheBceBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
