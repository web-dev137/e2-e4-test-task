<?php
namespace App\models\response;

use OpenApi\Annotations as QA;
/**
 * @OA\Schema(
 *   schema="CurrencyConversionHistory",
 *   required={"charCode","dateFrom","dateTo"}
 *  ),
 *
 *  @OA\Property(
 *     property="char_code",
 *     type="string",
 *     description="Char code of valute (USD,EUR,RUB...)",
 *     example="EUR"
 *  ),
 *  @OA\Property(
 *     property="vunit_rate",
 *     type="string",
 *     description="Course chosen currency to ruble",
 *     example="1.08"
 *  ),
 *  @OA\Property(
 *     property="name_valute",
 *     type="string",
 *     description="Char code of valute (USD,EUR,RUB...)",
 *     example="EUR"
 *  ),
 *  @OA\Property(
 *     property="created_at",
 *     type="string",
 *     description="Created date",
 *     example="07-03-2024"
 *  ),
 */
class CurrencyConversionHistory{}