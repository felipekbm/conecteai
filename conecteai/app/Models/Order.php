<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Order",
 *     type="object"
 * )
*/


class Order extends Model
{

    /**
     * @OA\Property(
     *     title="salesman",
     *     description="Nome do vendedor",
     *     format="string",
     *     example="Felipe Kazuo"
     * )
     */
    private $salesman;
    /**
     * @OA\Property(
     *     title="customer_id",
     *     description="ID do cliente",
     *     format="string",
     *     example="1"
     * )
     */
    private $customer_id;
    /**
     * @OA\Property(
     *     title="date",
     *     description="Data do pedido",
     *     format="string",
     *     example="2021/03/03"
     * )
     */
    private $date;
    /**
     * @OA\Property(
     *     title="status",
     *     description="Status do pedido",
     *     format="string",
     *     example="Pendente"
     * )
     */
    private $status;
    /**
     * @OA\Property(
     *     title="product_id",
     *     description="ID do produto",
     *     format="string",
     *     example="1"
     * )
     */
    private $product_id;   
    /**
     * @OA\Property(
     *     title="total_price",
     *     description="Preco total do pedido",
     *     format="string",
     *     example="100"
     * )
     */
    private $total_price; 
    /**
     * @OA\Property(
     *     title="commission",
     *     description="Comissao do vendedor",
     *     format="string",
     *     example="2.5"
     * )
     */
    private $commission;

    protected $fillable = [
        'salesman','customer_id','date','status','product_id','total_price','commission'
    ];

    protected $casts = [
        'date' => 'datetime:d/m/Y'
    ];
}
