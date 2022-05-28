<?php

namespace App\Http\Controllers;

use App\DTO\UserDataTransferObject;
use App\Http\Requests\UserSearchRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Book;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Spatie\Permission\Models\Role;

//TODO: Добавить сюда репу
class UserController extends Controller
{
    private $userRepository;

     /**
     *
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(UserRepositoryInterface $userRepository){
        $this->userRepository = $userRepository;
        $this->authorizeResource(User::class);
    }
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
    protected function resourceMethodsWithoutModels(): array
    {
        return ['index', 'create', 'store'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserSearchRequest $request)
    {

        $usersArray = $this->userRepository->getBySearch(new UserDataTransferObject(
            $request->name,
            $request->email,
            $request->verified,
            $request->roles
        ));
        return response()->view('user.list',[
            'users'=>$usersArray,
            'request'=>$request,
            'roles'=>Role::all()->pluck('name'),
            'pageTitle' => __('Пользователи')
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->view('user.show',[
            'user_class'=>User::class,
            'book_class'=>Book::class,
            'target_user'=>$user,
            'user'=>Auth::user(),
            'pageTitle' => __($user->name)
        ]);
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->redirectTo('register');
    }
    /**
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return response()->redirectTo('register');
    }
    /**
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->view('user.edit',[
            'user'=>$user,
            'pageTitle' => __($user->name)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $userDTO = new UserDataTransferObject(
            $request->name,
            $request->email,
            ($request->email==$user->email) ? null : false
        );
        $this->userRepository->update($user->id, $userDTO);
        // $user->update(array_merge(
        //     $request->only('name', 'email'),
        //     ['password' => bcrypt($request->password)],
        // ));
        return response()->redirectToRoute('user.show',['user' => $user->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->id == $user->id) 
            return redirect()->back()->with('error', 'Вы не можете удалить себя');
        return $this->userRepository->delete($user->id) ? 
            response()->redirectToRoute('user.index')->with('success', 'Пользователь удалён') :
            response()->redirectToRoute('user.index')->with('error', 'Не удалось удалить пользователя');
    }
    /**
     * Set to user an moderator permissions
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function op(User $user)
    {
        if (Auth::user()->id == $user->id) 
            return redirect()->back()->with('error', 'Вы не можете повысить себя');
        $user->assignRole('Библиотекарь');
        return response()->redirectToRoute('user.show',['user' => $user->id]);
    }
    /**
     * Remove an moderator permissions
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deop(User $user)
    {
        if (Auth::user()->id == $user->id) 
            return redirect()->back()->with('error', 'Вы не можете понизить себя');
        $user->removeRole('Библиотекарь');
        return response()->redirectToRoute('user.show',['user' => $user->id]);
    }
    /**
     * Ban user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function ban(User $user)
    {
        if (Auth::user()->id == $user->id) 
            return redirect()->back()->with('error', 'Вы не можете заблокировать себя');
        $user->syncRoles(['Заблокированный']);
        return response()->redirectToRoute('user.show',['user' => $user->id]);
    }
    /**
     * unban user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function unban(User $user)
    {
        if (Auth::user()->id == $user->id) 
            return redirect()->back()->with('error', 'Вы не можете разблокировать себя');
        $user->syncRoles(['Читатель']);
        return response()->redirectToRoute('user.show',['user' => $user->id]);
    }
}
