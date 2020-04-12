<?php

declare(strict_types=1);

namespace Voodooism\Genetic\Test;

use PHPUnit\Framework\TestCase;
use Voodooism\Genetic\DNA\ASCIIStringDNA;
use Voodooism\Genetic\Population;

class PopulationTest extends TestCase
{
    public function testEvaluateFitness(): void
    {
        $goal = 'Where is the money, Lebowski?';
        $DNA = new ASCIIStringDNA($goal);
        $population = new Population($DNA, $populationNumber = 10, $mutationRate = 0.1);

        $oldFitness = $population->getTotalFitness();

        $population->evaluateFitness();

        $this->assertFalse($oldFitness === $population->getTotalFitness());
    }

    public function testCreateNewGeneration(): void
    {
        $goal = 'Where is the money, Lebowski?';
        $DNA = new ASCIIStringDNA($goal);
        $population = new Population($DNA, $populationNumber = 10, $mutationRate = 0.1);

        $oldBest =$population->getBest();
        $oldEpoch = $population->getEpoch();
        $oldFitness = $population->getTotalFitness();
        $oldPopulation = $population->getPopulation();


        $population->evaluateFitness();
        $population->createNewGeneration();

        $population->evaluateFitness();

        $this->assertNotSame($oldBest, $population->getBest());
        $this->assertEquals($oldEpoch + 1, $population->getEpoch());
        $this->assertFalse($oldFitness === $population->getTotalFitness());
        $this->assertNotSame($oldPopulation, $population->getPopulation());
    }

    public function testGeneticAlgorithmWithASCIIStringGenes(): void
    {
        $goal       = 'Where is the money, Lebowski?';
        $DNA        = new ASCIIStringDNA($goal);
        $population = new Population($DNA, $populationNumber = 200, $mutationRate = 0.1);

        while ($population->getBest()->getValue() !== $goal) {
            $population->evaluateFitness();
            $population->createNewGeneration();
        }

        $this->assertGreaterThan(0, $population->getEpoch());
        $this->assertEquals($goal, $population->getBest()->getValue());

    }
}