<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Image;

class UserController extends Controller
{

    public function index()
    {
        $listar = User::all();
        return view('usuarios.listar', ['usuarios' => $listar]);
    }


    public function cadastrar(Request $request)
    {
        if($request->input('role')){
            switch ($request->input('role')){
                case 1:
                    $request->merge(array('role_name' => "Administrador"));
                    break;

                case 2:
                    $request->merge(array('role_name' => "Responsável"));
                    break;

                case 3:
                    $request->merge(array('role_name' => "Atendente"));
                    break;

                case 4:
                    $request->merge(array('role_name' => "Suporte"));
                    break;

                case 5:
                    $request->merge(array('role_name' => "At. Temporário"));
                    break;
            }
        }

        //var_dump($request->input('role_name'));

        /*if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' .$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/avatars/'.$filename));
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }*/

        User::create($request->all());
        return response()->redirectToRoute('admin.listar.usuarios');

    }



    public function editar($id)
    {
        $listar = DB::select('SELECT * FROM users WHERE id = '.$id);
        return view('usuarios.editar', ['usuario' => $listar]);
    }


    public function editar_update(Request $request, $id)
    {
        $param = $request->all();
        $pass = $param['password'];

        if($pass == NULL) {
            $param = $request->except(['_token', 'sendForm', 'password']);
            var_dump($request->all());
        }else{
            $param = $request->except(['_token','sendForm']);
            $request['password'] = bcrypt($request['password']);
            var_dump($request->all());
        }

        //var_dump($request->all());
        $param = $request->except(['_token','sendForm']);
        $user = User::where('id', '=', $id);
        $user->update($param);
        //return response()->redirectToRoute('admin.listar.usuarios');
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
