<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;

use PragmaGoTech\Interview\Model\LoanProposal;

class BadLoanAmount extends \Exception implements FeeCalculatorException
{

    public function __construct() {
        parent::__construct('Bad term...');
    }
}
