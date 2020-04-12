<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use Voodooism\Genetic\DNA\Gene\AbstractGene;
use Voodooism\Genetic\DNA\Gene\NullGene;

class NullDNA extends AbstractDNA
{
    /**
     * @return mixed
     */
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

    /**
     * @inheritDoc
     */
    public function getGene(int $number): AbstractGene
    {
        return new NullGene();
    }

    /**
     * @inheritDoc
     */
    public function replicate(): AbstractDNA
    {
        return new self();
    }

    /**
     * @inheritDoc
     */
    public function mutate(float $mutationRate): void
    {
        // just stub
    }

    /**
     * @inheritDoc
     */
    public function evaluateFitness(): void
    {
        // just stub
    }

    /**
     * @inheritDoc
     */
    public function crossover(AbstractDNA $partner): AbstractDNA
    {
        return new self();
    }
}