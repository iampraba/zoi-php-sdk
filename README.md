<a href="https://zoho.com/catalyst/">
    <img width="300" src="https://www.zohowebstatic.com/sites/zweb/images/productlogos/officeintegrator.svg">
</a>

# PHP SDK

[![PHP Version Require](http://poser.pugx.org/officeintegrator/zoi-php-sdk/require/php)](https://packagist.org/packages/officeintegrator/zoi-php-sdk) [![Downloads](https://poser.pugx.org/officeintegrator/zoi-php-sdk/d/total.svg)](https://packagist.org/packages/officeintegrator/zoi-php-sdk) [![License](https://poser.pugx.org/officeintegrator/zoi-php-sdk/license.svg)](https://packagist.org/packages/officeintegrator/zoi-php-sdk)

## Table Of Contents

* [Getting Started](#getting-Started)
* [Registering a Zoho Office Integrator APIKey](#registering-a-zoho-office-integrator-apikey)
* [Environmental Setup](#environmental-setup)
* [Including the SDK in your project](#including-the-sdk-in-your-project)
* [Configuration](#configuration)
* [Initialization](#initializing-the-application)
* [Sample Code](#sdk-sample-code)
* [License](#license)

## Getting Started

Zoho Office Integrator PHP SDK used to help you quickly integrator Zoho Office Integrator editors in side your web application.

## Registering a Zoho Office Integrator APIKey

Since Zoho Office Integrator APIs are authenticated with apikey, you should register your with Zoho to get an apikey. To register your app:

- Visit this page [https://officeintegrator.zoho.com/](https://officeintegrator.zoho.com). ( Sign-up for a Zoho Account if you don't have one)

- Enter your company name and short description about how you are going to using zoho office integrator in your application. Choose the type of your application(commerial or non-commercial) and generate the apikey.

- After filling above details, create an account in Zoho Office Integrator service and copy the apikey from the dashboard.

## Environmental Setup

PHP SDK is installable through **composer**. **composer** is a tool for dependency management in PHP. Composer installs PHP sdk in your application from **[packagist](https://packagist.org/packages/officeintegrator/zoi-php-sdk)**.

- Client app must have PHP(version 7.0 and above)

- composer must be installed in your machine

## Including the SDK in your project

You can include the SDK to your project using:

- Install **composer** from [getcomposer.org](https://getcomposer.org/download/) (if not installed).

- Install **PHP SDK**
    - Navigate to the workspace of your client app.
    - Create a composer.json in your application add **zoi-nodejs-sdk** in dependency list. [Example](https://github.com/iampraba/zoi-php-sdk-examples/blob/main/composer.json)
    - Now run the command below:

    ```sh
    composer install
    ```
- The PHP SDK will be installed and a package named **/zoi-php-sdk-1.*.*** will be created in your work space under the vendor folder.


## Configuration

Before you get started with creating your PHP application, you need to register with Zoho Office Integrator to get an apikey for authentication. 

- Configure **API environment** which decides the domain and the URL to make API calls.

    ```php
    /*
     * Refer this help page for api end point domain details -  https://www.zoho.com/officeintegrator/api/v1/getting-started.html
    */
    $environment = new Production("https://api.office-integrator.com");
    ```

- Use below script to configure your apikey that you get from [Zoho Office Integrator](https://officeintegrator.zoho.com) dashboard.

    ```php
    /**
     * You can configure where the apikey needs to added in the request object.
     * User can either pass the apikey in the addParam or addHeader method
     */
    $authBuilder = new AuthBuilder();
    $authentication = new Authentication();
    $authBuilder->addParam("apikey", "2ae438cf864488657cc9754a27daa480");
    $authBuilder->authenticationSchema($authentication->getTokenFlow());
    $tokens = [ $authBuilder->build() ];
    $apikey = new APIKey("2ae438cf864488657cc9754a27daa480", Constants::PARAMS);
    ```

- Create an instance of **Logger** Class to log exception and API information. By default, the SDK constructs a Logger instance with level - INFO and file_path - (sdk_logs.log parallel to node_modules)

    ```php
    /*
    * Create an instance of Logger Class that requires the following
    * level -> Level of the log messages to be logged. Can be configured by typing Levels "." and choose any level from the list displayed.
    * filePath -> Absolute file path, where messages need to be logged.
    */
    $logger = (new LogBuilder())
            ->level(Levels::INFO)
            ->filePath("./app.log")
            ->build();
    ```

## Initializing the Application

Initialize the SDK using the following code.

```php
<?php

use com\zoho\api\authenticator\AuthBuilder;
use com\zoho\officeintegrator\dc\apiserver\Production;
use com\zoho\officeintegrator\InitializeBuilder;
use com\zoho\officeintegrator\logger\Levels;
use com\zoho\officeintegrator\logger\LogBuilder;
use com\zoho\officeintegrator\v1\Authentication;

require_once 'vendor/autoload.php';

class Initialize {
    public static function initializeSdk() {

        # Update the api domain based on in which data center user register your apikey
        # To know more - https://www.zoho.com/officeintegrator/api/v1/getting-started.html
        $environment = new Production("https://api.office-integrator.com");
        # User your apikey that you have in office integrator dashboard
        //Update this apikey with your own apikey signed up in office inetgrator service
        $authBuilder = new AuthBuilder();
        $authentication = new Authentication();
        $authBuilder->addParam("apikey", "2ae438cf864488657cc9754a27daa480");
        $authBuilder->authenticationSchema($authentication->getTokenFlow());
        $tokens = [ $authBuilder->build() ];

        # Configure a proper file path to write the sdk logs
        $logger = (new LogBuilder())
            ->level(Levels::INFO)
            ->filePath("./app.log")
            ->build();
        
        (new InitializeBuilder())
            ->environment($environment)
            ->tokens($tokens)
            ->logger($logger)
            ->initialize();

        echo "SDK initialized successfully.\n";
    }
}

Initialize::initializeSdk();
```

- You can now access the functionalities of the SDK. Refer to the sample codes to make various API calls through the SDK.

## SDK Sample code

- Make sure you have [initialized the sdk](#initializing-the-application) before running below sample code snippet.
- Refer this **[repository](https://github.com/iampraba/zoi-php-sdk-examples)** for example codes to all Office Integrator API endpoints.

## License

This SDK is distributed under the [Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0), see LICENSE.txt for more information.
