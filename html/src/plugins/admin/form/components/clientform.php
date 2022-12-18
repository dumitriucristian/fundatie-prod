<?php 
namespace Admin\Form\Components;

use Cms\Classes\ComponentBase;
use Admin\Form\Models\Client;
use Validator;
use Input;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\Facades\Image;
use ValidationException;
use Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;
use Imagick;
use iio\libmergepdf\Merger;
use Log;

class ClientForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'form',
            'description' => 'Donation form',
        ];
    }

    public function onSave()
    {
        
        $data = [
            'firstname' => Input::get('firstname'),
            'lastname' => Input::get('lastname'),
            'email' => Input::get('email'),
            'dad_initial' => Input::get('dad_initial'),
            'phone_number' => Input::get('phone_number'),
            'street' => Input::get('street'),
            'address_number' => Input::get('address_number'),
            'block' => Input::get('block'),
            'staircase' => Input::get('staircase'),
            'floor' => Input::get('floor'),
            'apartement' => Input::get('apartement'),
            'county' => Input::get('county'),
            'city' => Input::get('city'),
            'income_type' => 'pensie/salariu',//Input::get('income_type'),
            'postal_code' => Input::get('postal_code'), 
            'acord' => Input::get('acord'),
            'cnp' => Input::get('cnp'),
            'newsletter' => Input::get('newsletter')
        ];
   

        $validator = Validator::make($data,
        [
            'firstname' => ['required','string','max:254'],
            'lastname' => ['required','string','max:254'],
            'email' => ['required','string','max:254','email'],
            'dad_initial' => ['required','string','max:4'],
            'phone_number' => ['required','string'],
            'street' => ['required','string','max:254'],
            'address_number' => ['required','string','max:10'],
            'block' => ['nullable','string','max:10'],
            'staircase' => ['nullable','string','max:10'],
            'floor' => ['nullable','integer',],
            'apartement' => ['nullable','string','max:10'],
            'county' => ['required','string','max:70'],
            'city' => ['required','string','max:70'],
            'income_type' => ['required','in:pensie/salariu,alta'],
            'postal_code' => ['numeric',"max:999999"],
            'acord' => ['required'],
            'cnp' => ['required','min:13']
        ],
        [
            'firstname.required' => 'Prenumele trebuie completat',
            'firstname.string' => 'Prenumele trebuie sa fie un text',
            'firstname.max' => 'Prenumele trebuie sa aiba maxim :max caractere',

            'lastname.required' => 'Numele trebuie completat',
            'lastname.string' => 'Numele trebuie sa fie un text',
            'lastname.max' => 'Numele trebuie sa aiba maxim :max caractere',

            'email.required' => 'Email-ul trebuie completat',
            'email.string' => 'Email-ul trebuie sa fie un text',
            'email.max' => 'Email-ul trebuie sa aiba maxim :max caractere',
            'email.email' => 'Email-ul nu este o adresa de email valida',
            'email.unique' => 'Adresa de email exista deja in baza de date',


            'postal_code.numeric' => 'Codul postal trebuie sa fie un numar',
            'postal_code.max' => 'Codul postal trebuie sa aiba 6 cifre',
           

            'dad_initial.required' => 'Initiala tatalui trebuie completat',
            'dad_initial.string' => 'Initiala tatalui trebuie sa fie un text',
            'dad_initial.max' => 'Initiala tatalui trebuie sa aiba maxim :max caractere',

            'phone_number.required' => 'Numarul de telefon trebuie completat',
            'phone_number.string' => 'Numarul de telefon trebuie sa fie un text',
            'phone_number.size' => 'Numarul de telefon trebuie sa aiba :size caractere',
            'phone_number.unique' => 'Numarul de telefon exista deja in baza de date',

            'street.required' => 'Strada trebuie completat',
            'street.string' => 'Strada trebuie sa fie un text',
            'street.max' => 'Strada trebuie sa aiba maxim :max caractere',

            'address_number.required' => 'Numarul trebuie completat',
            'address_number.string' => 'Numarul trebuie sa fie un text',
            'address_number.max' => 'Numarul trebuie sa aiba maxim :max caractere',

            'block.string' => 'Blocul trebuie sa fie un text',
            'block.max' => 'Blocul trebuie sa aiba maxim :max caractere',

            'staircase.string' => 'Scara trebuie sa fie un text',
            'staircase.max' => 'Scara trebuie sa aiba maxim :max caractere',

            'floor.integer' => 'Scara trebuie sa fie un numar',
            
            'apartement.string' => 'Scara trebuie sa fie un text',
            'apartement.max' => 'Scara trebuie sa aiba maxim :max caractere',

            'county.required' => 'Judetul trebuie completat',
            'county.string' => 'Judetul trebuie sa fie un text',
            'county.max' => 'Judetul trebuie sa aiba maxim :max caractere',

            'city.required' => 'Orasul trebuie completat',
            'city.string' => 'Orasul trebuie sa fie un text',
            'city.max' => 'Orasul trebuie sa aiba maxim :max caractere',

            'income_type.required' => 'Tipul de venit trebuie completat',
            'acord.required' => 'Pentru a putea continua este necesar acordul dumneavoastra.',

            'cnp.required' => 'Pentru a putea continua este necesar cnp-ul',
            'cnp.min' => 'CNP-ul are min 13 caractere',
        ]);
  
        if($validator->fails())
        {
            throw new ValidationException($validator);
        }
       
           
        $fileType= "jpg";
        $originalImage = Storage::disk('local')->get('uploads/public/230-1.jpg');
        $img = Image::make($originalImage)->fit(800,1131)->encode($fileType);
       
        $data['newsletter'] = (is_null($data['newsletter'])) ? 0 : 1;

        $year = Carbon::now()->year;
        
        // Create year
        $i=0;
        while($year !== 0)
        {
            $number = $year % 10;
            $year = intval($year/10);
            $img->text($number, 486 - $i*25, 138, function ($font) {
                $font->color('#000');
                $font->size(12);
                $font->align('left');
                $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
                $font->valign('top');
            });
            $i++;
        }

        $img->text($data['lastname'], 92, 207, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        $img->text($data['firstname'], 92, 237, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        $img->text($data['dad_initial'], 403, 205, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        $img->text($data['street'], 92, 268, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        $img->text($data['address_number'], 392, 268, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        if(isset($data['block']))
            $img->text($data['block'], 64, 296, function ($font) {
                $font->color('#000');
                $font->size(12);
                $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
                $font->align('left');
                $font->valign('top');
            });
        
        if(isset($data['staircase']))
            $img->text($data['staircase'], 154, 296, function ($font) {
                $font->color('#000');
                $font->size(12);
                $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
                $font->align('left');
                $font->valign('top');
            });

        if(isset($data['floor']))
            $img->text($data['floor'], 202, 296, function ($font) {
                $font->color('#000');
                $font->size(12);
                $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
                $font->align('left');
                $font->valign('top');
            });

        if(isset($data['apartement']))
            $img->text($data['apartement'], 250, 296, function ($font) {
                $font->color('#000');
                $font->size(12);
                $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
                $font->align('left');
                $font->valign('top');
            });
        
        $img->text($data['county'], 348, 296, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        $img->text($data['city'], 93, 326, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });

        

        // Create cnp
        $i=0;
        $cnp = $data['cnp'];
        while($cnp !== 0)
        {
            $number = $cnp % 10;
            $cnp = intval($cnp/10);
            $img->text($number, 752 - $i*25, 220, function ($font) {
                $font->color('#000');
                $font->size(12);
                $font->align('left');
                $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
                $font->valign('top');
            });
            $i++;
        }
        

        $img->text($data['phone_number'], 498, 287, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });
        $postalCode = empty($data['postal_code']) ? ' ' : $data['postal_code'];
        $img->text($postalCode, 362, 325, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });


        $img->text($data['email'], 494, 249, function ($font) {
            $font->color('#000');
            $font->size(12);
            $font->file(storage_path('fonts/OpenSans-Regular.ttf'));
            $font->align('left');
            $font->valign('top');
        });
        
        $data['uuid'] = Str::uuid();
     
        $img->save(storage_path('app/uploads/public/formular/' . $data['uuid'] . '.' .$fileType));
        
        // convert from jpg to pdf
        $imgFirstForm = storage_path('app/uploads/public/formular/' . $data['uuid'] . '.' .$fileType);
       
        

        $pdf = new Imagick($imgFirstForm);

        $pdf->setImageFormat('pdf');
        $pdfFromImage = storage_path('app/uploads/public/formular/' . $data['uuid'] . '.pdf');
        $pdf->writeImage($pdfFromImage);
        
        // delete old jpg
        if (!unlink($imgFirstForm)) { 
            throw new Exception('file was not found!'); 
        }
      
        $client = Client::create($data);
   
       // merge the 2 pdfs
        $merger = new Merger;
        $merger->addIterator([$pdfFromImage, storage_path('app/uploads/230-2-b.pdf')]);
        $createdPdf = $merger->merge();
        // delete old pdf
        if (!unlink($pdfFromImage)) { 
            throw new Exception('file was not found!'); 
        }
         // save merged pdf
        try{
            file_put_contents(storage_path('app/uploads/public/formular/' . $data['uuid'] . '.pdf'), $createdPdf);
        }catch(Exception $e){
            Log::critical("334 - clientForm");
        }
    
        return Redirect::to('formular/' . $data['uuid']);
        
    }
    
}