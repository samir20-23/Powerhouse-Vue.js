 <?php

namespace App\Http\Controllers;

abstract class Controller
{
   
public function index(){
$variable =     'just for test';
 return view('index',compact(''));
}
}
