# AdminPHP website

The website of [AdminPHP](https://github.com/adminphp-cms/core): the presentation of the project, with
articles and pages edited in its own AdminPHP admin.

## Run it locally

It expects the [core](https://github.com/adminphp-cms/core) repository cloned next to it, in an
`adminphp` folder, and uses it through a symlink: changes to the package show up on the site at once.

```bash
git clone git@github.com:adminphp-cms/core.git adminphp
git clone git@github.com:adminphp-cms/website.git adminphp-website
cd adminphp-website
composer run setup
php artisan storage:link
php artisan db:seed
```

`db:seed` fills the site with demo content and users (`admin@example.com`, password `password`).

## Where things are

- The presentation page: `resources/views/landing.blade.php`.
- The AdminPHP modules, blocks and settings: `app/AdminPhp`, registered in `AppServiceProvider`.
- The views of the blocks: `resources/views/blocks`.

## Tests

```bash
composer test
```
