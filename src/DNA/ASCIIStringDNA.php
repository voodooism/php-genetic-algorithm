<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA;

use Exception;
use RuntimeException;
use Voodooism\Genetic\DNA\Gene\ASCIIStringGene;
use Webmozart\Assert\Assert;

/**
 * Class ASCIIStringDNA
 *
 * @package Voodooism\Genetic\DNA
 */
class ASCIIStringDNA extends AbstractDNA
{
    /**
     * Fitness exponent.
     * The more exponent is the faster result of a fitness function grows.
     */
    private const EXP = 100;

    /**
     * Contains the goal of evolution.
     *
     * @var string
     */
    private $target;

    /**
     * The length of the goal string.
     *
     * @var int
     */
    private $length;

    /**
     * Every character in a phrase is a gene.
     *
     * @var ASCIIStringGene[]
     */
    protected $genes;

    /**
     * ASCIIStringDNA constructor.
     *
     * @param string $target
     * @param array  $genes
     *
     * @throws Exception
     */
    public function __construct(string $target, array $genes = [])
    {
        Assert::allIsInstanceOf($genes, ASCIIStringGene::class);

        $this->target = $target;
        $this->length = strlen($target);
        $this->genes = $genes;

        if (count($genes) > $this->length) {
            throw new RuntimeException('Count of genes can be more than length of target string');
        }

        $diff = $this->length - count($genes);

        if ($diff > 0) {
            for ($i = 0; $i < $diff; $i++) {
                $this->genes[] = new ASCIIStringGene();
            }
        }
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function replicate(): AbstractDNA
    {
        $genes = [];

        for ($i = 0; $i < $this->length; $i++) {
            $genes[] = new ASCIIStringGene();
        }
        return new self($this->target, $genes);
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
                $this->genes[$key] = new ASCIIStringGene();
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function evaluateFitness(): void
    {
        $score = 0;
        foreach ($this->genes as $key => $gene) {
            if ($gene->getValue() === $this->target[$key]) {
                $score++;
            }
        }

        $this->fitness = $score / $this->length;
        $this->fitness = $this->fitness ** self::EXP;
    }

    /**
     * @inheritDoc
     *
     * @throws Exception
     */
    public function crossover(AbstractDNA $partner): AbstractDNA
    {
        $genes = [];

        for ($i = 0; $i < $this->length; $i++) {
            $genes[$i] = random_int(0, 1) ? $this->getGene($i) : $partner->getGene($i);
        }

        return new self($this->target, $genes);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $value = '';
        foreach ($this->genes as $gene) {
            $value .= $gene->getValue();
        }

        return $value;
    }
}