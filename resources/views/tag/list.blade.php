@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('tag.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Тема</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Тема" value={{ old('title') }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category_id" class="form-control category-selection"></select>
                        </div>
                    </div>
                    @if ($user->can('view-not-approved-'.$tag_class))
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Статус</label>
                                <select id="status" name="approved[]" class="form-control approve-selection" multiple="multiple">
                                    @foreach($approved_status as $status => $status_name)
                                        <option value="{{ $status }}" {{ in_array($status,  $approves_list ? $approves_list : []) ? 'selected' : ''}}>{{ $status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button id="submit-filter" type="submit" class="btn btn-primary" form="search-form">Найти</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Темы</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary" href="{{ route('tag.create') }}">Добавить</a>
                </div>
            </div>
            <div style="margin-top: 20px"></div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Тема</th>
                            <th style="width: 40px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>{{$tag->id}}</td>
                                <td>
                                    {{ $tag->title }}
                                    <br> Категория: {{ ($tag->category_id) }}
                                </td>
                                <td>
                                    @if ($user->can('view-'.$tag_class))
                                        <a class="btn btn-info" href="{{ route('tag.show',$tag->id) }}">Show</a>
                                    @endif
                                    @if ($user->can('update-'.$tag_class))
                                        <a class="btn btn-primary" href="{{ route('tag.edit',$tag->id) }}">Edit</a>
                                    @endif
                                    @if ($user->can('delete-'.$tag_class))
                                        <form action="{{ route('tag.destroy',$tag->id) }}" method="POST">
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
            </div>
        </div>
        <div class="card-footer clearfix">
            <div class="row">
                <div class="col-md-3">
                    {{ $tags->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function()
        {
            $('.approve-selection').select2();
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
        });
    </script>
@stop
