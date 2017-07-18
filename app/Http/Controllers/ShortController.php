<?php

namespace App\Http\Controllers;

use App\Shortener;
use Illuminate\Http\Request;

class ShortController extends Controller
{
    public function index()
    {
        $short = Shortener::all();
        $name = 'Rakshya';
        $age = '22';
        //TODO research how to send multiple item..

        //TODO : ->with('name', $name)
        // ->withName($name)
        //->with(['name'=>$name])
        //


        //return view('short.index', compact('short'))->with('name', $name)->with('age', $age);
        return view('short.index', compact('short'))->with(['age' => $age, 'name' => $name]);
    }

    public function create()
    {
        $shortener = new Shortener;
         return view('short.create', compact('shortener'));
    }

    public function redirectToFullURL($token)
    {
        $token = strtolower($token);

        $shortener = Shortener::where('short_url', $token)->first();

        if ($shortener === null) {
            return redirect('/')->with('status', 'Oops it donot have any short url');

        }

        //TODO what if we do not find that url? send to home page with message saying not found...

        return redirect($shortener->long_url);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        //TODO validate that the url is actually a url..but this how?

        $url = $input['long_url'];

        $existing_short_url = Shortener::where('long_url', $url)->first();

        if($existing_short_url != null)
        {
            $message = "Your Short URL is: " . url($existing_short_url->short_url);
            return redirect('/')->with('status', $message);
        }

        /*if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return redirect('/')->with('status', 'Oops you have entered invalid url');
        }*/

        $headers = get_headers($url);

        if (!$headers) {
            return redirect('/')->with('status', 'The url is completely invalid, host not found');
            //means the url is completely invalid, host not found
            //means tell user his url is not valid, return with errors
        }

        $responseText = $headers[0];

        if (strpos($responseText, '404')) {
            return redirect('/')->with('status', '404 Error, the url that you have entered is not found');
            //404 was found in the response text//
        }

        // https://www.google.com.np/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwjil62OzdjTAhUBp48KHW0lCcwQFgghMAA&url=https%3A%2F%2Fgiphy.com%2Fsearch%2Ffunny-cat&usg=AFQjCNEQ7Mfc8Zvwaiw7SIU4ZffTSnhetg&sig2=lwg-Utd8oJzIOopqZK6y1w

        while (true) {

            $input['short_url'] = strtolower(str_random(8));
            $shortener = Shortener::where('short_url', $input['short_url'])->first();

            if ($shortener === null) {
                break;
            }

        };


        //TODO validate that short_url is unique


        //BUT if NOT unique, we must still get a valid one for the user, so loop until we get unique--> generate -> check in db -> if not unique repeat

        Shortener::create($input);

        $message = "Your Short URL is: " . url($input['short_url']);
        return redirect('/')->with('status', $message);
        //return redirect('short');

    }

}
