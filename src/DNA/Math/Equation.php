<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Math;

use Voodooism\Genetic\DNA\Gene\MathGene;

/**
 * Class Equation
 *
 * @package Voodooism\Genetic\DNA\Math
 */
class Equation
{
    /**
     * This function contains the implementation of equation's calculations.
     * Should return calculation result.
     *
     * @var callable
     */
    private $func;

    /**
     * Equation constructor.
     *
     * @param callable $f
     */
    public function __construct(callable $f)
    {
        $this->func = $f;
    }

    /**
     * @param MathGene ...$genes Each of gene corresponds to a variable of equation.
     *
     * @return float
     */
    public function __invoke(MathGene ...$genes): float
    {
        $callable = $this->func;

        $args = array_map(static function ($gene) {
            /** @var MathGene $gene */
            return $gene->getValue();
        }, func_get_args());

        return $callable(...$args);
    }
}