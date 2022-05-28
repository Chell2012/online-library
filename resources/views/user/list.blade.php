@extends('layouts.app')
@section('plugins.Select2', true)
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Фильтр</h3>
        </div>
        <div class="card-body">
            <form id="search-form" action="{{ route('user.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Имя</label>
                            <input name="name" type="text" class="form-control form-control-border" placeholder="Имя" value={{ $request->name }}>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Электронная почта</label>
                            <input name="email" type="email" class="form-control form-control-border" placeholder="Электронная почта" value={{ $request->email }}>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p>Подтверждён</p>
                        <div class="form-check">
                            <input id="verified-true" name="verified" type="radio" class="form-check-input" value=1 {{ $request->verified == true ? 'checked' : ''}}> 
                            <label class="form-check-label" for="verified-true"> Да </label>
                        </div>  
                        <div class="form-check">  
                            <input id="verified-false" name="verified" type="radio" class="form-check-input" value=0 {{ $request->verified == false ? 'checked' : ''}}> 
                            <label class="form-check-label" for="verified-false"> Нет </label>
                        </div>
                        <div class="form-check">
                            <input id="verified-none" name="verified" type="radio" class="form-check-input" value='' {{ $request->verified == null ? 'checked' : ''}}> 
                            <label class="form-check-label" for="verified-none"> Не важно </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Роли</label>
                            <select id="roles" name="roles[]" class="form-control approve-selection" multiple="multiple">
                                @foreach($roles as $role)
                                    <option value="{{ $role }}" {{ in_array($role,  $request->roles ? $request->roles : []) ? 'selected' : ''}}>{{ $role }}</option>
                                @endforeach
                            </select>
                            <?php print_r($request->roles); ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button id="submit-filter" type="submit" class="btn btn-primary" form="search-form">Найти</button>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Пользователи</h3>
        </div>

        <div class="card-body">
            <div style="margin-top: 20px"></div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Пользователь</th>
                            <th style="width: 40px"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>
                                    {{ $user->name }} 
                                    <br> Почта: {{ $user->email }} Подтверждена: {{ $user->email_verified_at ? $user->email_verified_at : "Нет" }}
                                    <br> Роль: 
                                    @foreach ($user->getRoleNames() as $role_name)
                                     {{ $role_name }},
                                    @endforeach
                                </td>
                                <td>
                                        <a class="btn btn-info" href="{{ route('user.show',$user->id) }}">Подробнее</a>
                                        <a class="btn btn-primary" href="{{ route('user.edit',$user->id) }}">Редактировать</a>
                                        <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Удалить</button>
                                        </form>
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.approve-selection').select2();
        });
    </script>
@stop
