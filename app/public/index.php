<?php

declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php'; 

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Calculator\LinearInterpolationFeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Exception\FeeCalculatorException;
use PragmaGoTech\Interview\FeeCalculatorFactory;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;

print ("\n");
$term = $_GET['term'];
$amount = $_GET['amount'];

try {
    $calculator = FeeCalculatorFactory::create((int)$term);
    
    $application = new LoanProposal((int)$term, (float)$amount);

    $fee = $calculator->calculate($application);
    print ('fee=');
    
    echo ($fee);
    print ("\n");
} catch(FeeCalculatorException $e) {
    print ('ERRR=');
    print ($e->getMessage());
}
