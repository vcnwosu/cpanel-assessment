<?php

declare(strict_types=1);

/**
 * Testing helper function
 *
 * @param Callable $callable
 * @param string $expectation (description of what is expected)
 * @return void
 */
function test(Callable $callable, string $description) {
    try {
        $callable();
        echo "[PASS] $description" . PHP_EOL;
    } catch (\Throwable $e) {
        echo "[FAIL] $description" . PHP_EOL;
        echo $e . PHP_EOL;
        exit;
    }
}
