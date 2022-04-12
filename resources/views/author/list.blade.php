@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('author.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Имя</label>
                            <input name="name" type="text" class="form-control form-control-border" placeholder="Имя" value={{ old('name') }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Отчество</label>
                            <input name="middle_name" type="text" class="form-control form-control-border" placeholder="Отчество" value={{ old('middle_name') }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Фамилия</label>
                            <input name="surname" type="text" class="form-control form-control-border" placeholder="Фамилия" value={{ old('surname') }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Дата рождения</label>
                            <input name="birth_date" type="date" class="form-control form-control-border" value={{ old('birth_date') }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Дата смерти</label>
                            <input name="death_date" type="date" class="form-control form-control-border" value={{ old('death_date') }}>
                        </div>
                    </div>
                    @if ($user->can('view-not-approved-'.$author_class))
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
            <h3 class="card-title">Авторы</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-primary" href="{{ route('author.create') }}">Добавить</a>
                </div>
            </div>
            <div style="margin-top: 20px"></div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Автор</th>
                            <th style="width: 40px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($authors as $author)
                            <tr>
                                <td>{{$author->id}}</td>
                                <td>
                                    {{ $author->name }} {{ $author->middle_name }} {{ $author->surname }}
                                    <br> Дата рождения: {{ ($author->birth_date) ? date('d-m-Y', strtotime($author->birth_date)): 'Отсутствует' }}
                                    <br> Дата смерти: {{ ($author->death_date) ? date('d-m-Y', strtotime($author->death_date)): 'Отсутствует' }}
                                </td>
                                <td>
                                    @if ($user->can('view-'.$author_class))
                                        <a class="btn btn-info" href="{{ route('author.show',$author->id) }}">Show</a>
                                    @endif
                                    @if ($user->can('update-'.$author_class))
                                        <a class="btn btn-primary" href="{{ route('author.edit',$author->id) }}">Edit</a>
                                    @endif
                                    @if ($user->can('delete-'.$author_class))
                                        <form action="{{ route('author.destroy',$author->id) }}" method="POST">
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
                    {{ $authors->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.approve-selection').select2();
        });
    </script>
@stop
