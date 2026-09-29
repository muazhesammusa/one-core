<?php

declare(strict_types=1);

define('ABSPATH', __DIR__ . '/');

require dirname(__DIR__) . '/inc/admin/class-demo-license-gate.php';

$failures = [];
$assert = static function (bool $condition, string $label) use (&$failures): void {
    if ($condition) {
        echo "PASS {$label}\n";
        return;
    }
    $failures[] = $label;
};

final class OneCoreDemoTestEnforcer
{
    public string $boundary = '';

    public function __construct(private readonly bool $allowed) {}

    public function allowsBoundary(string $boundary): bool
    {
        $this->boundary = $boundary;
        return $this->allowed;
    }
}

final class OneCoreDemoTestManager
{
    public function __construct(private readonly object $enforcer) {}

    public function runtimeEnforcer(): object
    {
        return $this->enforcer;
    }
}

final class OneCoreDemoThrowingManager
{
    public function runtimeEnforcer(): object
    {
        throw new RuntimeException('unavailable');
    }
}

unset($GLOBALS['anylicense_license_managers']);
$assert(!One_Core_Demo_License_Gate::allows(), 'demo import fails closed without AnyLicense runtime');

$GLOBALS['anylicense_license_managers'] = [];
$assert(!One_Core_Demo_License_Gate::allows(), 'demo import fails closed without the One manager');

$GLOBALS['anylicense_license_managers']['one'] = new OneCoreDemoThrowingManager();
$assert(!One_Core_Demo_License_Gate::allows(), 'demo import fails closed when runtime authorization is unavailable');

$denied = new OneCoreDemoTestEnforcer(false);
$GLOBALS['anylicense_license_managers']['one'] = new OneCoreDemoTestManager($denied);
$assert(!One_Core_Demo_License_Gate::allows(), 'demo import stays locked when signed authorization denies the boundary');
$assert($denied->boundary === 'demo_import', 'demo import requests the stable demo_import authorization boundary');

$allowed = new OneCoreDemoTestEnforcer(true);
$GLOBALS['anylicense_license_managers']['one'] = new OneCoreDemoTestManager($allowed);
$assert(One_Core_Demo_License_Gate::allows(), 'demo import unlocks only when AnyLicense authorizes the boundary');
$assert(One_Core_Demo_License_Gate::boundary() === 'demo_import', 'demo import exposes the stable boundary identifier');

if ($failures !== []) {
    fwrite(STDERR, "One Core demo import license gate failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core demo import license gate: PASS\n";
