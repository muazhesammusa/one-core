<?php
$filters = [];
function add_filter($tag, $callback, $priority = 10, $accepted_args = 1) {
    global $filters;
    $filters[$tag][] = $callback;
    return true;
}
function add_action($tag, $callback, $priority = 10, $accepted_args = 1) { return true; }
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

$root = dirname(__DIR__);
require_once $root . '/inc/class-entitlement-bridge.php';
require_once $root . '/t/class-tophive-modules.php';

if (OneCoreCustomizer_Is_Pro_Activated(true) !== false) {
    fwrite(STDERR, "Commercial entitlement filter must fail closed when licensing is inactive/unavailable.\n");
    exit(1);
}

$module = file_get_contents($root . '/t/class-tophive-modules.php') ?: '';
if (!preg_match('/function\s+OneCoreCustomizer_Init\s*\(\s*\)\s*\{(?P<body>.*?)\n\}/s', $module, $match)) {
    fwrite(STDERR, "Could not inspect OneCoreCustomizer_Init runtime bootstrap.\n");
    exit(1);
}
$moduleBody = $match['body'];
if (strpos($moduleBody, 'EntitlementBridge::has') !== false || strpos($moduleBody, '$c->init();') === false) {
    fwrite(STDERR, "Frontend module runtime is not fail-open when licensing is inactive/unavailable.\n");
    exit(1);
}

$bootstrap = file_get_contents($root . '/one-core.php') ?: '';
if (!preg_match('/public function init_entitled_runtime\s*\(\s*\)\s*\{(?P<body>.*?)\n\s*\}/s', $bootstrap, $match)) {
    fwrite(STDERR, "Could not inspect One Core base runtime bootstrap.\n");
    exit(1);
}
$baseBody = $match['body'];
if (strpos($baseBody, 'EntitlementBridge::has') !== false || strpos($baseBody, "add_action('wp_enqueue_scripts'") === false) {
    fwrite(STDERR, "One Core base frontend runtime is not fail-open when licensing is inactive/unavailable.\n");
    exit(1);
}

add_filter('tophive_one_has_entitlement', static function ($default, $feature) {
    return 'one_core' === $feature;
}, 10, 2);

if (OneCoreCustomizer_Is_Pro_Activated(false) !== true) {
    fwrite(STDERR, "Commercial entitlement filter failed entitled-state check.\n");
    exit(1);
}

echo "One Core runtime entitlement behavior: PASS\n";
