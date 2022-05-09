@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('publisher.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Издатель</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Название" value={{ old('title') }}>
                        </div>
                    </div>
                    @if ($user->can('view-not-approved-'.$publisher_class))
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
            <h3 class="card-title">Издатели</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary" href="{{ route('publisher.create') }}">Добавить</a>
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
                        @foreach ($publishers as $publisher)
                            <tr>
                                <td>{{ $publisher->id }}</td>
                                <td>
                                    {{ $publisher->title }}
                                </td>
                                <td>
                                    @if ($user->can('view-'.$publisher_class))
                                        <a class="btn btn-info" href="{{ route('publisher.show',$publisher->id) }}">Show</a>
                                    @endif
                                    @if ($user->can('update-'.$publisher_class))
                                        <a class="btn btn-primary" href="{{ route('publisher.edit',$publisher->id) }}">Edit</a>
                                    @endif
                                    @if ($user->can('delete-'.$publisher_class))
                                        <form action="{{ route('publisher.destroy',$publisher->id) }}" method="POST">
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
                    {{ $publishers->appends($_GET)->links() }}
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
