<?php

/**
 * ============================================================
 *  Universal Installer Script (Simplified)
 *  Compatible with Linux & Windows
 * ============================================================
 */

define('MIN_PHP_VERSION', '8.2.0');
define('REPO_URL', 'https://github.com/lukheman/pak-ginjal.git');
define('REPO_DIR', 'pak-ginjal');

function isWindows(): bool
{
    return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
}

function line(string $text = ''): void
{
    echo $text . PHP_EOL;
}

function status(string $icon, string $msg): void
{
    line("  {$icon}  {$msg}");
}

function ok(string $msg): void    { status('✔', $msg); }
function warn(string $msg): void  { status('⚠', $msg); }
function fail(string $msg): void  { status('✖', $msg); }
function info(string $msg): void  { status('➜', $msg); }

function run(string $cmd): bool
{
    $proc = proc_open($cmd, [STDIN, STDOUT, STDERR], $pipes);
    if (!is_resource($proc)) {
        return false;
    }
    return proc_close($proc) === 0;
}

function commandExists(string $cmd): bool
{
    return run((isWindows() ? 'where ' : 'command -v ') . $cmd);
}

// ============================================================
//  Step 1 – Check dependencies
// ============================================================
function checkDependencies(): bool
{
    line();
    line('== STEP 1/4: Checking Dependencies ==');

    $ok = true;

    if (version_compare(PHP_VERSION, MIN_PHP_VERSION, '>=')) {
        ok('PHP ' . PHP_VERSION . ' detected (min: ' . MIN_PHP_VERSION . ')');
    } else {
        fail('PHP ' . PHP_VERSION . ' is below the required minimum ' . MIN_PHP_VERSION);
        $ok = false;
    }

    foreach (['git', 'composer'] as $tool) {
        if (commandExists($tool)) {
            ok(ucfirst($tool) . ' detected.');
        } else {
            fail(ucfirst($tool) . ' not found.');
            $ok = false;
        }
    }

    if (!$ok) {
        fail('Some dependencies are missing. Installation stopped.');
    }

    return $ok;
}

// ============================================================
//  Step 2 – Clone repository
// ============================================================
function gitClone(): bool
{
    line();
    line('== STEP 2/4: Downloading Repository ==');

    if (is_dir(REPO_DIR)) {
        warn("Folder '" . REPO_DIR . "' already exists, using it.");
        return true;
    }

    info('Cloning: ' . REPO_URL);

    if (run('git clone ' . REPO_URL . ' ' . REPO_DIR)) {
        ok('Repository cloned successfully.');
        return true;
    }

    fail('Failed to clone repository.');
    return false;
}

// ============================================================
//  Step 3 – Enter repository directory
// ============================================================
function enterDirectory(): bool
{
    line();
    line('== STEP 3/4: Entering Repository Directory ==');

    if (!is_dir(REPO_DIR) || !chdir(REPO_DIR)) {
        fail("Could not enter directory '" . REPO_DIR . "'.");
        return false;
    }

    ok('Now in: ' . getcwd());
    return true;
}

// ============================================================
//  Step 4 – Run setup.php
// ============================================================
function runSetup(): bool
{
    line();
    line('== STEP 4/4: Running setup.php ==');

    if (!file_exists('setup.php')) {
        fail('setup.php not found in: ' . getcwd());
        return false;
    }

    info('Running: php setup.php');

    if (run('php setup.php')) {
        ok('setup.php finished successfully.');
        return true;
    }

    fail('setup.php failed.');
    return false;
}

// ============================================================
//  Summary
// ============================================================
function printSummary(array $steps): void
{
    line();
    line('== INSTALLATION SUMMARY ==');

    $allOk = true;
    foreach ($steps as $name => $success) {
        status($success ? '✔' : '✖', $name);
        if (!$success) {
            $allOk = false;
        }
    }

    line();
    line($allOk ? '🎉 Installation completed successfully!' : '⚠ Installation finished with errors.');
    line();
    line('Developer : Akmal');
    line('Instagram : @lukheeman');
    line('Portfolio : https://lukheman.github.io/portfolio/');
}

// ============================================================
//  MAIN
// ============================================================
function main(): void
{
    line('Universal Installer — Linux & Windows Compatible');
    line('OS      : ' . (isWindows() ? 'Windows' : 'Linux/Unix'));
    line('PHP     : ' . PHP_BINARY);
    line('Cwd     : ' . getcwd());

    $steps = [
        'Check Dependencies' => checkDependencies(),
    ];

    if (!$steps['Check Dependencies']) {
        printSummary($steps);
        exit(1);
    }

    $steps['Git Clone'] = gitClone();
    if (!$steps['Git Clone']) {
        printSummary($steps);
        exit(1);
    }

    $steps['Enter Directory'] = enterDirectory();
    if (!$steps['Enter Directory']) {
        printSummary($steps);
        exit(1);
    }

    $steps['Run setup.php'] = runSetup();

    printSummary($steps);
    exit($steps['Run setup.php'] ? 0 : 1);
}

main();
