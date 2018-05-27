<?php

namespace dam1r89\CodeQuality;

use Illuminate\Console\Command;

class CodeFixCommand extends Command
{
    protected $signature = 'code:fix';

    protected $description = 'Fix code style';

    public function handle()
    {
        passthru('git diff --name-only --cached --diff-filter=ACMRTUXB | xargs php ./vendor/bin/php-cs-fixer fix --path-mode=intersection --config=.php_cs.dist  --using-cache=no', $status);

        passthru("./node_modules/eslint/bin/eslint.js --fix `git diff --name-only --cached --diff-filter=AM HEAD | grep '^resources/assets/js.*\.\(vue\|js\)\$'`", $status2);

        return (int) ($status || $status2);
    }
}
