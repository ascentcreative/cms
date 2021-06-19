<?php

namespace AscentCreative\CMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
use Illuminate\Database\Eloquent\Model;

use AscentCreative\CMS\Models\ContactRequest;
use AscentCreative\CMS\Notifications\ContactRequestNotification;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;

use AscentCreative\CMS\Settings\SiteSettings;


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
    $check = true;

    if (config('cms.recaptcha_sitekey')) {

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('cms.recaptcha_secret'),
            'response' => request()->get('g-recaptcha-response'),
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ])->json();

        if(isset($response['error-codes'])) {
            $check = false;
        } 

    } else {

       // $check = true; // we're not using a captcha, so just allow it. 

    }



    if(!$check) {
        
        //abort('403', $response['error-codes'][0]);

        echo "Well, that's embarrasing... evidently, '" . $response['error-codes'][0] . "', or something...";

       // return redirect('/contact/confirm');

    } else {

        //  log the request either way, along with the returned score. 
        $cr = new ContactRequest();
        $cr->fill(request()->all());
        $cr->recaptcha_score = $response['score'];
        $cr->save();

        if ($response['score'] < app(SiteSettings::class)->contact_recaptcha_threshold) { //config('cms.recaptcha_threshold')) {
           
           // echo 'Ya BA-SIC';
            
        } else {

            //echo "Woohoo! You're legit";
            // great stuff - process the request.

            $ary = explode(',', app(SiteSettings::class)->contact_to_addresses);
            $recips = collect($ary)->transform(function($item) { 
                return trim($item);
            });

            Notification::route('mail', $recips )  //config('cms.contact.notify'))
                    ->notify(new ContactRequestNotification($cr));


        }

        // forward to confirmation page.
        // done either way so as not to let on to the spammers...

        return redirect('/contact/confirm');

    }



  }

}