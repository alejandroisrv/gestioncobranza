<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ExampleController extends Controller
{
    public function show(Request $request){

            return User::orderBy('created_at','desc')->get();
    }
    public function create(Request $request){
        
        return User::create($request->all());
    }
}
