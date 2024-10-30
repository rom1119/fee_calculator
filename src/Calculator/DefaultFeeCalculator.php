<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Calculator;

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Exception\BadLoanTerm;
use PragmaGoTech\Interview\Exception\BadLoanAmount;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Exception\GeneralFeeCalculatorError;
use PragmaGoTech\Interview\Exception\FeeCalculatorException;
use PragmaGoTech\Interview\Model\LoanFeeBreakpoint;

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
    
            $this->validateLoanProposal($application, $breakpointsSet);
    
            $this->sortAscByLoan($breakpointsSet);
    
            $breakpoints = $this->getBreakpointsToCalculateFee($breakpointsSet, $application);
            $minBreakpoint = $breakpoints[0];
            $maxBreakpoint = $breakpoints[1];
            // var_dump($minBreakpoint);
            // var_dump($maxBreakpoint);
    
            if ($minBreakpoint->amount() == $maxBreakpoint->amount()) {
                return (float)$minBreakpoint->fee();
            }
    
            $calcFee = $this->calculateFeeValue(
                $application->amount(),
                $minBreakpoint->amount(),
                $maxBreakpoint->amount(),
                $minBreakpoint->fee(),
                $maxBreakpoint->fee(),
            );
            
            var_dump($calcFee);
            
            // die;
            return $this->roundUpToNearestFive($application->amount(), $calcFee);
            
        } catch (FeeCalculatorException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new GeneralFeeCalculatorError('Somethink went wrong with calculator');
        }
    }



    private function validateLoanProposal(LoanProposal $application, array $breakpointsSet): void
    {
        if (!count($breakpointsSet)) {

            throw new BadLoanTerm();
        }

        $min = array_reduce($breakpointsSet, function ( $A,  $B) {
            return $A->amount() < $B->amount() ? $A : $B;
        }, $breakpointsSet[0]);

        $max = array_reduce($breakpointsSet, function ( $A,  $B) {
            return $A->amount() > $B->amount() ? $A : $B;
        }, $breakpointsSet[0]);

        if ($application->amount() < $min->amount() || $application->amount() > $max->amount()) {
            throw new BadLoanAmount($min->amount(), $max->amount());
        }
    }
    private function comparator(LoanFeeBreakpoint $a, LoanFeeBreakpoint $b): bool 
    {
        return  $a->amount() > $b->amount();
    }
    
    private function roundUpToNearestFive(float $amount, float $fee): float 
    {
        $total = $amount + $fee;
        $value = ceil($total / 5) * 5 - $amount;
        return (float)number_format((float)$value, 2, '.', '');
    }

    private function calculateFeeValue($amount, $minVal, $maxVal, $minFee, $maxFee): float
    {
        $d = ($amount - $minVal) / ($maxVal - $minVal);
        return $minFee * (1 - $d) + $maxFee * $d;
    }

    private function sortAscByLoan(array &$breakpoints)
    {
        usort($breakpoints, array($this, "comparator"));
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
}
