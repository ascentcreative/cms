<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Models\ContactRequest;
use AscentCreative\CMS\Notifications\ContactRequestNotification;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;



class ContactController extends Controller
{

  public function showform() {

    headTitle()->add('Contact Us');

    return view('cms::public.contact.showform');

  }

  public function submit() {

    // general input validation:

    $validatedData = request()->validate([
        
        'name' => 'required',
        'email' => 'required|email',

    ]);


    // validate the recaptcha:

    $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
         'secret' => config('cms.recaptcha_secret'),
         'response' => request()->get('g-recaptcha-response'),
         'remoteip' => $_SERVER['REMOTE_ADDR']
    ])->json();



    if(isset($response['error-codes'])) {
        
        //abort('403', $response['error-codes'][0]);

        echo "Well, that's embarrasing... evidently, '" . $response['error-codes'][0] . "', or something...";

       // return redirect('/contact/confirm');

    } else {

        //  log the request either way, along with the returned score. 
        $cr = new ContactRequest();
        $cr->fill(request()->all());
        $cr->recaptcha_score = $response['score'];
        $cr->save();


        echo $response['score'];

        if ($response['score'] < config('cms.recaptcha_threshold')) {
           
           // echo 'Ya BA-SIC';
            
        } else {

            //echo "Woohoo! You're legit";
            // great stuff - process the request.
            Notification::route('mail', 'kieran@ascent-creative.co.uk')
                    ->notify(new ContactRequestNotification($cr));


        }

        // forward to confirmation page.
        // done either way so as not to let on to the spammers...

        return redirect('/contact/confirm');

    }



  }

}