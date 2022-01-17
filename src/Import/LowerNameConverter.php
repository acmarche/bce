<?php

namespace AcMarche\Bce\Import;

use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * Make a string's first character lowercase.
 */
class LowerNameConverter implements NameConverterInterface
{
    public function normalize(string $propertyName): string
    {
        return lcfirst($propertyName);
    }

    public function denormalize(string $propertyName): string
    {
        return lcfirst($propertyName);
    }
}
