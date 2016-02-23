<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Book;

class BookController extends Controller {

    public function index() {

        $title = session('title');
        $author = session('author');

        $books = $this->_getBooks($title,$author);

        return view('index')
            ->with(['books'  => $books,
                    'title'  => $title,
                    'author' => $author,
                    'order'  => 'desc'
                   ]);
    }

    public function store(Request $request) { 
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'author' => 'required|max:255',
        ]);
        if ($validator->fails()) {
            return redirect('/books')
                ->withInput()
                ->withErrors($validator);
        }
        $this->_insert($request->title,$request->author);

        return redirect('/books');
    }

    public function destroy($id) {
        Book::findOrFail($id)->delete();
        return redirect('/books');
    }

    public function show($id) {
        return redirect('/books');
    }

    public function search(Request $request) {
        return redirect('/books')
            ->with(['title'  => $request->title,
                    'author' => $request->author
                  ]);
    }

    public function sort(Request $request) {
        $books = $this->_getBooks($request->title,$request->author);

        if ($request->column) {
            if ($request->order == 'asc'){
                $books = $books->sortBy($request->column);  
            }
            else {
                $books = $books->sortByDesc($request->column);  
            }
        }

        return view('index')
            ->with(['books'  => $books,
                    'order'  => $request->order,
                    'column' => $request->column,
                    'title'  => $request->title,
                    'author' => $request->author
                  ]);
    }

    public function write() {
        $filename = session('filename');
        $content = File::get('uploads/'.$filename);
        $contentArr = preg_split("/\r\n|\n|\r/", $content);
        foreach($contentArr as $line) {
              $data = explode(',',$line);
              $this->_insert($data[0],$data[1]);
        }
        
        return redirect('/books')
            ->with('message', 'Records have been imported successfully');

    }

    private function _insert($title,$author) {
        $book = new Book;
        $book->title = $title;
        $book->author = $author;
        $book->save();
    }

    private function _getBooks($title,$author) {
        if ($title || $author) {
            $books = Book::where('title', 'LIKE', "%$title%")
                ->where('author', 'LIKE', "%$author%")
                ->get();
        }
        else {
            $books = Book::all();
        }
        return $books;
    }

}
