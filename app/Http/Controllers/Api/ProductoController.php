<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{

    private array $_MESSAGES = [
        'codigo.required' => 'El código es requerido',
        'codigo.unique' => 'El código ya existe',
        'codigo.string' => 'El código debe ser una cadena de texto',
        'codigo.max' => 'El código debe tener máximo 255 caracteres',
        'codigo.regex' => 'El código debe ser alfanumérico',
        'producto.required' => 'El producto es requerido',
        'producto.string' => 'El producto debe ser una cadena de texto',
        'producto.max' => 'El producto debe tener máximo 255 caracteres',
        'producto.regex' => 'El producto debe ser alfanumérico',
        'precio_unitario.required' => 'El precio unitario es requerido',
        'precio_unitario.regex' => 'El precio unitario debe ser decimal entre 0.01 y 999999.99',
        'precio_unitario.between' => 'El precio unitario debe estar entre 0.01 y 999999.99',
        'descuento.regex' => 'El descuento debe ser decimal',
        'existencia.integer' => 'La existencia debe ser un número entero',
        'activo.boolean' => 'El estado debe ser true o false',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $producto = Producto::where('activo', '=', true)->get();

            return response()->json(['data' => $producto], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => '¡Error al obtener los productos!', 'error' => $e->getMessage()], 500);
        }
    }

    public function show( Producto $producto)
    {
        try {
            return response()->json(['data' => $producto], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => '¡Error al obtener el producto!', 'error' => $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'codigo' => 'required|string|max:255|regex:/^[A-Za-z0-9]+$/u|unique:productos,codigo',
                'producto' => 'required|string|max:255|regex:/^[\pL\d\s\-.,\xE0-\xFF]+$/u',
                'precio_unitario' => 'required|regex:/^\d+(\.\d{1,2})?$/|between:0.01,999999.99',
                'descuento' => 'regex:/^\d+(\.\d{1,2})?$/',
                'existencia' => 'integer',
            ]);

            $validator->setCustomMessages( $this->_MESSAGES );

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $producto = new Producto();
            $producto->codigo = $request->codigo;
            $producto->producto = $request->producto;
            $producto->precio_unitario = $request->precio_unitario;
            $producto->descuento = $request->descuento;
            $producto->existencia = $request->existencia;
            $producto->activo = $request->activo;

            $producto->save();

            return response()->json(['data' => $producto], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => '¡Error al crear el producto!', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        if ( !is_numeric( $id ) ) return response()->json([ 'message' => '¡El id debe ser un número!' ], 400);
        if ( !$request->isJson() ) return response()->json([ 'message' => '¡Petición mal formada!' ], 400);
        if( empty($request->all()) ) return response()->json([ 'message' => '¡Petición vacía!' ], 400);

        try {

            $producto = Producto::find( $id );
            if ( !$producto ) return response()->json([ 'message' => '¡Producto no encontrado!' ], 404);

            $validator = \Validator::make($request->all(), []);

            if ($request->has('codigo')) $validator->addRules(['codigo' => 'required|string|max:255|regex:/^[A-Za-z0-9]+$/u|unique:productos,codigo']);
            if ($request->has('producto')) $validator->addRules(['producto' => 'required|string|max:255|regex:/^[\pL\d\s\-.,\xE0-\xFF]+$/u']);
            if ($request->has('precio_unitario')) $validator->addRules(['precio_unitario' => 'required|regex:/^\d+(\.\d{1,2})?$/|between:0.01,999999.99']);
            if ($request->has('descuento')) $validator->addRules(['descuento' => 'regex:/^\d+(\.\d{1,2})?$/|between:0.01,999999.99']);
            if ($request->has('existencia')) $validator->addRules(['existencia' => 'integer']);
            if ($request->has('activo')) $validator->addRules(['activo' => 'boolean']);

            $validator->setCustomMessages( $this->_MESSAGES );

            if ($validator->fails())
                return response()->json(['message' => '¡Bad request!', 'errors' => $validator->errors()->first() ], 400);

            $isUpdated = $producto->update($request->all());

            if (!$isUpdated) return response()->json(['message' => '¡Error al actualizar el producto!'], 500);

            return response()->json(['data' => $producto], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => '¡Error al actualizar el producto!', 'error' => $e->getMessage()], 500);
        }
    }
}
