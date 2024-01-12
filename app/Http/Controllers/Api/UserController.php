<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    private array $_MESSAGES = [
        'name.required' => 'El nombre es requerido',
        'email.required' => 'El correo es requerido',
        'email.unique' => 'El correo ya existe',
        'password.required' => 'La contraseña es requerida',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        'password_confirmation.required' => 'La confirmación de la contraseña es requerida',
        'password_confirmation.same' => 'Las contraseñas no coinciden',
        'is_active.boolean' => 'El estado debe ser true o false',
        'is_active.required' => 'El estado no puede estar vacío',
        'rol.required' => 'El rol es requerido',
        'rol.exists' => 'El rol no existe',
    ];

    //
//    public  function __construct(){
//        $this->middleware("can:writer");
//    }

    public function index ()
    {
        $user = User::where( 'is_active', '!=', false )
            ->where( 'id', '!=', auth()->user()->id )
            ->orderBy( 'name', 'desc' )
            ->get();
        return response()->json([ 'data' => $user ], 200);
    }

    public function show ( $id ) {
        try {
            if ( !is_numeric( $id ) ) return response()->json([ 'message' => '¡El id debe ser un número!' ], 400);

            $user = User::find( $id )->select( 'id', 'name', 'email', 'is_active' )->first();
            if ( !$user ) return response()->json([ 'message' => '¡Usuario no encontrado!' ], 404);

            $user['roles'] = $user->getRoleNames();

            return response()->json([ 'data' => $user ], 200);
        } catch (\Exception $e) {
            return response()->json([ 'message' => '¡Error al obtener el usuario!', 'error' => $e->getMessage() ], 500);
        }

    }

    public function store ( Request $request )
    {
        try {
            if ( !$request->isJson() ) return response()->json([ 'message' => '¡Petición mal formada!' ], 400);
            if( empty($request->all()) ) return response()->json([ 'message' => '¡Petición vacía!' ], 400);

            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|unique:users,email',
                'password' => 'required|string|min:8',
                'password_confirmation' => 'required|same:password',
                'rol' => 'required|exists:roles,id',
            ]);

            $validator->setCustomMessages( $this->_MESSAGES );

            if ($validator->fails())
                return response()->json(['message' => '¡Bad request!', 'errors' => $validator->errors()->first() ], 400);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;

            if (!$user->save()) return response()->json([ 'message' => '¡Error al crear el usuario!' ], 500);

            $this->addRoleUser($user, $request->rol);

            return response()->json([ 'message' => '¡Usuario creado correctamente!', 'data' => $user ], 201);
        } catch (\Exception $e) {
            return response()->json([ 'message' => '¡Error al crear el usuario!', 'error' => $e->getMessage() ], 500);
        }

    }
    public function update ( Request $request, $id){
        try {

            if ( !is_numeric( $id ) ) return response()->json([ 'message' => '¡El id debe ser un número!' ], 400);
            if ( !$request->isJson() ) return response()->json([ 'message' => '¡Petición mal formada!' ], 400);
            if( empty($request->all()) ) return response()->json([ 'message' => '¡Petición vacía!' ], 400);

            $user = User::find($id);
            if ( !$user ) return response()->json([ 'message' => '¡Usuario no encontrado!' ], 404);

            $validator = \Validator::make($request->all(), []);

            if ( $request->has('name') ) $validator->addRules(['name' => 'required|string|max:255']);
            if ( $request->has('email') ) $validator->addRules(['email' => 'required|unique:users,email']);
            if ( $request->has('password') ) $validator->addRules(['password' => 'required|string|min:8']);
            if ( $request->has('is_active') ) $validator->addRules(['is_active' => 'required|boolean']);
            if ( $request->has('rol') ) $validator->addRules(['rol' => 'required|exists:roles,id']);

            $validator->setCustomMessages( $this->_MESSAGES );

            if ($validator->fails())
                return response()->json(['message' => '¡Bad request!', 'errors' => $validator->errors()->first() ], 400);

            $isUpdate = $user->update( $request->all() );

            if ( !$isUpdate ) return response()->json([ 'message' => '¡Error al actualizar el usuario!' ], 500);

            $this->updateRolesUser($user, $request->rol);

            return response()->json([ 'message' => '¡Usuario actualizado correctamente!', "data" => $user], 200);
        } catch ( \Exception $e) {
            return response()->json([ 'message' => '¡Error al actualizar el usuario!', 'error' => $e->getMessage() ], 500);
        }
    }

    public function destroy ( $id ){
        try {
            $user = User::find($id);
            $user->is_active = false;
            $user->save();
            if (!$user->save()) return  response()->json([ 'message'=>'¡Error al eliminar el usuario!' ],500);
            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => '¡Error al eliminar el usuario!', 'error' => $e->getMessage()], 500);
        }
    }


    private function addRoleUser (User $user, $listRoles ) {
        try {
            collect($listRoles)->each(callback: function ($rolId) use ($user) {
                $rol = Role::find($rolId);
                $user->assignRole($rol);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function updateRolesUser (User $user, $listRoles) {
        try {
            $roles = $user->roles->pluck('id')->toArray();
            $rolesRequest = $listRoles;
            $diffDB = array_diff($roles, $rolesRequest);
            $diffReq = array_diff($rolesRequest, $roles);

            if ( !empty($diffDB) ) {
                collect($diffDB)->each(function ($item, $key) use ($user) {
                    $user->removeRole($item);
                });
            }

            if ( !empty($diffReq) ) {
                collect($diffReq)->each(function ($item, $key) use ($user) {
                    $this->addRoleUser($user, $item);
                });
            }

            $user->save();

        } catch ( \Exception $e ) {
            return false;
        }
    }
}
