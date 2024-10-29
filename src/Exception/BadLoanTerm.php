<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use PragmaGoTech\Interview\Model\LoanProposal;

class BadLoanTerm extends \Exception implements FeeCalculatorException
{

    public function __construct() {
        parent::__construct('Bad term...');
    }
}
