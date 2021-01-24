<?php

/*
 * This file is part of the Laravel Paga package.
 *
 * (c) Henry Ugochukwu <phalconvee@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phalconvee\Paga;

use GuzzleHttp\Exception\GuzzleException;
use Phalconvee\Paga\Services\GuzzleRequestService;

class Paga
{
    /**
     * Issue API key from your Paga dashboard.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Issue public key from your Paga dashboard.
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Issue password from your Paga Dashboard.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Set server URL (e.g true = Use Test URL, false = Use Live URL).
     *
     * @var string
     */
    protected $url;

    /**
     * Response from requests made to Paga.
     *
     * @var mixed
     */
    protected $response;

    /**
     * Define live API URL.
     */
    const LIVE_API_URL = 'https://www.mypaga.com';

    /**
     * Define test API URL.
     */
    const TEST_API_URL = 'https://beta.mypaga.com';

    /**
     * Paga constructor.
     */
    public function __construct()
    {
        $this->setApiKey();
        $this->setPublicKey();
        $this->setSecretKey();
    }

    /**
     * Get API key from Paga config file.
     */
    private function setApiKey()
    {
        $this->apiKey = config('paga.apiKey');
    }

    /**
     * Get public key from Paga config file.
     */
    private function setPublicKey()
    {
        $this->publicKey = config('paga.publicKey');
    }

    /**
     * Get secret key from Paga config file.
     */
    private function setSecretKey()
    {
        $this->secretKey = config('paga.secretKey');
    }

    /**
     * Set server environment.
     *
     * @param bool $test
     */
    public function setTest($test = false)
    {
        $this->url = ($test) ? self::TEST_API_URL : self::LIVE_API_URL;
    }

    /**
     * Set service for making the client request.
     *
     * @param $hash
     *
     * @return GuzzleRequestService
     */
    private function setRequestService($hash)
    {
        return new GuzzleRequestService($this->url, $hash, $this->publicKey, $this->secretKey);
    }

    /**
     * Generate a Unique Transaction Reference.
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return getHashedToken();
    }

    /**
     * Return list of banks integrated with Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function getBanks()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getBanks';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Return list of merchants integrated with Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function getMerchants()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getMerchants';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Return merchant services registered on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function getMerchantServices()
    {
        $body = [
            'referenceNumber'  => request()->reference,
            'merchantPublicId' => request()->merchantPublicId,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getMerchantServices';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Return mobile operators on the Paga platform.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function getMobileOperators()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getMobileOperators';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Return operation status per transaction.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function getOperationStatus()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getOperationStatus';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Get account balance on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function accountBalance()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/accountBalance';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Purchase airtime via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function airtimePurchase()
    {
        $body = [
            'referenceNumber'        => request()->reference,
            'amount'                 => request()->amount,
            'destinationPhoneNumber' => request()->destinationPhoneNumber,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/airtimePurchase';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Operation to deposit funds into any bank account via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function depositToBank()
    {
        $body = [
            'referenceNumber'              => request()->reference,
            'amount'                       => request()->amount,
            'destinationBankUUID'          => request()->destinationBankUUID,
            'destinationBankAccountNumber' => request()->destinationBankAccountNumber,
            'recipientPhoneNumber'         => request()->recipientPhoneNumber,
            'currency'                     => request()->currency,
        ];

        $hash = createHash($this->apiKey, [
            $body['referenceNumber'],
            $body['amount'],
            $body['destinationBankUUID'],
            $body['destinationBankAccountNumber'],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/depositToBank';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Validate deposit operation to bank via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function validateDepositToBank()
    {
        $body = [
            'referenceNumber'              => request()->reference,
            'amount'                       => request()->amount,
            'destinationBankUUID'          => request()->destinationBankUUID,
            'destinationBankAccountNumber' => request()->destinationBankAccountNumber,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/validateDepositToBank';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Transfer funds from a variety of sources via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function moneyTransfer()
    {
        $body = [
            'referenceNumber'          => request()->reference,
            'amount'                   => request()->amount,
            'destinationAccount'       => request()->destinationAccount,
            'senderPrincipal'          => request()->senderPrincipal,
            'senderCredentials'        => request()->senderCredentials,
            'currency'                 => request()->currency,
            'destinationBank'          => request()->destinationBank,
            'sendWithdrawalCode'       => (request()->sendWithdrawalCode) ? request()->sendWithdrawalCode : null,
            'transferReference'        => (request()->transferReference) ? request()->transferReference : null,
            'suppressRecipientMessage' => (request()->suppressRecipientMessage) ? true : false,
            'alternateSenderName'      => (request()->alternateSenderName) ? request()->alternateSenderName : null,
            'minRecipientKYCLevel'     => (request()->minRecipientKYCLevel) ? request()->minRecipientKYCLevel : null,
            'holdingPeriod'            => (request()->holdingPeriod) ? request()->holdingPeriod : null,
        ];

        $hash = createHash($this->apiKey, [
            $body['referenceNumber'],
            $body['amount'],
            $body['destinationAccount'],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/moneyTransfer';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Make bulk money transfer via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function moneyTransferBulk()
    {
        $body = [
            'bulkReferenceNumber' => request()->bulkReferenceNumber,
            'items'               => request()->moneyTransferItems,
        ];

        $hash = createHash($this->apiKey, [
            $body['items'][0]['referenceNumber'],
            $body['items'][0]['amount'],
            $body['items'][0]['destinationAccount'],
            count($body['items']),
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/moneyTransferBulk';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * OnBoard merchant -> create sub organizations on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function onBoardMerchant()
    {
        $body = [
            'reference'          => request()->reference,
            'merchantExternalId' => request()->merchantExternalId,
            'merchantInfo'       => request()->merchantInfo,
            'integration'        => request()->integration,
        ];

        $hash = createHash($this->apiKey, [
            $body['reference'],
            $body['merchantExternalId'],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/onboardMerchant';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Make payments to registered merchants on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function merchantPayment()
    {
        $body = [
            'referenceNumber'         => request()->reference,
            'amount'                  => request()->amount,
            'merchantAccount'         => request()->merchantAccount,
            'merchantReferenceNumber' => request()->merchantReferenceNumber,
            'currency'                => request()->currency,
            'merchantService'         => request()->merchantService,
        ];

        $hash = createHash($this->apiKey, [
            $body[ 'referenceNumber' ],
            $body[ 'amount' ],
            $body[ 'merchantAccount' ],
            $body[ 'merchantReferenceNumber' ],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/merchantPayment';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Get merchant Paga transaction history.
     * Pass a transaction reference to fetch a specific transaction.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function transactionHistory()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/transactionHistory';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Get merchant recent Paga transaction history.
     * Return last 5 transactions on their Paga account.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function recentTransactionHistory()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/recentTransactionHistory';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Register customers on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function registerCustomer()
    {
        $body = [
            'referenceNumber'     => request()->reference,
            'customerPhoneNumber' => request()->customerPhoneNumber,
            'customerFirstName'   => request()->customerFirstName,
            'customerLastName'    => request()->customerLastName,
            'customerEmail'       => request()->customerEmail,
            'customerDateOfBirth' => request()->customerDateOfBirth,
        ];

        $hash = createHash($this->apiKey, [
            $body['referenceNumber'],
            $body['customerPhoneNumber'],
            $body['customerFirstName'],
            $body['customerLastName'],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/registerCustomer';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }

    /**
     * Validate customer created on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     * @throws Exceptions\IsNullException
     * @throws GuzzleException
     */
    public function validateCustomer()
    {
        $body = [
            'referenceNumber'    => request()->reference,
            'customerIdentifier' => request()->customerIdentifier,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/validateCustomer';

        return $this->setRequestService($hash)
            ->makeHttpRequest('POST', $endpoint, $body);
    }
}
