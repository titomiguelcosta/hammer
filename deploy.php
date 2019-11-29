<?php

namespace Deployer;

require 'recipe/symfony4.php';

set('application', 'hammer:api');
set('repository', 'https://github.com/titomiguelcosta/hammer.git');
set('git_tty', false);
set('keep_releases', 3);
set('shared_dirs', ['var/log', 'var/sessions', 'vendor']);
set('writable_dirs', ['var', 'var/cache']);
set('composer_action', 'install');
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest');

host('api.hammer.titomiguelcosta.com')
    ->user('ubuntu')
    ->stage('prod')
    ->set('deploy_path', '/mnt/websites/hammer')
    ->set('shared_files', ['.env.prod.local'])
    ->set('http_user', 'www-data')
    ->set('writable_mode', 'acl')
    ->set('branch', 'master')
    ->set('env', ['APP_ENV' => 'prod']);

after('deploy:failed', 'deploy:unlock');
before('deploy:symlink', 'database:migrate');
