<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Exception\BreakpointsNotFound;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

class BreakpointsLoan
{
    private BreakpointsRepository $breakpointsRepository;

    public function __construct(BreakpointsRepository $breakpointsRepository) {
        $this->breakpointsRepository = $breakpointsRepository;
    }

    /**
     * @return array<LoanFeeBreakpoint> The calculated total fee.
     */
    public function getBreakPointsSet(int $term): array
    {
        $data = $this->breakpointsRepository->getBreakpoints($term);
        $result = [];
        foreach ($data as $item) {
            $model = new LoanFeeBreakpoint($item['fee'], $item['amount']);
            $result[] = $model;
        }
        return $result;
    }

    /**
     * @param array<LoanFeeBreakpoint> $breakpointsSet.
     */
    public function getBreakpointsToCalculateFee(array $breakpointsSet, float $amount): array 
    {
        $lower = null;
        $upper = null;

        foreach ($breakpointsSet as $breakpoint) {
            if ($breakpoint->amount() <= $amount) {
                $lower = $breakpoint;
            }
            if ($breakpoint->amount() >= $amount && $upper === null) {
                $upper = $breakpoint;
                break;
            }
        }

        return [$lower, $upper];
    }
}
