<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UserUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $response = Http::get($request->url)->successful();
        if (!$response){
            return view('welcome', ['http_error' => true]);
        }

        $shortURL = Str::random(8);
        $nameUrl = $request->getHost() . '/' . $shortURL;

        $userUrl = UserUrl::where('name', $request->name)->first();

        if(!isset($userUrl)){
            $userUrl = new UserUrl();
            $userUrl->name = $request->name;
            $userUrl->save();
        }

        $url = Url::where('url', $request->url)
                ->where('shot_url', $nameUrl)
                ->where('user_url_id', $userUrl->id)
                ->first();

        if(!isset($url)){
            $url = new Url();
            $url->url = $request->url;
            $url->shot_url = $nameUrl;
            $url->user_url_id = $userUrl->id;
            $url->save();
        }

        return view('welcome', ['url' => $request->url, 'shot_url' => $url->shot_url]);
    }

    public function stats(Request $request)
    {
        if(isset($request->shot_url)){
            $url = Url::where('shot_url', $request->shot_url)
                    ->first();
            $url->count = $url->count + 1;
            $url->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $nameUser = UserUrl::where('name', $request->user_name)->first();

        if (!isset($nameUser)){
            return view('welcome', ['table' => false]);
        }

        $userUrls = UserUrl::find($nameUser->id)->urls;

        return view('welcome', ['table' => true, 'name_user' => $nameUser, 'urls' => $userUrls]);
    }
}
