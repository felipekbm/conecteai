<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Customer",
 *     type="object"
 * )
*/

class Customer extends Model
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Nome do cliente",
     *     format="string",
     *     example="Felipe Kazuo"
     * )
     */
    private $name;
    /**
     * @OA\Property(
     *     title="cnpj",
     *     description="CNPJ do cliente",
     *     format="string",
     *     example="99.999.999/9999-99"
     * )
     */
    private $cnpj;
    /**
     * @OA\Property(
     *     title="email",
     *     description="E-mail do cliente",
     *     format="string",
     *     example="email@domain.com"
     * )
     */
    private $email;    
    /**
     * @OA\Property(
     *     title="telephone",
     *     description="Telefone do cliente",
     *     format="string",
     *     example="(99) 99999-9999"
     * )
     */
    private $telephone;
    protected $fillable = [
        'name','cnpj','email','telephone'
    ];
}
