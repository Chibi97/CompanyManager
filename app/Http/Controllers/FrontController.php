<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function home()
    {
//        $client = new Client();
//        $resp = $client->request('get','http://companymanager.oljaivkovic.space');
//        //dd($resp->getStatusCode());
        return view('home_inc.job_offers');
    }
}
