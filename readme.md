# Set of commands that help maintaining code quality in Laravel projects.

## Installation

	composer require --dev dam1r89/laravel-code-quality

## About

Intended for Laravel type of projects with **VueJS** on frontend. Relys on `phpunit` for testing code before commit, 
`php-cs-fixer` and `es-lint` to lint/fix the code and `git` to install **precommit** hook.

It is analyzing only code that is added to index.

It also puts `.editorconfig` file in a root directory.

Commands:

Install git pre commit hook

	php artisan code:install-hooks

Runs php-cs-fixer fix and eslint fix commands

	php artisan code:fix 

Manually run lint

	php artisan code:lint

