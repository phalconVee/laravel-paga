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
     * Issue API Key from your Paga Dashboard.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Issue Public Key from your Paga Dashboard.
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Issue Password from your Paga Dashboard.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Set Server URL (e.g true = Use Test URL, false = Use Live URL).
     *
     * @var string
     */
    protected $url;

    /**
     *  Response from requests made to Paga.
     *
     * @var mixed
     */
    protected $response;

    /**
     * Define Live API URL.
     */
    const LIVE_API_URL = 'https://www.mypaga.com';

    /**
     * Define Test API url.
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
     * Get Public key from Paga config file.
     */
    private function setPublicKey()
    {
        $this->publicKey = config('paga.publicKey');
    }

    /**
     * Get Secret Key from Paga config file.
     */
    private function setSecretKey()
    {
        $this->secretKey = config('paga.secretKey');
    }

    /**
     * Set App Environment.
     *
     * @param bool $test
     */
    public function setTest($test = false)
    {
        $this->url = ($test) ? self::TEST_API_URL : self::LIVE_API_URL;
    }

    /**
     * Set Service for making the Client request.
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
     */
    public function getBanks()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getBanks';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return list of merchants integrated with Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function getMerchants()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getMerchants';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return merchant services registered on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function getMerchantServices()
    {
        $body = [
            'referenceNumber'  => request()->reference,
            'merchantPublicId' => request()->merchantPublicId,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getMerchantServices';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return operation status per transaction.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function getOperationStatus()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getOperationStatus';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return mobile operators on the Paga platform.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function getMobileOperators()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/getMobileOperators';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Register customers on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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
            $body[ 'referenceNumber' ],
            $body[ 'customerPhoneNumber' ],
            $body[ 'customerFirstName' ],
            $body[ 'customerLastName' ],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/registerCustomer';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Transfer funds from a variety of sources via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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
            $body[ 'referenceNumber' ],
            $body[ 'amount' ],
            $body[ 'destinationAccount' ],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/moneyTransfer';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Make bulk money transfer via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function moneyTransferBulk()
    {
        $body = [
            'bulkReferenceNumber' => request()->bulkReferenceNumber,
            'items'               => request()->moneyTransferItems,
        ];

        $hash = createHash($this->apiKey, [
            $body[ 'items' ][ 0 ][ 'referenceNumber' ],
            $body[ 'items' ][ 0 ][ 'amount' ],
            $body[ 'items' ][ 0 ][ 'destinationAccount' ],
            count($body[ 'items' ]),
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/moneyTransferBulk';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Purchase airtime via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get account balance on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function accountBalance()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/accountBalance';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Operation to deposit funds into any bank account via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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
            $body[ 'referenceNumber' ],
            $body[ 'amount' ],
            $body[ 'destinationBankUUID' ],
            $body[ 'destinationBankAccountNumber' ],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/depositToBank';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Validate deposit operation to bank via Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Make payments to registered merchants on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get merchant Paga transaction history.
     * Pass a transaction reference to fetch a specific transaction.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function transactionHistory()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/transactionHistory';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get merchant recent Paga transaction history.
     * Return last 5 transactions on their Paga account.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function recentTransactionHistory()
    {
        $body = [
            'referenceNumber' => request()->reference,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/recentTransactionHistory';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * OnBoard merchant -> create sub organizations on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
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
            $body[ 'reference' ],
            $body[ 'merchantExternalId' ],
        ]);

        $endpoint = 'paga-webservices/business-rest/secured/onboardMerchant';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }

    /**
     * Validate customer created on Paga.
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface|string|null
     */
    public function validateCustomer()
    {
        $body = [
            'referenceNumber'    => request()->reference,
            'customerIdentifier' => request()->customerIdentifier,
        ];

        $hash = createHash($this->apiKey, $body);

        $endpoint = 'paga-webservices/business-rest/secured/validateCustomer';

        try {
            return $this->setRequestService($hash)
                ->makeHttpRequest('POST', $endpoint, $body);
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exceptions\IsNullException $e) {
            return $e->getMessage();
        }
    }
}
