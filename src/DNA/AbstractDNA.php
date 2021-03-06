<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use RuntimeException;
use Voodooism\Genetic\DNA\Gene\AbstractGene;

abstract class AbstractDNA
{
    /**
     * The fitness of this DNA.
     */
    protected float $fitness = 0;

    /**
     * The value of whole DNA.
     * Can contain any value you want.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Array of genes this DNA.
     *
     * @var array<int, AbstractGene>
     */
    protected array $genes = [];

    /**
     * Replicates this DNA with a different set of genes.
     */
    abstract public function replicate(): self;

    /**
     * Mutate every gene of this DNA with some probability, depends on given "mutation rate".
     * It is an optional step. Mutation is unnecessary in some cases.
     */
    abstract public function mutate(float $mutationRate): void;

    /**
     * Evaluates the fitness of this DNA.
     *
     * The fitness function is always problem dependent.
     * It defines the quality of the represented solution.
     */
    abstract public function evaluateFitness(): void;

    /**
     * Creates a new DNA by crossing this DNA with the given one.
     */
    abstract public function crossover(self $partner): self;

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

    public function getGene(int $number): AbstractGene
    {
        if (!array_key_exists($number, $this->genes)) {
            throw new RuntimeException(sprintf('Gene with number %d doesnt exist', $number));
        }

        return $this->genes[$number];
    }
}