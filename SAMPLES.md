#Sample Calls

Assumes that you already installed and configured Phalconvee\Paga. 
Check [README](README.md) for details.

```php
  // Initialize server environment
    Paga::setTest(true);

    // Get reference
    $reference = Paga::getTransactionReference();

    // Get Banks
    $request->reference = $reference;
    $res = Paga::getBanks();

    // Get Merchants
    $request->reference = $reference;
    $res = Paga::getMerchants();

    // Get Merchant Services
    $request->reference = $reference;
    $request->merchantPublicId = "13B5041B-7143-46B1-9A88-F355AD7EA1EC";
    $res = Paga::getMerchantServices();

    // Get Operation Status
    $request->reference = $reference;
    $res = Paga::getOperationStatus();

    // Get Mobile Operators
    $request->reference = $reference;
    $res = Paga::getMobileOperators();

    // Get Mobile Operators
    $request->reference = $reference;
    $res = Paga::getMobileOperators();

    // Register Customer
    $request->reference = $reference;
    $request->customerPhoneNumber = "08062818753";
    $request->customerFirstName = "Ciroma";
    $request->customerLastName = "Adekunle";
    $request->customerEmail = "ciroma.adekunle@xyz.com";
    $request->customerDateOfBirth = "1990-08-14";
    $res = Paga::registerCustomer();

    // Money Transfer
    $request->reference = $reference;
    $request->amount = 1000.00;
    $request->currency = "NGN";
    $request->destinationAccount = "07037299643";
    $request->destinationBank = "";
    $request->withdrawalCode = false;
    $request->sourceOfFunds = "PAGA";
    $request->transferReference = $reference;
    $request->suppressRecipientMessage = true;
    $request->alternateSenderName = "";
    $request->minRecipientKYCLevel = "KYC1";
    $request->holdingPeriod = 31;
    $res = Paga::moneyTransfer();

    // Airtime Purchase
    $request->reference = $reference;
    $request->amount = 100.00;
    $request->destinationPhoneNumber = "08166601864";
    $res = Paga::airtimePurchase();

    // Get Account Balance
    $request->reference = $reference;
    $res = Paga::accountBalance();

    // Deposit to Bank
    $request->reference = $reference;
    $request->amount = 1000.00;
    $request->destinationBankUUID = "40090E2F-7446-4217-9345-7BBAB7043C4C";
    $request->destinationBankAccountNumber = "0016304010";
    $request->recipientPhoneNumber = "08166601864";
    $request->currency = "NGN";
    $res = Paga::depositToBank();

    // Validate Deposit to Bank
    $request->reference = 'mVDFd3B1jsEukBwVh2hiKDquZ';
    $request->amount = 1000.00;
    $request->destinationBankUUID = "40090E2F-7446-4217-9345-7BBAB7043C4C";
    $request->destinationBankAccountNumber = "0016304010";
    $res = Paga::validateDepositToBank();

    // Bulk Money Transfer
    $items = [
        [
            'referenceNumber' => $reference,
            'amount' => 500.00,
            'currency' => 'NGN',
            'destinationAccount' => "08030408527",
            'destinationBank' => "",
            'transferReference' => $reference,
            'sourceOfFunds' => "PAGA",
            'sendWithdrawalCode' => false,
            'suppressRecipientMessage' => true,
            'minRecipientKYCLevel' => "KYC1",
            'holding' => 31,
        ],
        [
            'referenceNumber' => $reference,
            'amount' => 1000.00,
            'currency' => 'NGN',
            'destinationAccount' => "08060075922",
            'destinationBank' => "",
            'transferReference' => $reference,
            'sourceOfFunds' => "PAGA",
            'sendWithdrawalCode' => false,
            'suppressRecipientMessage' => true,
            'minRecipientKYCLevel' => "KYC1",
            'holding' => 31,
        ]
    ];

    $request->bulkReferenceNumber = "bulk-". $reference;
    $request->moneyTransferItems = $items;
    $res = Paga::moneyTransferBulk();

    // Merchant Payment
    $request->reference = $reference;
    $request->amount = 1500.00;
    $request->merchantAccount = "13B5041B-7143-46B1-9A88-F355AD7EA1EC";
    $request->merchantReferenceNumber = "mer-1568801867898";
    $request->currency = "NGN";
    $request->merchantService = ["MY002"];
    $res = Paga::merchantPayment();

    // Transaction Hstory
    $request->reference = "WXA37UH4MRP4ECPSYRT9J7EJR";
    $res = Paga::transactionHistory();

    // Recent Transaction History
    $request->reference = $reference;
    $res = Paga::recentTransactionHistory();

    // Onboard Merchants
    $merchantInfo = [
        "legalEntity" => [
            "name" => "Madam UK Fish Shop",
            "description" => "business",
            "addressLine1" => "8 Esietedo street",
            "addressLine2" => "Apapa lighter terminal",
            "addressCity" => "Apapa",
            "addressState" => "Lagos",
            "addressZip" => "xxxx",
            "addressCountry" => "Nigeria",
        ],
        "legalEntityRepresentative" => [
            "firstName" => "Chukwuma",
            "lastName" => "Nwoko",
            "dateOfBirth" => "1995-05-02T07:45:37.726+03:00",
            "phone" => "+2348188215379",
            "email" => "john.doe@email.com",
        ],
        "additionalParameters" => [
            "establishedDate" => "2014-03-13T19:53:37.726+03:00",
            "websiteUrl" => "https://flutterwave.com/store/madamukfishshop",
            "displayName" => "Madam UK Fish Shop",
        ]
    ];

    // Intergation is of two types:
    // Email Notification
    $emailIntegration = [
        "type" => "EMAIL_NOTIFICATION",
        "financeAdminEmail" => "gfinance@mail.com"
    ];
    // Merchant Notification
    $merchantIntegration = [
        "type" => "MERCHANT_NOTIFICATION_REVERSE_API",
        "callbackUrl" => "https://mywebhook.com/callback",
        "username" => "username",
        "password" => "password",
    ];

    $request->reference = $reference;
    $request->merchantExternalId = "MDUK". $reference . "-". rand(11, 10000000); //  to be provided by you (in this format)
    $request->merchantInfo = $merchantInfo;
    $request->integration = $emailIntegration;
    $res = Paga::onBoardMerchant();

    // Validate Customer
    $request->reference = $reference;
    $request->customerIdentifier = "08062818753"; // value that identifies the user (e.g. Phone number)
    $res = Paga::validateCustomer();

    echo '<pre>';
    print_r($res);
```
