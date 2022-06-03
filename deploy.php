<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'crm');

// Project repository
set('repository', 'git@github.com:guiadriel/crm.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Hosts

host('project.com')
    ->set('deploy_path', '~/{{application}}')
;

// Tasks
desc('Deploy the application');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    // 'rsync', // Deploy code & built assets
    'deploy:secrets', // Deploy secrets
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'artisan:storage:link', // |
    'artisan:view:cache',   // |
    'artisan:config:cache', // | Laravel specific steps
    'artisan:optimize',     // |
    'artisan:migrate',      // |
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

// task('build', function () {
//     run('cd {{release_path}} && build');
// });

// // [Optional] if deploy fails automatically unlock.
// after('deploy:failed', 'deploy:unlock');

// // Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');
