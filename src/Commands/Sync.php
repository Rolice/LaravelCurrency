<?php
namespace Rolice\LaravelCurrency\Commands;

use DB;
use App;
use Illuminate\Console\Command;

use Rolice\Econt\Models\Neighbourhood;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Models\Region;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Zone;
use Rolice\LaravelCurrency\ExchangeRate;
use Rolice\LaravelCurrency\Models\Currency;
use Rolice\LaravelCurrency\Repositories\Repository;
use Rolice\LaravelCurrency\Repositories\RepositoryInterface;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes the database with the available currencies through the selected API service.';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function handle()
    {
        /**
         * @var RepositoryInterface $repository
         */
        $repository = App::make('Currency');

        DB::connection('econt')->disableQueryLog();

        $this->comment(PHP_EOL . 'Synchronizing currencies... Please wait while they are fetched up and converted.');

        $currencies = $repository->synchronize();

        $this->comment(PHP_EOL . 'Currencies are now synchronized successfully.');


    }

}