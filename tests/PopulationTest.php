<?php

declare(strict_types=1);

namespace Voodooism\Genetic\Test;

use PHPUnit\Framework\TestCase;
use Voodooism\Genetic\DNA\ASCIIStringDNA;
use Voodooism\Genetic\DNA\Math\Equation;
use Voodooism\Genetic\DNA\Gene\MathGene;
use Voodooism\Genetic\DNA\MathDNA;
use Voodooism\Genetic\Population;
use Exception;

class PopulationTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testEvaluateFitness(): void
    {
        $goal = 'Where is the money, Lebowski?';
        $DNA = new ASCIIStringDNA($goal);
        $population = new Population($DNA, $populationNumber = 10, $mutationRate = 0.1);

        $oldFitness = $population->getTotalFitness();

        $population->evaluateFitness();

        $this->assertFalse($oldFitness === $population->getTotalFitness());
    }

    /**
     * @throws Exception
     */
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

    /**
     * @throws Exception
     */
    public function testGeneticAlgorithmWithASCIIStringDNA(): void
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

    /**
     * @dataProvider getDataProviderForMathDNA
     *
     * @param MathDNA    $DNA
     * @param MathGene[] $reference
     *
     */
    public function testGeneticAlgorithmWithMathDNA(MathDNA $DNA, array $reference): void
    {
        $delta = 0.05;

        $population = new Population($DNA, $populationNumber = 200, $mutationRate = 0.1);

        for ($i = 0; $i < 100; $i++) {
            $population->evaluateFitness();
            $population->createNewGeneration();
        }

        /** @var MathGene[] $bestValue */
        $bestValue = $population->getBest()->getValue();

        foreach ($reference as $key => $gene) {
            $this->assertTrue(
                $bestValue[$key]->getValue() >= $reference[$key]->getValue() - $delta
                && $bestValue[$key]->getValue() <= $reference[$key]->getValue() + $delta
            );
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getDataProviderForMathDNA(): array
    {
        return [
            //Equation: ( x^2 + x ) * cos(x)  --> min --> [-10; 10];
            //answer is ~9.62
            [
                new MathDNA(
                    new Equation(
                        $function = static function (...$args) {
                            $x = func_get_arg(0);

                            $equation = ($x ** 2 + $x) * cos($x);

                            return $equation;
                        }
                    ),
                    [new MathGene(-10, 10)],
                    false
                ),
                [new MathGene(-10,10, 9.62)]
            ],

            //Equation: 5 + 3x - 4y - x^2 + x y - y^2  --> max --> x in [-2; 2] and y in [-2, 2]
            //answer is x = 1/3, y = 5/3
            [
                new MathDNA(
                    new Equation(
                        $function = static function (...$args) {
                            $x = func_get_arg(0);
                            $y = func_get_arg(1);

                            $equation = 5 + 3 * $x - 4 * $y - $x ** 2 + $x * $y - $y ** 2;

                            return $equation;
                        }
                    ),
                    [new MathGene(-2, 2), new MathGene(-2, 2)],
                    true
                ),
                [new MathGene(-2, 2, 0.66), new MathGene(-2, 2, 0 - 1.66)]
            ],
        ];
    }
}