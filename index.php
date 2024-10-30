<?php

declare(strict_types=1);
require_once __DIR__.'/vendor/autoload.php';
// echo 

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Calculator\DefaultFeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Exception\FeeCalculatorException;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;

// echo __DIR__ . '/vendor/autoload.php9999999999999';
print ("\n");
$o = new DefaultFeeCalculator(new BreakpointsLoan(new BreakpointsRepositoryInMemory()));


$application = new LoanProposal(24, 2500.2);
// $application = new LoanProposal(24, 30000);
// $application = new LoanProposal(12, 19250);
// $application = new LoanProposal(12, 3000);
// $application = new LoanProposal(24, 1000);

try {

    $fee = $o->calculate($application);
    print ('$fee=');
    echo ($fee);
    var_dump($fee);
} catch(FeeCalculatorException $e) {
    print ('ERRR=');
    print ($e->getMessage());
}
