<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Gene;

/**
 * Class AbstractGene
 *
 * @package Voodooism\Genetic\DNA\Gene
 */
abstract class AbstractGene
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}