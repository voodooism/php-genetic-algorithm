<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Gene;

use Exception;

/**
 * Class ASCIIStringGene
 *
 * @package Voodooism\Genetic\DNA\Gene
 */
class ASCIIStringGene extends AbstractGene
{
    /**
     * ASCIIStringGene constructor.
     *
     * @param int|null $ASCIINumber
     *
     * @throws Exception
     */
    public function __construct(?int $ASCIINumber = null)
    {
        if (!$ASCIINumber) {
            $ASCIINumber = random_int(32, 126);
        }

        if ($ASCIINumber > 126 || $ASCIINumber < 32) {
            throw new \RuntimeException('Wrong ASCII number! Only numbers from 32 to 126 are allowed');
        }

        $this->value = chr($ASCIINumber);
    }
}