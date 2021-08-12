<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
//TODO: Добавить сюда репу
class UserController extends Controller
{
    /**
     * Add filter to resource list for policy action
     * 
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'view',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'op' => 'op',
            'deop' => 'deop',
            'ban' => 'ban',
            'unban' => 'unban',
        ];
    }
    /**
     * Add filter to actions without model dependency for policy action
     * 
     * @return array 
     */
    protected function resourceMethodsWithoutModels()
    {
        return ['index', 'create', 'store'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->password)],
        ));
        $user->assignRole('reader');

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(User::query()->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::query()->find($id);
        $user->update(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->password)],
        ));
        if(!$user->hasAnyRole(['admin', 'librarian'])||($request->role != 'admin')||($request->role!='librarian')){
            $user->assignRole($request->role);
        }
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = false;
        $user = User::query()->find($id);
        if(!$user->hasAnyRole(['admin', 'librarian'])){
            $result = response()->json($user->delete());
        }
        return response()->json($result);
    }
    /**
     * Set to user an moderator permissions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function op($id)
    {
        $user = User::query()->find($id);
        $user->assignRole('librarian');
        return response()->json($user);
    }
    /**
     * Remove an moderator permissions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deop($id)
    {
        $user = User::query()->find($id);
        $user->removeRole('librarian');
        return response()->json($user);
    }
    /**
     * Set to user an moderator permission
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ban($id)
    {
        $user = User::query()->find($id);
        if(!$user->hasAnyRole(['admin', 'librarian'])){
            $user->syncRoles(['banned']);
        }
        return response()->json($user);
    }
    /**
     * Set to user an moderator permission
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unban($id)
    {
        $user = User::query()->find($id);
        if(!$user->hasRole('banned')){
            $user->syncRoles(['reader']);
        }
        return response()->json($user);
    }
}
