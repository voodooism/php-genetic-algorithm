<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Gene;

use Exception;

/**
 * Class MathGene
 *
 * @package Voodooism\Genetic\DNA\Gene
 */
class MathGene extends AbstractGene
{
    /**
     * The number of decimal digits to round to.
     */
    private const PRECISION = 2;

    /**
     * The lowest possible value (inclusive).
     *
     * @var float
     */
    private $from;

    /**
     * The lowest possible value (inclusive).
     *
     * @var float
     */
    private $to;

    /**
     * MathGene constructor.
     *
     * @param float      $from
     * @param float      $to
     * @param float|null $value
     *
     * @throws Exception
     */
    public function __construct(float $from, float $to, ?float $value = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value ?? $this->generate();
    }

    /**
     * @return $this
     *
     * @throws Exception
     */
    public function mutate(): self
    {
        return new self($this->from, $this->to);
    }

    /**
     * Generates random float accordingly to "from" and "to" parameters
     *
     * @return float
     *
     * @throws Exception
     */
    private function generate(): float
    {
        $multiplier = 10 ** self::PRECISION;

        $intFrom = (int)$this->from * $multiplier;
        $intTo   = (int)$this->to * $multiplier;

        return random_int($intFrom, $intTo) / $multiplier;
    }
}