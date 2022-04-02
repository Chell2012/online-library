@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>

        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Название</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Название">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Категория</label>
                            <select class="custom-select form-control-border" id="exampleSelectBorder">
                                <option>Value 1</option>
                                <option>Value 2</option>
                                <option>Value 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Isbn</label>
                            <input type="text" class="form-control form-control-border" id="exampleInputBorder" placeholder="Название">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Издательство</label>
                            <select class="custom-select form-control-border" id="exampleSelectBorder">
                                <option>Value 1</option>
                                <option>Value 2</option>
                                <option>Value 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Год издания</label>
                            <select class="custom-select form-control-border" id="exampleSelectBorder">
                                <option>Value 1</option>
                                <option>Value 2</option>
                                <option>Value 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleSelectBorder">Темы</label>
                            <select class="form-control tags-selection" multiple="multiple">
                                <option selected="selected">300$</option>
                                <option>fisting</option>
                                <option>spanking</option>
                                <option>next door</option>
                            </select>
                        </div>
                    </div>
                </div>


            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
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
                            <td>{{ $book->title }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('book.show',$book->id) }}">Show</a>
                                <a class="btn btn-primary" href="{{ route('book.update',$book->id) }}">Edit</a>
                                <form action="{{ route('book.destroy',$book->id) }}" method="POST">
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
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
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
