<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fail-closed authorization adapter for One demo imports.
 *
 * One Core never stores or derives license state. It consumes the generated
 * AnyLicense manager for the One theme and asks the canonical runtime enforcer
 * whether the signed installation authorization permits this boundary.
 */
final class One_Core_Demo_License_Gate
{
    private const PRODUCT_SLUG = 'one';
    private const BOUNDARY = 'demo_import';

    public static function allows(): bool
    {
        $managers = $GLOBALS['anylicense_license_managers'] ?? null;
        if (!is_array($managers)) {
            return false;
        }

        $manager = $managers[self::PRODUCT_SLUG] ?? null;
        if (!is_object($manager) || !method_exists($manager, 'runtimeEnforcer')) {
            return false;
        }

        try {
            $enforcer = $manager->runtimeEnforcer();
            return is_object($enforcer)
                && method_exists($enforcer, 'allowsBoundary')
                && true === $enforcer->allowsBoundary(self::BOUNDARY);
        } catch (Throwable $error) {
            return false;
        }
    }

    public static function boundary(): string
    {
        return self::BOUNDARY;
    }
}
