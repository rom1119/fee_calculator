<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Exception;


class FeeCalculatorError extends \Exception implements FeeCalculatorException
{

    public function __construct(string $msg) {
        parent::__construct($msg);
    }
}
