<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Product",
 *     type="object"
 * )
*/

class Product extends Model
{
    /**
     * @OA\Property(
     *     title="description",
     *     description="Descricao do produto",
     *     format="string",
     *     example="Galao de tinta"
     * )
     */
    private $description;
    /**
     * @OA\Property(
     *     title="color",
     *     description="Cor do produto",
     *     format="string",
     *     example="Azul"
     * )
     */
    private $color;
    /**
     * @OA\Property(
     *     title="dimensions",
     *     description="Dimensoes do produto",
     *     format="string",
     *     example="5 litros"
     * )
     */
    private $dimensions;
    /**
     * @OA\Property(
     *     title="price",
     *     description="Preco do produto",
     *     format="string",
     *     example="20"
     * )
     */
    private $price;

    protected $fillable = [
        'description','color','dimensions','price'
    ];
}
