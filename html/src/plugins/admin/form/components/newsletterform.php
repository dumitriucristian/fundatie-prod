<?php namespace Admin\Form\Components;

use Cms\Classes\ComponentBase;
use Admin\Form\Models\Newsletter;
use Validator;
use Input;
use Illuminate\Support\Facades\Redirect;
use ValidationException;


class NewsletterForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Newsletter Form',
            'description' => 'Form to create a newsletter subscriber',
        ];
    }

    public function onSave()
    {
        $data = [
            'email' => Input::get('email'),
        ];

        $validator = Validator::make($data,
        [
            'email' => ['required','string','max:254','email','unique:admin_form_newsletter,email'],
        ],
        [
            'email.required' => 'Email-ul trebuie completat',
            'email.string' => 'Email-ul trebuie sa fie un text',
            'email.max' => 'Email-ul trebuie sa aiba maxim :max caractere',
            'email.email' => 'Email-ul nu este o adresa de email valida',
            'email.unique' => 'Adresa de email exista deja in baza de date',
        ]);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
        else 
        {
            Newsletter::create($data);
            return Redirect::to('success');
        }

    }

    public function onRedirect(){
       return  Redirect::to('/success');
    }
}


