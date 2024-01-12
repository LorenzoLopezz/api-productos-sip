<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class VentasController extends Controller
{
    private array $_MESSAGES = [
        'monto.required' => 'El monto es requerido',
        'monto.regex' => 'El monto debe ser decimal entre 0.01 y 999999.99',
        'monto.between' => 'El monto debe estar entre 0.01 y 999999.99',
        'cantidad.required' => 'La cantidad es requerida',
        'cantidad.integer' => 'La cantidad debe ser un número entero',
        'producto.required' => 'El producto es requerido',
        'producto.string' => 'El producto debe ser una cadena de texto',
        'producto.max' => 'El producto debe tener máximo 255 caracteres',
        'producto.regex' => 'El producto debe ser alfanumérico',
    ];
    public function index()
    {
        try {
            $ventas = Ventas::all();

            return response()->json([
                'success' => true,
                'data' => $ventas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la consulta de ventas: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'monto' => 'required|numeric|between:0.01,999999.99',
                'cantidad' => 'required|integer',
                'producto' => 'required|string|max:255|regex:/^[\pL\d\s\-.,\xE0-\xFF]+$/u',
            ]);

            $validator->setCustomMessages($this->_MESSAGES);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()], 400);
            }

            $ventas = new Ventas();
            $ventas->monto = $request->input('monto');
            $ventas->cantidad = $request->input('cantidad');
            $ventas->producto = $request->input('producto');
            $ventas->save();

            return response()->json(['data' => $ventas], 201);
        } catch (\Illuminate\Database\QueryException $e) {

            return response()->json(['message' => 'Error en la consulta de base de datos', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {

            return response()->json(['message' => '¡Error al crear la venta!', 'error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, Ventas $ventas)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'monto' => 'required|numeric|between:0.01,999999.99',
                'cantidad' => 'required|integer',
                'producto' => 'required|string|max:255|regex:/^[\pL\d\s\-.,\xE0-\xFF]+$/u',
            ]);

            $validator->setCustomMessages($this->_MESSAGES);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()], 400);
            }

            $ventas->update([
                'monto' => $request->input('monto'),
                'cantidad' => $request->input('cantidad'),
                'producto' => $request->input('producto'),
            ]);

            return response()->json(['data' => $ventas], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => 'Error en la consulta de base de datos', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            return Response::json(['message' => '¡Error al actualizar la venta!', 'error' => $e->getMessage()], 500);
        }
    }


    public function show(Ventas $ventas)
    {
        try {
            $ventas = Ventas::findOrFail($ventas->id);

            return response()->json([
                'success' => true,
                'data' => $ventas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '¡Error al recuperar la venta!',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function destroy(Ventas $ventas)
    {
        try {
            $ventas->delete();

            return response()->json([
                'success' => true,
                'message' => 'Venta eliminada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '¡Error al eliminar la venta!',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
