<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use PragmaGoTech\Interview\Model\LoanProposal;

class BreakpointsNotFound extends \Exception implements FeeCalculatorException
{

    public function __construct(int $term) {
        parent::__construct('breakpoint not found for term ('. $term . ')');
    }
}
