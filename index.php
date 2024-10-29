<?php

declare(strict_types=1);
require_once __DIR__.'/vendor/autoload.php';
// echo 

use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Calculator\DefaultFeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;

// echo __DIR__ . '/vendor/autoload.php9999999999999';
$o = new DefaultFeeCalculator(new BreakpointsLoan(new BreakpointsRepositoryInMemory()));


$application = new LoanProposal(24, 2750);

$o->calculate($application);