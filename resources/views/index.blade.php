@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Book
                </div>
                <div class="panel-body">
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <form action="/books" method="POST">
                        <div class="form-group">
                            <label for="book-title" class="control-label">Title</label>
                            <input type="text" name="title" id="book-title" class="form-control" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="book-author" class="control-label">Author</label>
                            <input type="text" name="author" id="book-author" class="form-control" value="{{ old('author') }}">
                        </div>
                        {{ csrf_field() }}

                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-btn fa-plus"></i>Add Book
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Search Book
                </div>

                <div class="panel-body">
                    <form action="/books/search" method="POST">
                        <div class="form-group">
                            <label for="book-title" class="control-label">Title</label>
                            <input type="text" name="title" id="book-title" class="form-control" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="book-author" class="control-label">Author</label>
                            <input type="text" name="author" id="book-author" class="form-control" value="{{ old('author') }}">
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-btn fa-plus"></i>Search
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-offset-1 col-sm-10">
            @if (count($books) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Book List
                    </div>

                    <div class="panel-body">
                        @if ( session()->has('message') )
                        <div class="alert alert-success">
                              {{ session('message') }}
                        </div>
                        @endif
                        <table class="table table-striped book-table">
                            <thead>
                                @if ($order == 'desc')
                                <th>
                                <a href="{{ action('BookController@sort',array(
                                        'column' => 'title', 
                                        'order' => 'asc', 
                                        'title' => $title,
                                        'author' => $author )) 
                                    }}">Title
                                </th>
                                <th>
                                <a href="{{ action('BookController@sort',array(
                                        'column' => 'author', 
                                        'order' => 'asc', 
                                        'title' => $title,
                                        'author' => $author)) 
                                    }}">Author
                                </th>
                                @else
                                <th>
                                <a href="{{ action('BookController@sort',array(
                                        'column' => 'title', 
                                        'order' => 'desc', 
                                        'title' => $title,
                                        'author' => $author)) 
                                    }}">Title
                                </th>
                                <th>
                                <a href="{{ action('BookController@sort',array(
                                        'column' => 'author', 
                                        'order' => 'desc', 
                                        'title' => $title,
                                        'author' => $author)) 
                                    }}">Author
                                </th>
                                @endif
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr>
                                        <td class="table-text"><div>{{ $book->title }}</div></td>
                                        <td class="table-text"><div>{{ $book->author }}</div></td>

                                        <td>
                                            <form action="/books/{{ $book->id }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                  <button type="submit" class="btn btn-danger">
                                                      <i class="fa fa-trash"/></i>
                                                  </button>
                                              </form>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              @endif
              </div>
          </div>
      </div>
  @endsection
