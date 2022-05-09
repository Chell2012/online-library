@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>

        <div class="card-body">
            <form id="search-form" action="{{ route('book.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Название</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Название" value="{{ $request->title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Авторы</label>
                            <select name="author_id[]" class="form-control author-selection" multiple="multiple">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Isbn</label>
                            <input name="isbn" type="text" class="form-control form-control-border" placeholder="Isbn" value="{{ $request->isbn }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Издательство</label>
                            <select name="publisher_id" class="custom-select publisher-selection">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Год издания</label>
                            <input type="number" min="0000" max="2030" step="1" name="year" class="form-control form-control-border" value="{{ $request->year }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Темы</label>
                            <select name="tag_id[]" class="custom-select tags-selection" multiple="multiple">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category_id" class="custom-select category-selection">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($user->can('view-not-approved-'.$book_class))
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Статус</label>
                                <select id="status" name="approved[]" class="form-control approve-selection" multiple="multiple">
                                    @foreach($approved_status as $status => $status_name)
                                        <option value="{{ $status }}">{{ $status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="search-form">Submit</button>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Каталог книг</h3>
            </div>
            <div class="card-body">
                <a class="btn btn-primary" href="{{ route('book.create') }}">Создать</a>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Описание</th>
                        <th style="width: 40px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{$book->id}}</td>
                            <td>
                                {{ $book->title }} <br>
                                @foreach ($book->authors as $author)
                                    {{ $author->surname }} {{ $author->name }} {{ $author->middle_name }},
                                @endforeach 
                                {{ $book->publisher->title }} {{ $book->year }}
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{ route('book.show',$book->id) }}">Show</a>
                                @if ($user->can('update-'.$book_class))
                                <a class="btn btn-primary" href="{{ route('book.edit',$book->id) }}">Edit</a>
                                @endif
                                @if ($user->can('delete-'.$book_class))
                                <form action="{{ route('book.destroy',$book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-3">
                        {{ $books->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.author-selection').select2({
                placeholder: 'Авторы',
                ajax: {
                    url: '/author',
                    dataType: 'json',
                    delay: 500,
                    type: "GET",
                    data: function (params)
                    {
                        return {
                            surname: params.term,
                            pagination: 0,
                            return_json:1,
                        };
                    },
                    processResults: function (data)
                    {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.surname+' '+item.name+' '+item.middle_name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('.category-selection').select2({
                placeholder: 'Категория',
                ajax: {
                    url: '/category',
                    dataType: 'json',
                    delay: 500,
                    type: "GET",
                    data: function (params)
                    {
                        return {
                            title: params.term,
                            pagination: 0,
                            return_json:1,
                        };
                    },
                    processResults: function (data)
                    {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.title,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('.publisher-selection').select2({
                placeholder: 'Издатель',
                ajax: {
                    url: '/publisher',
                    dataType: 'json',
                    delay: 500,
                    type: "GET",
                    data: function (params)
                    {
                        return {
                            title: params.term,
                            pagination: 0,
                            return_json:1,
                        };
                    },
                    processResults: function (data)
                    {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.title,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('.tags-selection').select2({
                placeholder: 'Темы',
                ajax: {
                    url: '/tag',
                    dataType: 'json',
                    delay: 500,
                    type: "GET",
                    data: function (params)
                    {
                        return {
                            title: params.term,
                            pagination: 0,
                            return_json:1,
                        };
                    },
                    processResults: function (data)
                    {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.title,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('.approve-selection').select2();
        });
    </script>
@stop
