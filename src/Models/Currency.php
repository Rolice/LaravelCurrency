<?php
namespace Rolice\LaravelCurrency\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['refreshed_at'];

    public function base()
    {
        $this->belongsTo(self::class);
    }

}