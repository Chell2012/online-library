@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>

        <div class="card-body">
            <form id="create-form" action="{{ route('book.update',['book' => $book->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label> Название</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Название" value="{{ $book->title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Авторы</label>
                            <select name="author_id[]" class="form-control author-selection" multiple="multiple">
                                @foreach($book->authors as $author)
                                    <option value="{{ $author->id }}" selected>{{ $author->surname }} {{ $author->name }} {{ $author->middle_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Isbn</label>
                            <input name="isbn" type="text" class="form-control form-control-border" placeholder="Isbn" value="{{ $book->isbn }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Издательство</label>
                            <select name="publisher_id" class="custom-select publisher-selection">
                                <option value="{{ $book->publisher_id }}">{{ $book->publisher->title }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Год издания</label>
                            <input name="year" type="number" min="0000" max="2030" step="1" class="form-control form-control-border" value="{{ $book->year }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Темы</label>
                            <select name="tag_id[]" class="custom-select tags-selection" multiple="multiple">
                                @foreach($book->tags as $tag)
                                    <option value="{{ $tag->id }}" selected>{{ $tag->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category_id" class="custom-select category-selection">
                                <option value="{{ $book->category_id }}">{{ $book->category->title }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Ссылка на источник</label>
                            <input name="link" type="text" class="form-control form-control-border" placeholder="Ссылка" value="{{ $book->link }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="description" type="text" class="form-control" placeholder="Описание">{{ $book->description }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="create-form">Сохранить</button>
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