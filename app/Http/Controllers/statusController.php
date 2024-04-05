<?php

namespace App\Http\Controllers;

use App\Models\statusModel;
use Illuminate\Http\Request;

class statusController extends Controller
{
    public function indexs(){
        return view('list');
     }

     public function stores(Request $request){

        $datastatus = $request->validate([
        ]);
        if ($request->has('datastatus')) {
            $checkboxValue = $request->input('datastatus');

            statusModel::create([
                'datastatus' => $checkboxValue,
            ]);


        } else {

        }

        return redirect()->back();


     }
}
