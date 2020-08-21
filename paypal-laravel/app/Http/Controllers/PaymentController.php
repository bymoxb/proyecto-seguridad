<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

class PaymentController extends Controller
{

    private $client;

    public function __construct()
    {
        $paypalConfig = Config::get('paypal');

        $environment = new SandboxEnvironment($paypalConfig['client_id'], $paypalConfig['client_secret']);

        $this->client = new PayPalHttpClient($environment);
    }

    public function create($debug = true)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $url_response = url('/paypal/login');
        $request->body = $this->buildRequestBody($url_response);

        try {
            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function paypalLogin(Request $request)
    {
        $new_request = new OrdersCaptureRequest($request->token);
        $new_request->prefer('return=representation');
        try {
            $response = $this->client->execute($new_request);
            dd($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    private function buildRequestBody($url_response)
    {
        return array(
            'intent' => 'CAPTURE',
            'application_context' =>
            array(
                'brand_name' => 'EXAMPLE INC',
                'locale' => 'en-US',
                'landing_page' => 'BILLING',
                'shipping_preferences' => 'SET_PROVIDED_ADDRESS',
                'user_action' => 'PAY_NOW',
                "cancel_url" => $url_response,
                "return_url" => $url_response
            ),
            'purchase_units' =>
            array(
                0 =>
                array(
                    'reference_id' => 'PUHF',
                    'description' => 'Sporting Goods',
                    'custom_id' => 'CUST-HighFashions',
                    'soft_descriptor' => 'HighFashions',
                    'amount' =>
                    array(
                        'currency_code' => 'USD',
                        'value' => '220.00',
                        'breakdown' =>
                        array(
                            'item_total' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '180.00',
                            ),
                            'shipping' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '20.00',
                            ),
                            'handling' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '10.00',
                            ),
                            'tax_total' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '20.00',
                            ),
                            'shipping_discount' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '10.00',
                            ),
                        ),
                    ),
                    'items' =>
                    array(
                        0 =>
                        array(
                            'name' => 'T-Shirt',
                            'description' => 'Green XL',
                            'sku' => 'sku01',
                            'unit_amount' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '90.00',
                            ),
                            'tax' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '10.00',
                            ),
                            'quantity' => '1',
                            'category' => 'PHYSICAL_GOODS',
                        ),
                        1 =>
                        array(
                            'name' => 'Shoes',
                            'description' => 'Running, Size 10.5',
                            'sku' => 'sku02',
                            'unit_amount' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '45.00',
                            ),
                            'tax' =>
                            array(
                                'currency_code' => 'USD',
                                'value' => '5.00',
                            ),
                            'quantity' => '2',
                            'category' => 'PHYSICAL_GOODS',
                        ),
                    ),
                    'shipping' =>
                    array(
                        'method' => 'United States Postal Service',
                        'address' =>
                        array(
                            'address_line_1' => '123 Townsend St',
                            'address_line_2' => 'Floor 6',
                            'admin_area_2' => 'San Francisco',
                            'admin_area_1' => 'CA',
                            'postal_code' => '94107',
                            'country_code' => 'US',
                        ),
                    ),
                ),
            ),
        );
    }
}
