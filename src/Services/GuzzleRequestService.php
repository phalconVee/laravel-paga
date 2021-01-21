<?php

/*
 * This file is part of the Laravel Paga package.
 *
 * (c) Henry Ugochukwu <phalconvee@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phalconvee\Paga\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Phalconvee\Paga\Exceptions\IsNullException;

class GuzzleRequestService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * GuzzleRequestService constructor.
     *
     * @param $base_url
     * @param $hash
     * @param $publicKey
     * @param $secretKey
     */
    public function __construct($base_url, $hash, $publicKey, $secretKey)
    {
        $this->client = new Client([
            'base_uri' => $base_url,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'hash' => $hash,
                'principal' => $publicKey,
                'credentials' => $secretKey
            ]
        ]);
    }

    /**
     * Set options for making the Client request.
     *
     * @param $method
     * @param $url
     * @param null $body
     * @return mixed|\Psr\Http\Message\ResponseInterface|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws IsNullException
     */
    public function makeHttpRequest($method, $url, $body = null)
    {
        $response = null;

        if (is_null($method))
            throw new isNullException("Empty Method Not Allowed");

        if ($method == 'GET') {
            $response = $this->doGet($url, $body);
        } else if ($method == 'POST') {
            $response = $this->doPostRaw($url, $body);
        } else if ($method == 'MULTIPART') {
            $response = $this->doMultiPart($url, $body);
        }

        $response = json_decode($response->getBody(), true);
        return $response;
    }

    /**
     * Make GET Client Request.
     *
     * @param $url
     * @param array $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doGet($url, $body = [])
    {
        return $this->client->request('GET', $url, [
            'query' => $body
        ]);
    }

    /**
     * Make POST Client Request.
     *
     * @param $url
     * @param $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doPost($url, $body)
    {
        return $this->client->request('POST', $url, [
            'form_params' => $body
        ]);
    }

    /**
     * Make Raw POST Client Request.
     *
     * @param $url
     * @param $body
     * @return \Psr\Http\Message\ResponseInterface
     * @throws GuzzleException
     */
    private function doPostRaw($url, $body)
    {
        return $this->client->request('POST', $url, [
            'body' => json_encode($body)
        ]);
    }
    /**
     *  Make Multipart Client Request.
     *
     * @param $url
     * @param $multipart
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function doMultiPart($url, $multipart)
    {
        return $this->client->request('POST', $url, $multipart);
    }
}
