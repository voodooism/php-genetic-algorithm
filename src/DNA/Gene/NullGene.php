<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Gene;

class NullGene extends AbstractGene
{
    public function getValue()
    {
        return null;
    }
}