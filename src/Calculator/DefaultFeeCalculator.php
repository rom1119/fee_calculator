<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Calculator;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Exception\BadLoanTerm;
use PragmaGoTech\Interview\Exception\BadLoanAmount;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;



class DefaultFeeCalculator implements FeeCalculator
{

    private BreakpointsLoan $breakpointsLoan;

    public function __construct(BreakpointsLoan $breakpointsLoan) {
        $this->breakpointsLoan = $breakpointsLoan;
    }
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float
    {
        // die(1231);
        if ($application->term() < 12 || $application->term() > 24) {
            throw new BadLoanTerm();
        }
        
        if ($application->amount() < 1000 || $application->term() > 20000) {
            throw new BadLoanAmount();
        }

        $breakpointsSet = $this->breakpointsLoan->getBreakPointsSet($application->term());
        ksort($breakpointsSet);
        $breakpoints = [];
        foreach($breakpointsSet as $i => $breakpoint) {
            if ($breakpoint['amount'] >= $application->amount()) {

                $breakpoints = [$breakpointsSet[$i - 1], $breakpoint];
                break;
            }
        }
        $minBreakpoint = $breakpointsSet[0];
        $maxBreakpoint = $breakpointsSet[1];
        $calcFee = $this->calculateFeeValue(
            $application->amount(),
            $minBreakpoint['amount'],
            $maxBreakpoint['amount'],
            $minBreakpoint['fee'],
            $maxBreakpoint['fee'],
        );


        return $this->roundUpToNearestFive($application->amount(), $calcFee);
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
