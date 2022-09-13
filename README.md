[![image](./docs/img/spinbits.jpg)](https://spinbits.io)
# Google Analytics 4 Enhanced ecommerce Plugin

## Overview

This plugin is used to connect Sylius with [Google Analytics 4](https://developers.google.com/analytics/devguides/collection/ga4) using Google Tag Manager ([gtag.js](https://developers.google.com/tag-platform/gtagjs/reference)). 
It integrates with all ecommerce GA4 [events](https://developers.google.com/analytics/devguides/collection/ga4/reference/events). 
Additionaly it measures page load time and post it as event to GA4.

| Event | Description |
|-------|-------------|
|add_to_cart|A user adds one or more products to a shopping cart|
|view_cart|A user loaded shopping cart view|
|remove_from_cart|A user removed item from shopping cart|
|begin_checkout|A user initiates the checkout process for one or more products|
|add_shipping_info|A user provided shipping data in checkout process|
|add_payment_info|A user provided payment data in checkout process|
|purchase|A user completes a purchase|
|view_item|A user views details for a product|
|search|A user searched for a term|
|view_item_list|A user views a list of one or more products|
|login|A user logged in to the shop|
|signup|A user signup in to the shop|
|timing_complete| Measures page load time|

## Links
https://support.google.com/tagmanager/answer/6103696?hl=pl&ref_topic=3441530  
https://developers.google.com/analytics/devguides/collection/protocol/ga4  
https://ga-dev-tools.web.app/ga4/event-builder/  
https://support.google.com/tagassistant/answer/10042782  
https://tagassistant.google.com/

## Details
It is designed based on backend Sylius events for high compatibility no matter what template your Sylius store is using.

## Quickstart Installation

1. Install plugin:

    ```bash
    composer require spinbits/google-analytics-4-plugin
    ```

2. Add to bundles.php

    ```php
        Spinbits\SyliusGoogleAnalytics4Plugin\SpinbitsSyliusGoogleAnalytics4Plugin::class => ['all' => true],
    ```

3. Add configuration to `config/services.yaml`

    ```yaml
    spinbits_sylius_google_analytics4:
        enabled: true
        id: "G-WX1RJ8SP3R"
    ```


### Develop

1. Execute `make start`

2. See your browser `open localhost`

## Usage

### Running plugin tests

  - PHPUnit

    ```bash
    vendor/bin/phpunit
    ```

  - PHPSpec

    ```bash
    vendor/bin/phpspec run
    ```

  - Behat (non-JS scenarios)

    ```bash
    vendor/bin/behat --strict --tags="~@javascript"
    ```

  - Behat (JS scenarios)
 
    1. [Install Symfony CLI command](https://symfony.com/download).
 
    2. Start Headless Chrome:
    
      ```bash
      google-chrome-stable --enable-automation --disable-background-networking --no-default-browser-check --no-first-run --disable-popup-blocking --disable-default-apps --allow-insecure-localhost --disable-translate --disable-extensions --no-sandbox --enable-features=Metal --headless --remote-debugging-port=9222 --window-size=2880,1800 --proxy-server='direct://' --proxy-bypass-list='*' http://127.0.0.1
      ```
    
    3. Install SSL certificates (only once needed) and run test application's webserver on `127.0.0.1:8080`:
    
      ```bash
      symfony server:ca:install
      APP_ENV=test symfony server:start --port=8080 --dir=tests/Application/public --daemon
      ```
    
    4. Run Behat:
    
      ```bash
      vendor/bin/behat --strict --tags="@javascript"
      ```
    
  - Static Analysis
  
    - Psalm
    
      ```bash
      vendor/bin/psalm
      ```
      
    - PHPStan
    
      ```bash
      vendor/bin/phpstan analyse -c phpstan.neon -l max src/  
      ```

  - Coding Standard
  
    ```bash
    vendor/bin/ecs check src
    ```

### Opening Sylius with your plugin

- Using `test` environment:

    ```bash
    (cd tests/Application && APP_ENV=test bin/console sylius:fixtures:load)
    (cd tests/Application && APP_ENV=test bin/console server:run -d public)
    ```
    
- Using `dev` environment:

    ```bash
    (cd tests/Application && APP_ENV=dev bin/console sylius:fixtures:load)
    (cd tests/Application && APP_ENV=dev bin/console server:run -d public)
    ```
