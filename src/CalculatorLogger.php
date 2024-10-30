<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class CalculatorLogger
{
    private Logger $logger;

    public function __construct() {
        $this->logger = new Logger("main");

        $stream_handler = new StreamHandler(__DIR__ . "/../var/logs/error.log");
        $this->logger->pushHandler($stream_handler);
    }

    public function logError(string $msg, array $context = []): void
    {
        $this->logger->error($msg, $context);

    }
}
