@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('category.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Название" value={{ old('title') }}>
                        </div>
                    </div>
                    @if ($user->can('view-not-approved-'.$category_class))
                        <div class="col-md-6">
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
            <button id="submit-filter" type="submit" class="btn btn-primary" form="search-form">Найти</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Категории</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary" href="{{ route('category.create') }}">Добавить</a>
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
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    {{ $category->title }}
                                </td>
                                <td>
                                    @if ($user->can('view-'.$category_class))
                                        <a class="btn btn-info" href="{{ route('category.show',$category->id) }}">Show</a>
                                    @endif
                                    @if ($user->can('update-'.$category_class))
                                        <a class="btn btn-primary" href="{{ route('category.edit',$category->id) }}">Edit</a>
                                    @endif
                                    @if ($user->can('delete-'.$category_class))
                                        <form action="{{ route('category.destroy',$category->id) }}" method="POST">
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
                    {{ $categories->appends($_GET)->links() }}
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
        });
    </script>
@stop
