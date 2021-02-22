# laravel-paga

[![Latest Version on Packagist](https://img.shields.io/packagist/v/phalconvee/laravel-paga.svg?style=flat-square)](https://packagist.org/packages/phalconvee/laravel-paga)
![Packagist License](https://img.shields.io/packagist/l/paga/paga-business?style=flat-square)
[![Build Status](https://img.shields.io/travis/phalconvee/laravel-paga/master.svg?style=flat-square)](https://travis-ci.org/phalconvee/laravel-paga)
[![Quality Score](https://img.shields.io/scrutinizer/g/phalconvee/laravel-paga.svg?style=flat-square)](https://scrutinizer-ci.com/g/phalconvee/laravel-paga)
[![Total Downloads](https://img.shields.io/packagist/dt/phalconvee/laravel-paga.svg?style=flat-square)](https://packagist.org/packages/phalconvee/laravel-paga)

A Laravel package for working with the Paga Business API.

## Installation
[PHP](https://php.net) 5.4+, and [Composer](https://getcomposer.org) are required.

You can get the latest version of Laravel Paga via composer:

```bash
composer require phalconvee/laravel-paga
```

You'll need to run `compser install` or `composer update` to download it and have the autoloader updated.

Once Laravel Paga is installed, you need to register the service provider. Open up `config/app.php` and add the following to the providers key

```php
'providers' => [
    ...
    Phalconvee\Paga\PagaServiceProvider::class,
    ...
]
```
> If you use **Laravel >= 5.5** you can skip this step and go to [**`configuration`**](https://https://github.com/phalconVee/laravel-paga/laravel-paga#configuration)
* `Phalconvee\Paga\PagaServiceProvider::class`

Also, register the Facade like so:

```php
'aliases'=>[ 
    ...
    'Paga' => Phalconvee\Paga\Facades\Paga::class
    ...
]
```
## Configuration
You can publish the configuration file using this command:
```bash
php artisan vendor:publish --provider="Phalconvee\Paga\PagaServiceProvider"
```

A configuration-file named `paga.php` with some defaults will be placed in your `config` directory:
```php
<?php
return [

    /**
     * API Key From Paga Dashboard
     */
    'apiKey' => env('PAGA_HMAC_API_KEY'),

    /**
     * Public Key From Paga Dashboard
     */
    'publicKey' => env('PAGA_PUBLIC_KEY'),

    /**
     * Secret Key / Credentials From Paga Dashboard
     */
    'secretKey' => env('PAGA_SECRET_KEY')

];
```

## Business services exposed by the package
- getBanks
- getMerchants
- getMerchantServices
- getMobileOperators
- getOperationStatus
- accountBalance
- airtimePurchase
- depositToBank
- validateDepositToBank
- moneyTransfer
- moneyTransferBulk
- onboardMerchant
- merchantPayment
- transactionHistory
- recentTransactionHistory
- registerCustomer
- validateCustomer

## Usage
Open your .env file and add your api key, public key, and secret key/credentials like so:
``` php
PAGA_HMAC_API_KEY=xxxxxxxxxxxxxx
PAGA_PUBLIC_KEY=xxxxxxxxxxxxxx
PAGA_SECRET_KEY=xxxxxxxxxxxxxx
```
If you are using a hosting service like AWS, heroku, ensure to add the above details to your environment variables and configuration variables respectively.

### 1. Prerequisites
Confirm that your server can conclude a TLSv1.2 connection to Paga's servers. Most up-to-date software have this capability. Contact your service provider for guidance if you have any SSL errors. 
*Don't disable SSL peer verification!*

### 2. Initialize server environment
You'll need to initialize the server environment you intend to run your request against, when performing tasks on Paga.

There's both the *test* and *live* environment. Your credentials will be authenticated against the enironment you initialize.

It is recommended to initialize this environment in your constructor when using this package within a controller class.

```php
<?php
    
    use Phalconvee\Paga\Facades\Paga;
    
    class MyExampleController extends Controller
    {
        public function __construct()
        {
            Paga::setTest(true); // passing false (boolean) sets environment to live.
        }
    }
```  

This package provides fluent methods as well. See below.
```php
/**
* This method generates a unique secure cryptographic hash token to use as transaction reference.
* @returns string
*/
Paga::getTransactionReference();

/** Alternatively, use the helper */    
paga()->getTransactionReference();

/**
* This method returns list of banks integrated with Paga.
* @returns array
*/
Paga::getBanks();

/** Alternatively, use the helper */    
paga()->getBanks();

/**
* This method returns list of merchants integrated with Paga.
* @returns array 
*/
Paga::getMerchants();

/** Alternatively, use the helper */    
paga()->getMerchants();

/**
* This method returns list of merchants services registered on Paga.
* @returns array 
*/
Paga::getMerchantServices();

/** Alternatively, use the helper */    
paga()->getMerchantServices();

/**
* This method returns operation status per transaction.
* @returns array 
*/
Paga::getOperationStatus();

/** Alternatively, use the helper */    
paga()->getOperationStatus();

/**
* This method returns mobile operators on Paga.
* @returns array 
*/
Paga::getMobileOperators();

/** Alternatively, use the helper */    
paga()->getMobileOperators();

/**
* This method allows you to transfer funds from a variety of sources via Paga.
* @returns array 
*/
Paga::moneyTransfer();

/** Alternatively, use the helper */    
paga()->moneyTransfer();

/**
* This method allows you to make bulk money transfer via Paga.
* @returns array 
*/
Paga::moneyTransferBulk();

/** Alternatively, use the helper */    
paga()->moneyTransferBulk();

/**
* This method allows you to purchase airtime via Paga.
* @returns array 
*/
Paga::airtimePurchase();

/** Alternatively, use the helper */    
paga()->airtimePurchase();

/**
* This method allows you to get account balance on Paga.
* @returns array 
*/
Paga::accountBalance();

/** Alternatively, use the helper */    
paga()->accountBalance();

/**
* This method allows you deposit funds into any bank account.
* @returns array 
*/
Paga::depositToBank();

/** Alternatively, use the helper */    
paga()->depositToBank();

/**
* This method allows to validate deposit to bank via Paga.
* @returns array 
*/
Paga::validateDepositToBank();

/** Alternatively, use the helper */    
paga()->validateDepositToBank();

/**
* This method allows to make payments to registered merchants on Paga.
* @returns array 
*/
Paga::merchantPayment();

/** Alternatively, use the helper */    
paga()->merchantPayment();

/**
* This method gets merchant Paga transaction history.
* @returns array 
*/
Paga::transactionHistory();

/** Alternatively, use the helper */    
paga()->transactionHistory();

/**
* This method gets merchant recent Paga transaction history (last 5 records).
* @returns array 
*/
Paga::recentTransactionHistory();

/** Alternatively, use the helper */    
paga()->recentTransactionHistory();

/**
* This method allows aggreagtor organisations create sub organisations on Paga.
* @returns array 
*/
Paga::onBoardMerchant();

/** Alternatively, use the helper */    
paga()->onBoardMerchant();

/**
* This method creates customer on Paga.
* @returns array 
*/
Paga::registerCustomer();

/** Alternatively, use the helper */    
paga()->registerCustomer();

/**
* This method validates customer created on Paga.
* @returns array 
*/
Paga::validateCustomer();

/** Alternatively, use the helper */    
paga()->validateCustomer();
```
### 3. Closing notes
For more information on the services listed above, visit the [Paga DEV website](https://developer-docs.paga.com/docs/php-library-1)

Check [SAMPLES](SAMPLES.md) for more sample calls.

### Todo

* Add Comprehensive Tests
* Implement advanced customer verification methods.

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please feel free to fork this package and contribute by submitting a pull request to enhance the functionalities.

### Security

If you discover any security related issues, please email phalconvee@gmail.com instead of using the issue tracker.

## How can I thank you?

Kindly star the github repo. You can also share the link for this repository on Twitter, StackOverflow
or HackerNews.

[Follow me on twitter](https://twitter.com/_impact_dev)!

I Appreciate it 🙏. Henry Ugochukwu.

## Credits

- [Henry Ugochukwu](link-author)
- [All Contributors](link-contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
