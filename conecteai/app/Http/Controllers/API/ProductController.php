<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/product",
     *     tags={"ProductController"},
     *     summary="Cadastra um produto.",
     *     description="Cadastra um novo produto no banco de dados.",
     *     @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=true,
     *          example="Galao de tinta",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="color",
     *          in="query",
     *          required=true,
     *          example="Azul",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="dimensions",
     *          in="query",
     *          required=true,
     *          example="5 litros",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="price",
     *          in="query",
     *          required=true,
     *          example="20",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao criar produto."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao criar produto."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Produto criado efetuado com sucesso."}
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
            'description'=>'required|string|min:5|max:50',
            'color'=>'required|string|min:3|max:20',
            'dimensions'=>'required|string',
            'price'=>'required|numeric|min:0|max:9999.99'
        ]);
        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao criar produto.',
                'código'=>'400'
            ],400);
        }

        $product=Product::create($request->all());
        if(!$product) {
            return response()->json([
                'mensagem'=>'Erro ao criar produto.',
                'código'=>'500'
            ],500);
        }

        return response()->json([
            'dados'=>$product,
            'mensagem'=>'Produto criado com sucesso.',
            'código'=>'201'
        ],201);
    }
    /**
     * @OA\Put(
     *     path="/api/product",
     *     tags={"ProductController"},
     *     summary="Atualiza um produto.",
     *     description="Atualiza um novo produto no banco de dados.",
     *     @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=false,
     *          example="Galao de tinta",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="color",
     *          in="query",
     *          required=false,
     *          example="Azul",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="dimensions",
     *          in="query",
     *          required=false,
     *          example="5 litros",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="price",
     *          in="query",
     *          required=false,
     *          example="20",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao atualizar produto."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Produto atualizado com sucesso."}
     *          )
     *     )
     * )
     */ 
     /** Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */    
    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'description'=>'nullable|string|min:5|max:50',
            'color'=>'nullable|string|min:3|max:20',
            'dimensions'=>'nullable|string',
            'price'=>'nullable|numeric|min:0|max:9999.99'
        ]);

        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao atualizar cliente.',
                'código'=>'400'
            ],400);
        }

        $product=Product::update($request->all());

        return response()->json([
            'mensagem'=>'Produto atualizado com sucesso.',
            'código'=>'201'
        ],201);
    }

    /**
     * @OA\Delete(
     *     path="/api/product/{id}",
     *     tags={"ProductController"},
     *     summary="Deleta um produto.",
     *     description="Deleta um produto existente no banco de dados.",
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
     *              example={"Erro ao deletar produto."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Not found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Produto não encontrado."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Produto deletado com sucesso."}
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
                'mensagem'=>'Erro ao deletar cliente.',
                'código'=>'400'
            ],400);
        }

        $product = Product::find($id);
        if(!$product) {
            return response()->json([
                'mensagem'=>'Produto não encontrado.',
                'código'=>'404'
            ],404);
        }

        $product->delete();
        return response()->json([
            'mensagem'=>'Produto deletado com sucesso.',
            'código'=>'200'
        ],200);
    }       

    /**
     * @OA\Get(
     *     path="/api/product",
     *     tags={"ProductController"},
     *     summary="Lista os produtos cadastrados.",
     *     description="Lista os produtos cadastrados no banco de dados.",
     * 
     *     @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"$product"}
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
        $product = Product::all();
        if($product->count() > 0) {
            return response()->json([
                'dados'=>$product,
                'codigo'=>'200'
            ],200);
        }
        return response()->json([
            'mensagem'=>'Não há produtos cadastrados.'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/product/{id}",
     *     tags={"ProductController"},
     *     summary="Mostra um produto cadastrado.",
     *     description="Mostra um produto cadastrado no banco de dados.",
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
     *              example={"Produto não encontrado."}
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
        $id = Product::find($id);

        if(!$id) {
            return response()->json([
                'mensagem'=>'Produto não encontrado.',
                'código'=>'404'
            ],404);
        }

        return response()->json([
            'dados'=>$id,
            'código'=>'200'
        ],200);
    }     
}
