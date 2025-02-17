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