@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>

        <div class="card-body">
            <form id="search-form" action="{{ route('author.search') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Имя</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Имя" value={{ old('name') }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Отчество</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Имя" value={{ old('middle_name') }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Фамилия</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Имя" value={{ old('surname') }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Дата рождения</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Имя" value={{ old('birth_date') }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Дата смерти</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Имя" value={{ old('death_date') }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Год издания</label>
                            <select class="custom-select form-control-border" id="exampleSelectBorder">
                                @foreach($approved_status as $status => $status_name)
                                <option value="{{ $status }}">{{ $status_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                <a class="btn btn-primary" href="{{ route('author.create') }}">Создать</a>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Описание</th>
                        <th style="width: 40px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($authors as $author)
                        <tr>
                            <td>{{$author->id}}</td>
                            <td>
                                {{ $author->name }} {{ $author->middle_name }} {{ $author->surname }}
                                <br> Дата рождения: {{ date('d-m-Y', strtotime($author->birth_date)) }}
                                <br> Дата смерти: {{ date('d-m-Y', strtotime($author->death_date)) }}
                            </td>
                            <td>
                                <a class="btn btn-info" href="{{ route('author.show',$author->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('author.update',$author->id) }}">Edit</a>
                                <form action="{{ route('author.destroy',$author->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col-md-3">
                        {{ $authors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.tags-selection').select2();
        });
    </script>
@stop
