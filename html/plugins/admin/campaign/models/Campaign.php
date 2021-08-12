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

    /* Relations */
    public $attachOne = [
        'picture' => 'System\Models\File',
    ];

    public $belongsTo = [
        'campaign_type' => 'Admin\Campaign\Models\CampaignType',
    ];

    public function getPercentageMoney() :int
    {
        return $this->raised_money*100 / $this->target_money;
    }

}
