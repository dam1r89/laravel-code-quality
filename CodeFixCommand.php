<?php

namespace dam1r89\CodeQuality;

use Illuminate\Console\Command;

class CodeFixCommand extends Command
{
    protected $signature = 'code:fix {--last-commit=1}';

    protected $description = 'Fix code style';

    public function handle()
    {
        $files = 'git diff --name-only --cached --diff-filter=ACMRTUXB HEAD';
        $files = $files . '~' . $this->option('last-commit');

        passthru("$files | xargs php ./vendor/bin/php-cs-fixer fix --path-mode=intersection --config=.php_cs.dist  --using-cache=no", $status);

        passthru("./node_modules/eslint/bin/eslint.js --fix `$files | grep '^resources/assets/js.*\.\(vue\|js\)\$'`", $status2);

        return (int) ($status || $status2);
    }
}
