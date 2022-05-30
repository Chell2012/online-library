@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Пользователь</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>Имя: {{ $target_user->name }}</p>
                    <p>Почта: {{ $target_user->email }} Подтверждена: {{ $target_user->email_verified_at ? $target_user->email_verified_at : "Нет" }}</p>
                    <p>
                        Роли: 
                        @foreach ($target_user->roles as $role)
                            {{ $role->name }},
                        @endforeach
                    </p>
                    <p>Дата регистрации: {{ date('d-m-Y', strtotime($user->created_at)) }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                    <div class="col-md-2">
                        <a class="btn btn-primary" href="{{ route('user.edit',$target_user->id) }}">Редактировать</a>
                    </div>
                @if ($user->can('delete-'.$user_class))
                    <div class="col-md-2">
                        <form action="{{ route('user.destroy',$target_user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                @endif
                @if (($user->can('ban-'.$user_class) && (!$target_user->hasRole('Заблокированный'))))
                    <div class="col-md-2">
                        <form action="{{ route('user.ban',$target_user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Заблокировать</button>
                        </form>
                    </div>
                @endif
                @if (($user->can('unban-'.$user_class) && ($target_user->hasRole('Заблокированный'))))
                    <div class="col-md-2">
                        <form action="{{ route('user.unban',$target_user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">Разблокировать</button>
                        </form>
                    </div>
                @endif
                @if (($user->can('update-'.$user_class)) && (!$target_user->hasAnyRole(['Администратор', 'Библиотекарь', 'Читатель', 'Заблокированный'])))
                    <div class="col-md-2">
                        <form action="{{ route('user.allow',$target_user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">Сделать читателем</button>
                        </form>
                    </div>
                @endif
                @if (($user->can('op-'.$user_class) && (!$target_user->hasRole('Библиотекарь'))))
                    <div class="col-md-2">
                        <form action="{{ route('user.op',$target_user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">Назначить библиотекарем</button>
                        </form>
                    </div>
                @endif
                @if (($user->can('deop-'.$user_class) && ($target_user->hasRole('Библиотекарь'))))
                    <div class="col-md-2">
                        <form action="{{ route('user.deop',$target_user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Разжаловать библиотекаря</button>
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
@section('js')
@stop