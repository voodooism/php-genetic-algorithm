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
     * The value this gene.
     * Can contain any value you want.
     *
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