<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
	protected $response; protected $data ;
	public function __construct()
    {
        $this->data = array();$this->response = array();
    }
    public function getMemberToken(Request $request)
    {
    	$this->response = array();
    	try {
		   	$this->response['status'] = TRUE;
		   	$this->response['user_token'] = encrypt($request->input('contact'));
		} catch (DecryptException $exception) {
		   	$this->response['status'] = FALSE;
		   	$this->response['message'] = $exception->getMessage();
		}
		return \Response::json($this->response, 200);
    }
    
}
