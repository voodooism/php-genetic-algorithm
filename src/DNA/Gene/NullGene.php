<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Gene;

/**
 * Gene stub
 */
class NullGene extends AbstractGene
{
    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return null;
    }
}