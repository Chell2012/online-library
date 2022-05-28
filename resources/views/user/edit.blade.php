@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Редактирование</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('user.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Имя</label>
                            <input name="name" type="text" class="form-control form-control-border" placeholder="Имя" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Электронная почта</label>
                            <input name="email" type="email" class="form-control form-control-border" placeholder="Электронная почта" value="{{ $user->email }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button id="submit-filter" type="submit" class="btn btn-primary" form="search-form">Сохранить</button>
        </div>
    </div>
@stop
