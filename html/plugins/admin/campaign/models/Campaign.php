<?php namespace Admin\Campaign\Models;

use Model;

/**
 * Model
 */
class Campaign extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'admin_campaign_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
