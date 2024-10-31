<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Calculator\LinearInterpolationFeeCalculator;
use PragmaGoTech\Interview\Exception\BadLoanTerm;
use PragmaGoTech\Interview\Exception\FeeCalculatorException;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;

class FeeCalculatorFactory
{
    /**
     * @throws BadLoanTerm
     * @return FeeCalculator
     */
    public static function create(int $term): FeeCalculator {
        switch ($term) {
            case 12 || 24:
                return new LinearInterpolationFeeCalculator(
                    new BreakpointsLoan(
                        new BreakpointsRepositoryInMemory()
                        )
                );
            default:
                throw new BadLoanTerm();
        }
    }
}
