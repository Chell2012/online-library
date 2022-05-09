@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('author.store') }}" method="POST">
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
                </div>


            </form>
        </div>
        <div class="card-footer">
            <button id="submit-filter" type="submit" class="btn btn-primary" form="search-form">Сохранить</button>
        </div>
    </div>
@stop
