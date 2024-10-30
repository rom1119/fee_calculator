<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Calculator;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Exception\BadLoanTerm;
use PragmaGoTech\Interview\Exception\BadLoanAmount;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Exception\BreakpointsNotFound;
use PragmaGoTech\Interview\Exception\FeeCalculatorException;

class DefaultFeeCalculator implements FeeCalculator
{

    private BreakpointsLoan $breakpointsLoan;

    public function __construct(BreakpointsLoan $breakpointsLoan) {
        $this->breakpointsLoan = $breakpointsLoan;
    }
    /**
     * @throws FeeCalculatorException
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float
    {
        try {
            $breakpointsSet = $this->breakpointsLoan->getBreakPointsSet($application->term());

        } catch (BreakpointsNotFound $e) {

            throw new BadLoanTerm();
        }
        
        if ($application->amount() < 1000 || $application->term() > 20000) {
            throw new BadLoanAmount();
        }

        $breakpoints = $this->getBreakpointsToCalculateFee($breakpointsSet, $application);
        $minBreakpoint = $breakpoints[0];
        $maxBreakpoint = $breakpoints[1];
        // var_dump($minBreakpoint);
        // var_dump($maxBreakpoint);
        $calcFee = $this->calculateFeeValue(
            $application->amount(),
            $minBreakpoint->amount(),
            $maxBreakpoint->amount(),
            $minBreakpoint->fee(),
            $maxBreakpoint->fee(),
        );



        return $this->roundUpToNearestFive($application->amount(), $calcFee);
    }

    private function getBreakpointsToCalculateFee(array $breakpointsSet, LoanProposal $application): array 
    {
        $lower = null;
        $upper = null;

        foreach ($breakpointsSet as $breakpoint) {
            if ($breakpoint->amount() <= $application->amount()) {
                $lower = $breakpoint;
            }
            if ($breakpoint->amount() >= $application->amount() && $upper === null) {
                $upper = $breakpoint;
                break;
            }
        }

        return [$lower, $upper];
        
    }
    private function roundUpToNearestFive(float $amount, float $fee): float 
    {
        $total = $amount + $fee;
        return ceil($total / 5) * 5 - $amount;
    }

    private function calculateFeeValue($amount, $minVal, $maxVal, $minFee, $maxFee): float
    {
        $d = ($amount - $minVal) / ($maxVal - $minVal);
        return $minFee * (1 - $d) + $maxFee * $d;
    }
}
