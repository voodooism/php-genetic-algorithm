<?php

declare(strict_types=1);

namespace Voodooism\Genetic;

use Voodooism\Genetic\DNA\AbstractDNA;
use Voodooism\Genetic\DNA\NullDNA;

final class Population
{
    /**
     * @var AbstractDNA[]
     */
    private $population;

    /**
     * @var int
     */
    private $epoch;

    /**
     * @var float
     */
    private $mutationRate;

    /**
     * @var AbstractDNA
     */
    private $best;

    /**
     * @var float
     */
    private $totalFitness;

    /**
     * @var int
     */
    private $populationNumber;

    /**
     * Population constructor.
     *
     * @param AbstractDNA $DNA
     * @param int         $populationNumber
     * @param float       $mutationRate
     */
    public function __construct(AbstractDNA $DNA, int $populationNumber, float $mutationRate)
    {
        $this->epoch = 0;
        $this->mutationRate = $mutationRate;
        $this->totalFitness = 0;
        $this->populationNumber = $populationNumber;

        $this->population = [];
        for ($i = 0; $i < $populationNumber; $i++) {
            $this->population[] = $DNA->replicate();
        }
    }

    /**
     * @return AbstractDNA
     */
    public function getBest(): AbstractDNA
    {
        return $this->best ?? new NullDNA();
    }

    /**
     * @return float
     */
    public function getTotalFitness(): float
    {
        return $this->totalFitness;
    }

    /**
     * @return int
     */
    public function getEpoch(): int
    {
        return $this->epoch;
    }

    /**
     * @return AbstractDNA[]
     */
    public function getPopulation(): array
    {
        return $this->population;
    }

    public function evaluateFitness(): void
    {
        $this->totalFitness = 0;
        $this->best = null;
        foreach ($this->population as $DNA) {
            $DNA->evaluateFitness();
            $this->totalFitness += $DNA->getFitness();

            if (!$this->best || $this->best->getFitness() < $DNA->getFitness()) {
                $this->best = $DNA;
            }
        }
    }

    public function createNewGeneration(): void
    {
        $newGeneration = [];
        for ($i = 0; $i < $this->populationNumber; $i++) {
            $firstParent = $this->selectParent();
            $secondParent = $this->selectParent();

            $child = $firstParent->crossover($secondParent);
            $child->mutate($this->mutationRate);

            $newGeneration[] = $child;
        }

        $this->population = $newGeneration;
        $this->epoch++;
    }

    /**
     * @return AbstractDNA
     */
    private function selectParent(): AbstractDNA
    {
        $random = mt_rand() / mt_getrandmax();
        $index = 0;

        while ($random > 0) {
            $random -= $this->population[$index]->getFitness() / $this->totalFitness;
            $index++;
        }

        $index--;
        return $this->population[$index];
    }
}