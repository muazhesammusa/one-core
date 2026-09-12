<?php
$root = dirname(__DIR__);
$module = file_get_contents($root . '/t/class-tophive-modules.php') ?: '';
$bootstrap = file_get_contents($root . '/one-core.php') ?: '';
$failures = [];

if (strpos($module, "EntitlementBridge::has( 'one_core' )") === false) {
    $failures[] = 'One Core premium module bootstrap is not gated by the one_core entitlement.';
}
if (strpos($module, "add_filter( 'tophive/is_pro_activated', '__return_true' )") !== false) {
    $failures[] = 'One Core still forces tophive/is_pro_activated true regardless of entitlement.';
}
if (strpos($module, 'function OneCoreCustomizer_Is_Pro_Activated') === false) {
    $failures[] = 'One Core does not expose an entitlement-backed pro activation filter.';
}
if (strpos($bootstrap, "EntitlementBridge::has('one_core')") === false || strpos($bootstrap, 'init_entitled_runtime') === false) {
    $failures[] = 'One Core base runtime is not delayed and gated by the one_core entitlement.';
}
if (is_file($root . '/t/tophive-pro.php')) {
    $failures[] = 'Dormant duplicate premium bootstrap t/tophive-pro.php still ships in One Core.';
}

if ($failures) {
    fwrite(STDERR, "One Core runtime entitlement enforcement contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core runtime entitlement enforcement contract: PASS\n";
