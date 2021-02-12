<?php

use craft\test\TestSetup;

ini_set('date.timezone', 'UTC');

define('CRAFT_TESTS_PATH', __DIR__);
define('CRAFT_STORAGE_PATH', __DIR__ . '/_craft/storage');
define('CRAFT_TEMPLATES_PATH', __DIR__ . '/_craft/templates');
define('CRAFT_CONFIG_PATH', __DIR__ . '/_craft/config');
define('CRAFT_MIGRATIONS_PATH', __DIR__ . '/_craft/migrations');
define('CRAFT_TRANSLATIONS_PATH', __DIR__ . '/_craft/translations');
//define('CRAFT_VENDOR_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor');

// Use absolute path if the plugin directory is a symlink
define('CRAFT_VENDOR_PATH', '/Users/ben/Sites/craft3/vendor');

$devMode = true;

TestSetup::configureCraft();

// Set the @webroot alias so that the cpresources folder is created in the correct directory
Craft::setAlias('@webroot', __DIR__ . '/_craft/web');

// Prevent `headers already sent` error
ob_start();
