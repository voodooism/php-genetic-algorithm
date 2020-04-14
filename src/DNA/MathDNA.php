<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use Exception;
use Voodooism\Genetic\DNA\Gene\MathGene;
use Voodooism\Genetic\DNA\Math\Equation;
use Webmozart\Assert\Assert;

/**
 * Class MathDNA
 *
 * @package Voodooism\Genetic\DNA
 */
class MathDNA extends AbstractDNA
{
    /**
     * Indicates max or min is interesting
     * true - max
     * false - min
     *
     * @var bool
     */
    private $max;

    /**
     * The object equation itself
     *
     * @var Equation
     */
    private $equation;

    /**
     * MathDNA constructor.
     *
     * @param Equation   $equation
     * @param MathGene[] $genes
     * @param bool       $max
     *
     * @throws Exception
     */
    public function __construct(Equation $equation, array $genes, bool $max)
    {
        Assert::allIsInstanceOf($genes, MathGene::class);

        $this->genes = $genes;
        $this->max = $max;
        $this->equation = $equation;
    }

    /**
     * @return MathGene[]
     */
    public function getValue(): array
    {
        return $this->genes;
    }

    /**
     * @inheritDoc
     *
     * @return self
     *
     * @throws Exception
     */
    public function replicate(): AbstractDNA
    {
        $genes = [];

        foreach ($this->genes as $gene) {
            $genes[] = $gene->mutate();
        }

        return new self($this->equation, $genes, $this->max);
    }

    /**
     * @inheritDoc
     *            
     * @throws Exception
     */
    public function mutate(float $mutationRate): void
    {
        foreach ($this->genes as $key => $gene) {
            if ( mt_rand() / mt_getrandmax() < $mutationRate) {
                $this->genes[$key] = $gene->mutate();
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function evaluateFitness(): void
    {
        $equation = $this->equation;
        $result = $equation(...$this->genes);

        $this->fitness = exp($this->max ? $result : -$result);
    }

    /**
     * @inheritDoc
     *
     * @return self
     *
     * @throws Exception
     */
    public function crossover(AbstractDNA $partner): AbstractDNA
    {
        $genes = [];

        foreach ($this->genes as $key => $gene) {
            $genes[$key] = random_int(0, 1) ? $gene : $partner->getGene($key);
        }

        return new self($this->equation, $genes, $this->max);
    }
}