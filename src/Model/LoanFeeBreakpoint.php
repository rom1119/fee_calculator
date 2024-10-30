<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Model;

class LoanFeeBreakpoint
{
    private float $amount;
    private float $fee;

    public function __construct(float $fee, float $amount)
    {
        $this->fee = $fee;
        $this->amount = $amount;
    }

    /**
     * Term (loan duration) for this loan application
     * in number of months.
     */
    public function fee(): float
    {
        return $this->fee;
    }

    /**
     * Amount requested for this loan application.
     */
    public function amount(): float
    {
        return $this->amount;
    }
}
