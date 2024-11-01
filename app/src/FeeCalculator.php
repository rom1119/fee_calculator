<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Exception\FeeCalculatorException;
use PragmaGoTech\Interview\Model\LoanProposal;

interface FeeCalculator
{
    /**
     * @throws FeeCalculatorException
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float;
}
