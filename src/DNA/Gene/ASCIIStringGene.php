<?php

declare(strict_types=1);

namespace Voodooism\Genetic\DNA\Gene;

use RuntimeException;
use Exception;

class ASCIIStringGene extends AbstractGene
{
    /**
     * @throws RuntimeException
     * @throws Exception
     */
    public function __construct(?int $ASCIINumber = null)
    {
        if (!$ASCIINumber) {
            $ASCIINumber = random_int(32, 126);
        }

        if ($ASCIINumber > 126 || $ASCIINumber < 32) {
            throw new RuntimeException('Wrong ASCII number! Only numbers from 32 to 126 are allowed');
        }

        $this->value = chr($ASCIINumber);
    }
}