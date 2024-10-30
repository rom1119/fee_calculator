<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;


class BadLoanAmount extends \Exception implements FeeCalculatorException
{

    public function __construct(float $requiredMin, float $requiredMax) {
        parent::__construct('Bad amount passed, the amount should be between ' . $requiredMin . ' and ' . $requiredMax);
    }
}
