## Setup
- Run git clone `https://github.com/MattYeend/hrlms.git`
- Run `composer install`
- Copy `.env.example` and rename as `.env`
- Add database configuration, e.g. `DB_DATABASE` and `DB_USERNAME`
- Add mail configuration, e.g. `MAIL_MAILER` and `MAIL_HOST`
- Run `php artisan storage:link` to setup the storage directory
- Run `php artisan key:generate`
- Run `npm install && npm run dev`
- Run `php artisan migrate` and then `php artisan db:seed`
- Run `php artisan serve`

## Misc
- Clear Application Cache: `php artisan cache:clear`
- Clear View Cache: `php artisan view:clear`
- Clear Route Cache: `php artisan route:clear`
- Clear Configuration Cache: `php artisan config:clear`
- Setup Storage Directory: `php artisan storage:link`
- Create new everything (model, migration, controller, policy, requests, seeder): `php artisan make:<modelName> -a`
- Create a new repository: `php artisan make:repository <modelName>Repository`
- Add relevant views (if needed)
- Add relevant route(s) (if needed)
- Run migration (`php artisan migrate`)
- Run individual seeder (`php artisan db:seed --Class=<seederName>`)
- Add seeder to DatabaseSeeder file
- Commit

## How to contribute
- Log an issue
- Add as much information as possible
- Assign it to yourself
- Checkout branch, add issue number to start of branch (from develop branch, `git checkout -b number-short-description-branch`)
- Commit message should start with a hash (#) and the issue number then message of issue
- Push branch
- Create a pull request to fully describe the fix
- Any new text on screen, add to relevant file(s) within the lang/ folder

## Language files
- When creating a new view page, nor new module, ensure there is a relevant language file(s) for said module (or add to existing language file if adding to existing viewable page)
- Ensure the language files makes sense to what it does, e.g. `users.php` for Users