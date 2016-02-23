@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Import Books
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

                    <form action="/books/upload" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="book-title" class="control-label">CSV File</label>
                            <input type="file" name="bookrecord" id="book-title" class="form-control">
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-btn fa-plus"></i>Add Book
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
