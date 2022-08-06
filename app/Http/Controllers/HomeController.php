<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nepster\Matrix\Matrix;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
    */
    public function index(Request $request)
    {
        // return view('home');
        return view('website.homepage');
    }
    public function webteam(Request $request)
    {
        return view('website.webteam');   
    }
    public function privacypolicy(Request $request)
    {
        return view('website.privacypolicy');
    }
    public function faq(Request $request)
    {
        return view('website.faq');
    }
    public function career(Request $request)
    {
        return view('website.career');
    }
    public function aboutus(Request $request)
    {
        return view('website.aboutus');
    }
    public function contact(Request $request)
    {
        return view('website.contact');
    }
    public function termsandconditions()
    {
        return view('website.termsandconditions');
    }



    public function homepage(Request $request)
    {
    	return redirect()->route('dashboard');
        // return view('website.homepage');
    }
    public function syncwallet(Request $request)
    {
    	$client = new \GuzzleHttp\Client();
    	$request = new \GuzzleHttp\Psr7\Request('POST', 'https://paidkaro.in/API/roundpaycallbackurlgetcall/S210924234785107ACD5');
		$promise = $client->sendAsync($request)->then(function ($response) {
		    dd($response->getBody());
		});
		$promise->wait();
    	exit();


        // $client = new \GuzzleHttp\Client();$allMembers = \App\Member::all();
        // $request = new \GuzzleHttp\Psr7\Request('POST', 'http://paidkaro.in/API/lfc_wallet',['Content-Type'=>'application/json']);
        // $promise = $client->sendAsync($request)->then(function($response) {
        //     $apiresponse = json_decode($response->getBody());
        //     foreach ($apiresponse->member_data as $key => $apiMember) :
        //         $lfcMember = \App\Member::where('contact',$apiMember->contact)->first();
        //         if (!empty($lfcMember)) {
        //             $parentBonus = \App\MemberBonusAmount::where('member_id',$lfcMember->id)->first();
        //             $parentBonus->bonus_amount = floatval($apiMember->amount);$parentBonus->save();

        //             $lfcMember->is_paidkaro_member = 1;$lfcMember->save();
        //         }
        //     endforeach ;
        // });
        // $promise->wait();
    }
}
