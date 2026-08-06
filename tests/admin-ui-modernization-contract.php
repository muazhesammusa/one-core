<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$importPhp = file_get_contents($root . '/inc/admin/demo-import.php');
$importCss = file_get_contents($root . '/inc/admin/demo-import.css');
$importJs = file_get_contents($root . '/inc/admin/demo-import.js');
$importUiJs = file_get_contents($root . '/inc/admin/demo-import-ui.js');
$package = json_decode((string) file_get_contents($root . '/package.json'), true);

$assertions = [
    'demo import source readable' => is_string($importPhp),
    'demo import stylesheet readable' => is_string($importCss),
    'demo import runtime readable' => is_string($importJs),
    'demo option UI readable' => is_string($importUiJs),
    'demo assets scoped to importer page' => str_contains($importPhp, "'one' !== \$page || 'importer' !== \$tab"),
    'demo card uses modern shell' => str_contains($importPhp, 'one-core-demo-banner__icon') && str_contains($importPhp, 'one-core-demo-banner__copy'),
    'demo modal has structured heading' => str_contains($importPhp, 'bp-demo-modal-heading'),
    'demo modal close has no positional inline style' => str_contains($importPhp, 'class="bp-demo-modal-close"') && !str_contains($importPhp, 'style="position:absolute;right:12px;top:12px;"'),
    'license-required state uses shared action primitive' => str_contains($importPhp, 'one-admin-button one-admin-button--primary'),
    'canonical One admin URL used' => str_contains($importPhp, "themes.php?page=one&tab=license") && str_contains($importPhp, "themes.php?page=one&tab=importer"),
    'required import options default on' => str_contains($importPhp, "'customizer' => true")
        && str_contains($importPhp, "'menus' => true")
        && str_contains($importPhp, "'buddypress' => true"),
    'bbPress remains optional and defaults off' => str_contains($importPhp, "'forums' => false"),
    'BuddyPress setup is available as a dedicated step' => str_contains($importPhp, "case 'configure_buddypress':")
        && str_contains($importPhp, 'bp_demo_configure_buddypress()'),
    'BuddyPress activation redirect is suppressed for importer AJAX' => str_contains($importPhp, "pre_transient__bp_activation_redirect")
        && str_contains($importPhp, "remove_action('bp_admin_init', 'bp_do_activation_redirect', 1)")
        && str_contains($importPhp, "header_remove('Location')")
        && str_contains($importPhp, "page=bp-components"),
    'importer assets use file modification cache versions' => str_contains($importPhp, 'filemtime($worker_path)')
        && str_contains($importPhp, 'filemtime($ui_path)')
        && str_contains($importPhp, 'filemtime($style_path)'),
    'BuddyPress admin form helper is not used by AJAX' => !str_contains($importPhp, 'bp_core_admin_get_active_components_from_submitted_settings'),
    'BuddyPress community components are activated' => str_contains($importPhp, "['groups', 'friends', 'messages']"),
    'BuddyPress full schema install is not run during AJAX' => !str_contains($importPhp, 'bp_core_install($active_components)')
        && str_contains($importPhp, "'bp_core_install_friends'")
        && str_contains($importPhp, "'bp_core_install_private_messaging'")
        && str_contains($importPhp, 'one_demo_database_table_exists'),
    'missing activity dataset is not scheduled' => !str_contains($importUiJs, "step: 'import_activities'")
        && !str_contains($importPhp, "case 'import_activities':"),
    'Customizer mods are written in one option update' => str_contains($importPhp, "update_option('theme_mods_' . get_option('stylesheet')")
        && str_contains($importPhp, '$merged_mods')
        && !str_contains($importPhp, 'foreach ($mods as $mod => $val)'),
    'Custom CSS import does not echo into AJAX' => str_contains($importPhp, 'wp_update_custom_css_post')
        && !str_contains($importPhp, 'Custom CSS post created with ID'),
    'BuddyPress community options are activated' => str_contains($importPhp, "bp_update_option('bp-enable-members-invitations', 1)")
        && str_contains($importPhp, "bp_update_option('bp-enable-membership-requests', 1)")
        && str_contains($importPhp, "bp_update_option('one_enable_user_profile_invitation', 1)"),
    'AJAX catches PHP errors as JSON' => str_contains($importPhp, 'catch (Throwable $e)'),
    'importer stops after server or transport failure' => str_contains($importJs, 'stopImport(responseMessage')
        && str_contains($importJs, 'ajaxFailureMessage(xhr, status, error)')
        && str_contains($importJs, 'stopImport(`${step}:' )
        && !str_contains($importJs, 'setTimeout(runNextStep, 800)'),
    'runtime Tailwind CDN dependency removed' => !str_contains($importPhp, 'cdn.tailwindcss.com')
        && !str_contains($importUiJs, 'grid-cols-')
        && str_contains($importCss, '.one-demo-options'),
    'legacy groups-only setup step removed' => !str_contains($importPhp, "case 'enable_groups_component':")
        && !str_contains($importPhp, 'bp_demo_enable_groups_component_properly'),
    'unsupported integrations removed from importer config' => !str_contains($importPhp, "'events' =>")
        && !str_contains($importPhp, "'woocommerce' =>")
        && !str_contains($importPhp, "'directory' =>")
        && !str_contains($importPhp, "'job_manager' =>")
        && !str_contains($importPhp, "'courses' =>")
        && !str_contains($importPhp, "'pmp' =>")
        && !str_contains($importPhp, "'media_pages' =>"),
    'extension demo routes removed' => !str_contains($importPhp, "case 'import_exported_demo':")
        && !str_contains($importPhp, "case 'import_extension_demos':")
        && !str_contains($importPhp, "case 'create_media_pages':"),
    'modal css has modern overlay' => str_contains($importCss, 'backdrop-filter: blur(6px)') && str_contains($importCss, 'box-shadow: 0 36px 100px'),
    'demo card css is responsive' => str_contains($importCss, '@media (max-width: 782px)') && str_contains($importCss, '.one-core-demo-banner'),
    'test command includes contract' => isset($package['scripts']['test']) && str_contains($package['scripts']['test'], 'admin-ui-modernization-contract.php'),
];

$failed = [];
foreach ($assertions as $label => $passed) {
    if (!$passed) {
        $failed[] = $label;
    }
}

if ($failed !== []) {
    fwrite(STDERR, "One Core admin UI modernization contract failed:\n- " . implode("\n- ", $failed) . "\n");
    exit(1);
}

echo "One Core admin UI modernization contract: PASS\n";
