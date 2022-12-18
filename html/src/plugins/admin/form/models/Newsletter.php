<?php namespace Admin\Form\Models;

use Model;

/**
 * Model
 */
class Newsletter extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    protected $fillable = [ 'email', ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'admin_form_newsletter';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
