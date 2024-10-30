<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;


interface BreakpointsRepository
{
    /**
     * @return array The calculated total fee.
     */
    public function getBreakpoints(int $term): array;
}
