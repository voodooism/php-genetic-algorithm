<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use Exception;
use Voodooism\Genetic\DNA\Gene\MathGene;
use Voodooism\Genetic\DNA\Math\Equation;
use InvalidArgumentException;

class MathDNA extends AbstractDNA
{
    /**
     * Indicates max or min is interesting
     * true - max
     * false - min
     */
    private bool $max;

    /**
     * The object equation itself
     */
    private Equation $equation;

    /**
     * @throws Exception
     */
    public function __construct(Equation $equation, array $genes, bool $max)
    {
        foreach ($genes as $gene) {
            if (!$gene instanceof MathGene) {
                throw new InvalidArgumentException(
                    sprintf('Gene should be instance of `%s`.', MathGene::class)
                );
            }
        }

        $this->genes = $genes;
        $this->max = $max;
        $this->equation = $equation;
    }

    /**
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     *
     * @return MathGene[]
     */
    public function getValue(): array
    {
        return $this->genes;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function replicate(): AbstractDNA
    {
        $genes = [];

        foreach ($this->genes as $gene) {
            /** @var MathGene $gene */
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
            /** @var MathGene $gene */
            if ( mt_rand() / mt_getrandmax() < $mutationRate) {
                $this->genes[$key] = $gene->mutate();
            }
        }
    }

    /**
     * @psalm-suppress ArgumentTypeCoercion
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