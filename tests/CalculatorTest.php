<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Calculator\DefaultFeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;


final class CalculatorTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $o = new DefaultFeeCalculator(new BreakpointsLoan(new BreakpointsRepositoryInMemory()));

        $application = new LoanProposal(24, 2500.2);


        $this->assertSame(115.0, $o->calculate($application));
    }
}