<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use RuntimeException;
use Voodooism\Genetic\DNA\Gene\AbstractGene;

/**
 * Class AbstractDNA
 *
 * @package Voodooism\Genetic\DNA
 */
abstract class AbstractDNA
{
    /**
     * @var
     */
    protected $fitness = 0;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var AbstractGene[]
     */
    protected $genes;

    /**
     * @return $this
     */
    abstract public function replicate(): self;

    /**
     * @param float $mutationRate
     */
    abstract public function mutate(float $mutationRate): void;

    /**
     *
     */
    abstract public function evaluateFitness(): void;

    /**
     * @param AbstractDNA $partner
     *
     * @return $this
     */
    abstract public function crossover(self $partner): self;

    /**
     * @return float
     */
    public function getFitness(): float
    {
        return $this->fitness;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $number
     *
     * @return AbstractGene
     */
    public function getGene(int $number): AbstractGene
    {
        if (!array_key_exists($number, $this->genes)) {
            throw new RuntimeException(sprintf('Gene with number %d doesnt exist', $number));
        }

        return $this->genes[$number];
    }
}