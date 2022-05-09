@extends('layouts.app')
@section('plugins.Select2', true)
@section('content') 
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редактирование</h3>
        </div>
        <div class="card-body">
            <form id="update-form" action="{{ route('publisher.update',$publisher->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Издатель</label>
                            <input name="title" type="text" class="form-control form-control-border" placeholder="Издатель" value="{{ $publisher->title }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button id="submit-filter" type="submit" class="btn btn-primary" form="update-form">Сохранить</button>
        </div>
    </div>
@stop
@section('js')
    <script>
    </script>
@stop

