<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/customer",
     *     tags={"CustomerController"},
     *     summary="Cadastra um cliente.",
     *     description="Cadastra um novo cliente no banco de dados.",
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          required=true,
     *          example="Felipe Kazuo",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="cnpj",
     *          in="query",
     *          required=true,
     *          example="99.999.999/9999-99",
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
     *          name="email",
     *          in="query",
     *          required=true,
     *          example="email@domain.com",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="telephone",
     *          in="query",
     *          required=true,
     *          example="(99) 99999-9999",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao cadastrar cliente."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao cadastrar cliente."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Cliente efetuado com sucesso."}
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
            'name'=>'required|string|min:5|max:100|regex:/(^([\pL]+ )([\pL]{2,} ?)+$)/u',
            'cnpj'=>'required|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/u',
            'telephone'=>'required|regex:/(^(\(?\d{2}\)?\s?)?(\d{4,5}\-?\d{4})$)/u',
            'email'=>'required|email|unique:users',
        ]);

        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao cadastrar cliente.',
                'código'=>'400'
            ],400);
        }

        $customer = Customer::create($request->all());
        $customer->save();

        if(!$customer) {
            return response()->json([
                'mensagem'=>'Erro ao cadastrar cliente.',
                'código'=>'500'
            ],500);
        }

        return response()->json([
            'mensagem'=>'Cliente cadastrado com sucesso.',
            'código'=>'201'
        ],201);
    }

    /**
     * @OA\Put(
     *     path="/api/customer",
     *     tags={"CustomerController"},
     *     summary="Atualiza um cliente.",
     *     description="Atualiza um novo cliente no banco de dados.",
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          required=false,
     *          example="Felipe Kazuo",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="cnpj",
     *          in="query",
     *          required=false,
     *          example="99.999.999/9999-99",
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
     *          name="email",
     *          in="query",
     *          required=false,
     *          example="email@domain.com",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="telephone",
     *          in="query",
     *          required=false,
     *          example="(99) 99999-9999",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="400",
     *          description="Bad Request",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Erro ao atualizar cliente."}
     *          )
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Created",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Cliente atualizado com sucesso."}
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
            'name'=>'nullable|string|min:5|max:100|regex:/(^([\pL]+ )([\pL]{2,} ?)+$)/u',
            'cnpj'=>'nullable|cnpj|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/u',
            'telephone'=>'nullable|regex:/(^(\(?\d{2}\)?\s?)?(\d{4,5}\-?\d{4})$)/u',
            'email'=>'nullable|email|unique:users',
        ]);

        if($validator->fails()) {
            return response()->json([
                'dados'=>$validator->errors(),
                'mensagem'=>'Erro ao atualizar cliente.',
                'código'=>'400'
            ],400);
        }

        $customer=Customer::update($request->all());

        return response()->json([
            'mensagem'=>'Cliente atualizado com sucesso.',
            'código'=>'201'
        ],201);
    }    

    /**
     * @OA\Delete(
     *     path="/api/customer/{id}",
     *     tags={"CustomerController"},
     *     summary="Deleta um cliente.",
     *     description="Deleta um cliente existente no banco de dados.",
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
     *              example={"Erro ao deletar cliente."}
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
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"Cliente deletado com sucesso."}
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

        $customer = Customer::find($id);
        if(!$customer) {
            return response()->json([
                'mensagem'=>'Cliente não encontrado.',
                'código'=>'404'
            ],404);
        }

        $customer->delete();
        return response()->json([
            'mensagem'=>'Cliente deletado com sucesso.',
            'código'=>'200'
        ],200);
    }    

    /**
     * @OA\Get(
     *     path="/api/customer",
     *     tags={"CustomerController"},
     *     summary="Lista os clientes cadastrados.",
     *     description="Lista os clientes cadastrados no banco de dados.",
     * 
     *     @OA\Response(
     *          response="200",
     *          description="Successful Operation",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              example={"$customer"}
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
        $customer = Customer::all();
        if($customer->count() > 0) {
            return response()->json([
                'dados'=>$customer,
                'codigo'=>'200'
            ],200);
        }
        return response()->json([
            'mensagem'=>'Não há clientes cadastrados.'
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/customer/{id}",
     *     tags={"CustomerController"},
     *     summary="Mostra um cliente cadastrado.",
     *     description="Mostra um cliente cadastrado no banco de dados.",
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
     *              example={"Cliente não encontrado."}
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
        $id = Customer::find($id);

        if(!$id) {
            return response()->json([
                'mensagem'=>'Cliente não encontrado.',
                'código'=>'404'
            ],404);
        }

        return response()->json([
            'dados'=>$id,
            'código'=>'200'
        ],200);
    }    
}

