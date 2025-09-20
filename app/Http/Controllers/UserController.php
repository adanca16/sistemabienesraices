<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query()
            ->when($request->filled('search'), function($qq) use ($request) {
                $term = '%'.$request->search.'%';
                $qq->where(function($w) use ($term){
                    $w->where('name','like',$term)
                      ->orWhere('email','like',$term);
                });
            })
         ;
        $users = $q->paginate(15)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:120'],
            'email'    => ['required','email','max:160','unique:users,email'],
            'password' => ['required','string','min:8'],
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return redirect()->route('users.show', $user)->with('ok','Usuario creado.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required','string','max:120'],
            'email'    => ['required','email','max:160', Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:8'], // opcional al editar
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('users.show', $user)->with('ok','Usuario actualizado.');
    }

    public function destroy(User $user)
    {
        // evita que un usuario se borre a sí mismo si querés
        // if (auth()->id() === $user->id) { return back()->with('error','No podés borrarte.'); }

        $user->delete();

        return redirect()->route('users.index')->with('ok','Usuario eliminado.');
    }
}
