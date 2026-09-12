<?php
$filters = [];
$actions = [];
function add_filter($tag, $callback, $priority = 10, $accepted_args = 1) {
    global $filters;
    $filters[$tag][] = $callback;
    return true;
}
function add_action($tag, $callback, $priority = 10, $accepted_args = 1) {
    global $actions;
    $actions[$tag][] = $callback;
    return true;
}
function apply_filters($tag, $value, ...$args) {
    global $filters;
    foreach ($filters[$tag] ?? [] as $callback) {
        $value = call_user_func($callback, $value, ...$args);
    }
    return $value;
}
function sanitize_key($value) {
    return strtolower(preg_replace('/[^a-z0-9_\-]/', '', (string) $value));
}

require_once dirname(__DIR__) . '/inc/class-entitlement-bridge.php';
require_once dirname(__DIR__) . '/t/class-tophive-modules.php';

if (OneCoreCustomizer_Is_Pro_Activated(true) !== false) {
    fwrite(STDERR, "Runtime gate failed closed-state check.\n");
    exit(1);
}

add_filter('tophive_one_has_entitlement', static function ($default, $feature) {
    return 'one_core' === $feature;
}, 10, 2);

if (OneCoreCustomizer_Is_Pro_Activated(false) !== true) {
    fwrite(STDERR, "Runtime gate failed entitled-state check.\n");
    exit(1);
}

echo "One Core runtime entitlement behavior: PASS\n";
