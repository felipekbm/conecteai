<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use Validator;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/order",
     *     tags={"OrderController"},
     *     summary="Cria um pedido.",
     *     description="Cria um novo pedido no banco de dados.",
     *     @OA\Parameter(
     *          name="salesman",
     *          in="query",
     *          required=true,
     *          example="Felipe Kazuo",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="customer_id",
     *          in="query",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date",
     *          in="query",
     *          required=true,
     *          example="03/03/2021",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          required=true,
     *          example="Pendente",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="product_id",
     *          in="query",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="total_price",
     *          in="query",
     *          required=true,
     *          example="100",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="commission",
     *          in="query",
     *          required=true,
     *          example="2.5",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao cadastrar pedido."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Cliente não encontrado."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao criar pedido."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Pedido efetuado com sucesso."}
     *          )
     *     )
     * )
     */ 
     /** Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'salesman'=>'required|regex:/(^([\pL]+ )([\pL]{2,} ?)+$)/u',
            'customer_id'=>'required|numeric',
            'date'=>'required|date_format:d/m/Y',
            'status'=>'required|string|min:4|max:10',
            'product_id'=>'required|numeric',
            'total_price'=>'required|min:0|max:99999',
            'commission'=>'required|min:0'
            ]);
        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao cadastrar pedido.',
                'código'=>'400'
            ],400);
        }
            
        $customer = Customer::find($request->customer_id);        
            
        if(!$customer) {
            return response()->json([
                'mensagem'=>'Cliente não encontrado.',
                'código'=>'404'
            ],404);
        }
            
        $product = Product::find($request->product_id);
        if(!$product) {
            return response()->json([
                'mensagem'=>'Produto não encontrado.',
                'código'=>'404'
            ],404);
        }

        $date = DateTime::createFromFormat('d/m/Y', $request->date);
        $date = $date->format('Y-m-d');
        $request->merge(['date'=>$date]);
        
        $order=Order::create($request->all());
        
        if(!$order) {
            return response()->json([
                'mensagem'=>'Erro ao criar pedido.',
                'código'=>'500'
            ],500);
        }
        
        return response()->json([
            'dados'=>$order,
            'mensagem'=>'Pedido efetuado com sucesso.',
            'código'=>'201'
        ],201);
    }

    /**
     * @OA\Put(
     *     path="/api/order/{id}",
     *     tags={"OrderController"},
     *     summary="Atualiza um pedido.",
     *     description="Atualiza um pedido existente no banco de dados.",
     *     @OA\Parameter(
     *          name="salesman",
     *          in="query",
     *          required=false,
     *          example="Felipe Kazuo",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="cusomer_id",
     *          in="query",
     *          required=false,
     *          example="1",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date",
     *          in="query",
     *          required=false,
     *          example="03/03/2021",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="status",
     *          in="query",
     *          required=false,
     *          example="Pago",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="product_id",
     *          in="query",
     *          required=false,
     *          example="1",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="total_price",
     *          in="query",
     *          required=false,
     *          example="100",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="commission",
     *          in="query",
     *          required=false,
     *          example="2.5",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao atualizar pedido."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Cliente não encontrado."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Pedido atualizado com sucesso."}
     *          )
     *     )
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id) {
        $validator = Validator::make($request->all(), [
            'salesman'=>'nullable|regex:/(^([\pL]+ )([\pL]{2,} ?)+$)/u',
            'customer_id'=>'nullable|numeric',
            'date'=>'nullable|date_format:d/m/Y',
            'status'=>'nullable|string|min:4|max:10',
            'product_id'=>'nullable|numeric',
            'total_price'=>'nullable|min:0|max:99999',
            'commission'=>'nullable|min:0'
            ]);

        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao atualizar pedido.',
                'código'=>'400'
            ],400);
        }
            
        $customer = Customer::find($request->customer_id);        
            
        if(!$customer) {
            return response()->json([
                'mensagem'=>'Cliente não encontrado.',
                'código'=>'404'
            ],404);
        }
            
        $product = Product::find($request->product_id);
        if(!$product) {
            return response()->json([
                'mensagem'=>'Produto não encontrado.',
                'código'=>'404'
            ],404);
        }

        $date = DateTime::createFromFormat('d/m/Y', $request->date);
        $date = $date->format('Y-m-d');
        $request->merge(['date'=>$date]);
        
        $order=Order::update($request->all());
        
        return response()->json([
            'dados'=>$order,
            'mensagem'=>'Pedido atualizado com sucesso.',
            'código'=>'201'
        ],201);
    }

    /**
     * @OA\Delete(
     *     path="/api/order/{id}",
     *     tags={"OrderController"},
     *     summary="Deleta um pedido.",
     *     description="Deleta um pedido existente no banco de dados.",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao deletar pedido."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Pedido não encontrado."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Pedido deletado com sucesso."}
     *          )
     *     )
     * )
     */

    /**
     * 
     * Remove the specified resource from storage.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response)
     */

    public function destroy($id) {
        $validator = Validator::make(['id'=>$id], [
            'id'=>'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao deletar pedido.',
                'código'=>'400'
            ],400);
        }

        $order = Order::find($id);
        if(!$order) {
            return response()->json([
                'mensagem'=>'Pedido não encontrado.',
                'código'=>'404'
            ],404);
        }

        $order->delete();
        return response()->json([
            'mensagem'=>'Pedido deletado com sucesso.',
            'código'=>'200'
        ],200);
    }

    /**
     * @OA\Get(
     *     path="/api/order",
     *     tags={"OrderController"},
     *     summary="Lista os pedidos cadastrados.",
     *     description="Lista os pedidos cadastrados no banco de dados.",
     * 
     *     @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"$order"}
     *          )
     *     )
     * )
     */
    /** 
     *
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
    */

    public function index(){
        $order = Order::all();
        if($order->count() > 0) {
            return response()->json([
                'dados'=>$order,
                'codigo'=>'200'
            ],200);
        }
        return response()->json([
            'mensagem'=>'Não há pedidos cadastrados.'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/order/{id}",
     *     tags={"OrderController"},
     *     summary="Mostra um pedido cadastrado.",
     *     description="Mostra um pedido cadastrado no banco de dados.",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          example="1",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),

     *     @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Pedido não encontrado."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"$id"}
     *          )
     *     )
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {
        $id = Order::find($id);

        if(!$id) {
            return response()->json([
                'mensagem'=>'Pedido não encontrado.',
                'código'=>'404'
            ],404);
        }

        return response()->json([
            'dados'=>$id,
            'código'=>'200'
        ],200);
    }
}
