<?php

namespace woo_bookkeeping\App\Modules\dkPlus;

use woo_bookkeeping\App\Core\Main as Core;
use woo_bookkeeping\App\Core\WP_Notice;

//use woo_bookkeeping\App\Core\Woo_Query;

trait API
{
    private static $token = '';
    private static string $api_url = 'https://api.dkplus.is/api/v1';


    public static function getToken()
    {
        static $token = null;

        if (NULL === $token) {
            $settings = Core::getInstance();

            if (!empty($settings[Main::getModuleSlug()]['token'])) {
                $token = $settings[Main::getModuleSlug()]['token'];
            } else {
                self::setToken();
            }
        }

        return $token;
    }

    private static function setToken(): void
    {
        $new_settings = Core::getInstance();

        self::createToken($new_settings);

        if (empty(self::$token)) {
            if (!isset($_GET['page']) || $_GET['page'] !== PLUGIN_SLUG) return;

            new WP_Notice('error', 'Error: Please, check the correctness of the login and password.');
            return;
        }


        $new_settings[self::getModuleSlug()]['token'] = self::$token;
        update_option(PLUGIN_SLUG, $new_settings, 'no');
    }

    private static function createToken($data): void
    {
        $method = '/token';
        $args = [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($data[self::getModuleSlug()]['login'] . ':' . $data[self::getModuleSlug()]['password']),
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'body' => [
                'Description' => 'Woo bookkeeping',
            ],
            'method' => 'POST',
        ];

        $result = static::request($method, $args);

        if (!empty($result['Token'])) {
            self::$token = $result['Token'];
        }
    }

    public static function sendProductPrice($product_sku, $price)
    {
        $args = [
            'UnitPrice1' => (float)$price,
        ];

        self::productUpdateDK($product_sku, $args);
    }

    /**
     * Send data to dkPlus
     * @param string $product_sku
     * @return array
     */
    public static function productUpdateDK(string $product_sku, $data)
    {
        $products = static::request('/Product/' . $product_sku, static::setHeaders('PUT', $data));
        print_r($products);
        die();
        return $products;
    }

    /**
     * getting a product with a dkplus API
     * @param string $product_sku
     * @return array Product data
     */
    public static function productFetchOne(string $product_sku): array
    {
        $products = static::request('/Product/' . $product_sku, static::setHeaders());

        if (empty($products) || is_bool($products)) return [];

        $result = static::productMap($products);

        return $result;
    }

    /**
     * getting all products with dkplus API
     * @return array Products
     */
    public static function productFetchAll(): array
    {
        $products = static::request('/Product', static::setHeaders());
        $result = [];

        foreach ($products as $product) {
            $result[] = static::productMap($product);
        }

        return $result;
    }

    /**
     * getting one a product with dkplus API
     * @return array
     */
    public static function productMap($product)
    {
        return ProductMap::ProductMap($product);
    }

    private static function setHeaders($method = 'GET', $body = [])
    {
        return [
            'body' => $body,
            'headers' => [
                'Authorization' => 'Bearer ' . static::getToken(),
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'method' => $method,
            'timeout' => 30,
        ];
    }

    private static function request(string $method, array $args)
    {
        $response = wp_remote_request(static::$api_url . $method, $args);
        $body = wp_remote_retrieve_body($response);

        return !empty($body) ? json_decode($body, true) : true;
    }
}