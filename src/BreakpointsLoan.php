<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;


class BreakpointsLoan
{
    private BreakpointsRepository $breakpointsRepository;

    public function __construct(BreakpointsRepository $breakpointsRepository) {
        $this->breakpointsRepository = $breakpointsRepository;
    }
    /**
     * @return float The calculated total fee.
     */
    public function getBreakPointsSet(int $term): array
    {
        return $this->breakpointsRepository->getBreakpoints($term);
    }
}
