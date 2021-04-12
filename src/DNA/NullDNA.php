<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use Voodooism\Genetic\DNA\Gene\AbstractGene;
use Voodooism\Genetic\DNA\Gene\NullGene;

/**
 * DNA Stub
 */
class NullDNA extends AbstractDNA
{
    public function getFitness(): float
    {
        return 0;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return null;
    }

    public function getGene(int $number): AbstractGene
    {
        return new NullGene();
    }

    public function replicate(): AbstractDNA
    {
        return new self();
    }

    public function mutate(float $mutationRate): void
    {
        // just stub
    }

    public function evaluateFitness(): void
    {
        // just stub
    }

    public function crossover(AbstractDNA $partner): AbstractDNA
    {
        return new self();
    }
}