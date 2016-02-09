# Laravel Currency
Laravel package that uses external API services to download rates and stores them in database for further use.
This package is aiming to serve as currency conversions by extracting exchange rates and caching them in database and
in high level cache engines.

Supported Framework Versions: **>= 5.1**.

## Installation
To install the package you should require it from the composer repository. This is done either by executing a require command `coposer require rolice/laravel-currency` or by adding manually the requirement line in your `composer.json` like:

```json
{
  "require": {
    "rolice/laravel-currency": "dev-master",
  },
}
```

When the package is installed in your project vendor directory you can easily enable the package via its service provider. To do this add a line in `config/app.php` in the section `providers` (an existing config array):

```php
Rolice\LaravelCurrency\ServiceProvider::class
```

Now the package is turned on, but you should prepare the database and to publish package content:

`php artisan vendor:publish`

When the content is published you should edit `config/laravel-currency/laravel-currency.php` - the main package configuration file, particulary the `connection` setting where you should define the connection to the database you want to keep the information about currency rates. When you are ready with that you can execute table creation and setup with the help of the artisan command below.

`php artisan migrate`

The two lines above will publish configurations and migrations to the project directories - `config/` and `database/migrations`. After that the migration will be executed and new table will be created on the configured connection.

Now you are ready. The package is installed and ready for use.

## Synchronization
You can invoke a synchronization via executing the package command `Sync`. This is done with artisan like: `php artisan currency:sync`. You can set this command as scheduled with the comand `Kernel`.

```php
// ...
class Kernel extends ConsoleKernel
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    // some other previously registered commands
    \Rolice\LaravelCurrency\Commands\Sync::class, // Add this line in the console kernel
  ];
  
  protected function schedule(Schedule $schedule)
  {
      // Register periodic schedule for the command like. You can specify interval by yourself.
      $schedule->command('currency:sync')->monthly();
  }
}
```

## Usage
The package will define its own routes and controller by default - `<base>/currency`. On it you can call a list of all currencies or call a conversion like: `<base>/currency/convert?from=<currency_code>&to=<currency_code>&amount=<amount>`

The conversion will automatically convert the amount from the given currency to the targeted one. The amount parameter is optional, if ommitted it will default to `1` - the exact conversion rate. The currency codes are the official 3-character ISO code of the desired currency.

You will receive a JSON response with a number on success or object containing errors occurred on failure.
Example for successful conversion is:

### Request
`http://<yourdomain.com>/currency/convert?from=BGN&to=EUR`

### Response
```json
0.509279
```
