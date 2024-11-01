<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Calculator\LinearInterpolationFeeCalculator;
use PragmaGoTech\Interview\BreakpointsLoan;
use PragmaGoTech\Interview\Exception\BadLoanAmount;
use PragmaGoTech\Interview\Exception\BadLoanTerm;
use PragmaGoTech\Interview\FeeCalculator;
use PragmaGoTech\Interview\Repository\BreakpointsRepositoryInMemory;


final class CalculatorTest extends TestCase
{
    private ?FeeCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new LinearInterpolationFeeCalculator(
            new BreakpointsLoan(
                new BreakpointsRepositoryInMemory()
                )
        );
    }
    
    protected function tearDown(): void
    {
        $this->calculator = null;
    }

    public function testMainCases(): void
    {

        $application = new LoanProposal(24, 2500.1);
        $this->assertSame(114.9, $this->calculator->calculate($application));

        $application = new LoanProposal(12, 2000);
        $this->assertSame(90.0, $this->calculator->calculate($application));
        
        $application = new LoanProposal(12, 3000);
        $this->assertSame(90.0, $this->calculator->calculate($application));
        
        $application = new LoanProposal(24, 11500);
        $this->assertSame(460.0, $this->calculator->calculate($application));
        
        $application = new LoanProposal(12, 19250);
        $this->assertSame(385.0, $this->calculator->calculate($application));
        
    }

    public function testExceptionBadTerm(): void
    {
        $application = new LoanProposal(99, 3000);

        $this->expectException(BadLoanTerm::class);
        $this->calculator->calculate($application);
    }
    
    public function testExceptionBadAmount(): void
    {
        $application = new LoanProposal(24, 20001);

        $this->expectException(BadLoanAmount::class);
        $this->calculator->calculate($application);

        $application = new LoanProposal(24, 999);

        $this->expectException(BadLoanAmount::class);
        $this->calculator->calculate($application);
    }
}