<?php

declare(strict_types=1);
require_once __DIR__.'/../vendor/autoload.php'; 

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Calculator\DefaultFeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Exception\FeeCalculatorException;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;

print ("\n");
$calculator = new DefaultFeeCalculator(new BreakpointsLoan(new BreakpointsRepositoryInMemory()));
$term = $_GET['term'];
$amount = $_GET['amount'];

$application = new LoanProposal((int)$term, (float)$amount);

try {

    $fee = $calculator->calculate($application);
    print ('fee=');
    
    echo ($fee);
    print ("\n");
} catch(FeeCalculatorException $e) {
    print ('ERRR=');
    print ($e->getMessage());
}
