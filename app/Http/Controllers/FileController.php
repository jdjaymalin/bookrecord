<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Book;

class FileController extends Controller {

    public function import() {
        return view('import');
    }

    public function upload(Request $request){
        $rules = array(
            'bookrecord' => 'required|mimes:csv,txt',
          );
        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect('/books/import')
                ->withErrors('Please upload a valid CSV file');
        }

        $file = array_get($request,'bookrecord');
        $destinationPath = 'uploads';
        $extension = $file->getClientOriginalExtension();
        $filename = 'bookrecord.csv';
        $success = $file->move($destinationPath, $filename);

        if ($success) {
            return redirect('/books/write')
                //->with('message', 'Records have been imported successfully');
                ->with('filename',$filename);
        }
        return redirect('/books/import')
            ->withError('There was a problem with your file'); 
    }

}
