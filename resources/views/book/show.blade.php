@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $book->title }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    
                </div>
                <div class="col-md-9">
                    <h1>{{ $book->title }}</h1>
                    <p>
                        @foreach ($book->authors as $author)
                        {{ $author->surname }} {{ $author->name }} {{ $author->middle_name }},
                        @endforeach
                    </p>
                    <p>Издатель: {{ $book->publisher->title }}</p>
                    <p>Год: {{ $book->year }}</p>
                    <p>Isbn: {{ $book->isbn }}</p>
                    <p>Темы: <b>{{ $book->category->title }}</b>
                        @foreach ($book->tags as $tag)
                        , {{ $tag->title }}
                        @endforeach
                        .
                    </p>
                    <p>Ссылка: <a href="{{  $book->link }}">{{  $book->link }}</a></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p>{{ $book->description }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                @if ($user->can('update-'.$book_class))
                    <div class="col-md-1">
                        <a class="btn btn-primary" href="{{ route('book.edit',$book->id) }}">Edit</a>
                    </div>
                @endif
                @if ($user->can('delete-'.$book_class))
                    <div class="col-md-1">
                        <form action="{{ route('book.destroy',$book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endif
                <div class="col-md-6"></div>
                @if ($user->can('approve-'.$book_class))
                    <div class="col-md-3">
                        <form action="{{ route('book.approve') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Статус</label>
                                <input name="id" type="hidden" class="form-control form-control-border" value={{ $book->id }}>
                                <select name="approved" class="form-control">
                                    @foreach($approved_status as $status => $status_name)
                                        <option value="{{ $status }}" {{ ($book->approved == $status)?"selected":"" }}>{{ $status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Подтвердить</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <a class="btn btn-primary" href="{{ url()->previous() }}">Назад</a>
        </div>
    </div>
@stop
@section('js')
@stop
