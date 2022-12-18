<?php namespace Admin\Form\Models;

use Model;

/**
 * Model
 */
class Contact extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    protected $fillable = ['email','name','phone_number','text','subject'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'admin_form_contact';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
