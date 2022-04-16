@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редактирование</h3>
        </div>
        <div class="card-body">
            <form id="update-form" action="{{ route('tag.update',$tag->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Тема</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Тема" value={{ old('title') }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            <select name="category_id" class="form-control category-selection"></select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button id="submit-filter" type="submit" class="btn btn-primary" form="update-form">Submit</button>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function()
        {
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
                            return_json: 1,
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

