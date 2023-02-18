<?php
/**
 * The file that defines the ProductMap class
 *
 * A class definition that includes attributes and functions of the ProductMap class
 *
 * @since      0.1
 *
 * @package    WooCoo
 * @subpackage WooCoo/App/Modules/dkPlus
 */

namespace woocoo\App\Modules\dkPlus;

use woocoo\App\Core\ProductMapper;

/**
 * Class ProductMap
 */
class ProductMap extends ProductMapper
{
    const Map = [
        'ItemCode' => [
            'field' => 'sku',
        ],
        'Description' => [
            'field' => 'name',
        ],
        'Description2' => [
            'field' => 'description',
        ],
        'RecordModified' => [
            'field' => 'date_modified',
        ],
        // Import price with VAT. #29
        'TaxPercent' => [
            'field' => 'tax',
            'callback' => [ProductMapper::class, 'toFloat'],
        ],
	    //(#29 - Import price with VAT - add comments)
        'UnitPrice1WithTax' => [
            'field' => 'regular_price',
            'callback' => [ProductMapper::class, 'toFloat'],
        ],
        'UnitQuantity' => [
            'field' => 'stock_quantity',
        ],
        'set_manage_stock' => [
            'field' => 'manage_stock',
            'callback' => [ProductMapper::class, 'setBoolTrue'],
        ],
        // DK variations
        'Alternative' => [
            'field' => 'children',
        ],
        // DK Show In Webshop
        'ShowItemInWebShop' => [
            'field' => 'visibility',
        ]
    ];
}
