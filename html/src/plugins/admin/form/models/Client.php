<?php namespace Admin\Form\Models;

use Model;

/**
 * Model
 */
class Client extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    protected $fillable = ['firstname','lastname','email',
                            'dad_initial','phone_number',
                            'street','address_number','block',
                            'staircase','floor','apartement',
                            'county', 'city','income_type',
                            'postal_code','uuid','newsletter'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'admin_form_client';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function downloadFormLink()
    {
        return env('APP_URL') . '/storage/app/uploads/public/formular/' .$this->uuid . '.pdf';
    }
}
