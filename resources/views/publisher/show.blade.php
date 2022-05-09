@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Издатель</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>Тема: {{ $publisher->title }}</p>
                    <p>Опубликовано: {{ $approved_status[$publisher->approved] }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                @if ($user->can('update-'.$publisher_class))
                    <div class="col-md-1">
                        <a class="btn btn-primary" href="{{ route('publisher.edit',$publisher->id) }}">Edit</a>
                    </div>
                @endif
                @if ($user->can('delete-'.$publisher_class))
                    <div class="col-md-1">
                        <form action="{{ route('publisher.destroy',$publisher->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                @endif
                <div class="col-md-6"></div>
                @if ($user->can('approve-'.$publisher_class))
                    <div class="col-md-3">
                        <form action="{{ route('publisher.approve') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Статус</label>
                                <input name="id" type="hidden" class="form-control form-control-border" value={{ $publisher->id }}>
                                <select name="approved" class="form-control">
                                    @foreach($approved_status as $status => $status_name)
                                        <option value="{{ $status }}" {{ ($publisher->approved == $status)?"selected":"" }}>{{ $status_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Подтвердить</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <a class="btn btn-primary" href="{{ url()->previous() }}">Назад</a>
        </div>
    </div>
@stop
