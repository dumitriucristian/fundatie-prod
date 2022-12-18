<?php namespace Admin\Form\Components;

use Validator;
use Input;
use Illuminate\Support\Facades\Redirect;
use Cms\Classes\ComponentBase;
use Admin\Form\Models\Contact;
use ValidationException;
use Mail;

class ContactForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Contact Form',
            'description' => 'Contact form to send emails',
        ];
    }

    public function onSave()
    {
        $data = post();
       // dd($data);
        $validator = Validator::make($data,
        [
            'verificare' => ['numeric','size:8'],
            'name' => ['required','string','max:254',],
            'subject' => ['required','string','max:254','min:3',],
            'email' => ['required','string','max:254','email'],
            'phone_number' => ['nullable','string'],
            'text' => ['required','string'],
        ],

        [  
            'verificare.numeric' => 'Trebuie sa fie numar',
            'verificare.size' => 'Compoletati codul de verificare corecct',
            'verificare.required'=> 'Compoletati codul de verificare corect',
            'name.required' => 'Numele trebuie completat.',
            'name.string' => 'Numele trebuie sa fie text',
            'name.max' => 'Numele trebuie sa aiba maxim :max caractere.',

            'subject.required' => 'Subiectul trebuie completat.',
            'subject.string' => 'Subiectul trebuie sa fie text',
            'subject.max' => 'Subiectul trebuie sa aiba maxim :max caractere.',
            'subject.min' => 'Subiectul trebuie sa aiba minim :min caractere',

            'email.required' => 'Email-ul trebuie completat',
            'email.string' => 'Email-ul trebuie sa fie un text',
            'email.max' => 'Email-ul trebuie sa aiba maxim :max caractere',
            'email.email' => 'Email-ul nu este o adresa de email valida',

            'phone_number.string' => 'Numarul de telefon trebuie sa fie text',
            'phone_number.size' => 'Numarul de telefon trebuie sa aiba :size caractere',

            'text.required' => 'Textul trebuie completat',
            'text.string' => 'Textul trebuie sa fie text', 
        ]);

        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
        else 
        {
            
            Contact::create($data);
            Mail::send('admin.form::mail.contact',$data,function($message) use ($data) {

                $message->replyTo($data["email"]);
                $message->to(config('mail.from.address'));
                $message->subject($data["subject"]);
               

            });
    
            return Redirect::to('success');
        }
    }
}

