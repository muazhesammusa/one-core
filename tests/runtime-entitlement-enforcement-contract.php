<?php
$root = dirname(__DIR__);
$module = file_get_contents($root . '/t/class-tophive-modules.php') ?: '';
$bootstrap = file_get_contents($root . '/one-core.php') ?: '';
$demo = file_get_contents($root . '/inc/admin/demo-import.php') ?: '';
$failures = [];

if (strpos($bootstrap, "if (!EntitlementBridge::has('one_core'))") !== false) {
    $failures[] = 'One Core base runtime still hard-locks the frontend behind the one_core entitlement.';
}
if (strpos($module, "if ( ! \\ONECORE\\EntitlementBridge::has( 'one_core' ) )") !== false) {
    $failures[] = 'One Core module bootstrap still hard-locks public modules behind the one_core entitlement.';
}
if (strpos($module, "add_filter( 'tophive/is_pro_activated', '__return_true' )") !== false) {
    $failures[] = 'One Core still forces tophive/is_pro_activated true regardless of entitlement.';
}
if (strpos($module, 'function OneCoreCustomizer_Is_Pro_Activated') === false || strpos($module, "EntitlementBridge::has( 'one_core' )") === false) {
    $failures[] = 'One Core does not expose an entitlement-backed commercial/pro activation filter.';
}
foreach (["EntitlementBridge::has('demo_import')", 'one_license_required'] as $required) {
    if (strpos($demo, $required) === false) {
        $failures[] = "Protected demo importer contract is missing: {$required}";
    }
}
if (is_file($root . '/t/tophive-pro.php')) {
    $failures[] = 'Dormant duplicate premium bootstrap t/tophive-pro.php still ships in One Core.';
}

if ($failures) {
    fwrite(STDERR, "One Core runtime entitlement enforcement contract failed:\n- " . implode("\n- ", $failures) . "\n");
    exit(1);
}

echo "One Core runtime entitlement enforcement contract: PASS\n";
