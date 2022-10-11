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

1. Add configuration to `config/services.yaml` with your Google Tag identificator

    ```yaml
    spinbits_sylius_google_analytics4:
        id: "G-XXXXXXXXXX"
    ```

2. Install plugin:

    ```bash
    composer require spinbits/google-analytics-4-plugin
    ```

### Develop

1. Execute `make start`

2. See your browser `open localhost`

You can find more examples in tests directory and in this repo: [Google Analytics 4 Enhanced ecommerce Plugin](https://github.com/spinbits/sylius-google-analytics-plugin)

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email office@spinbits.io instead of using the issue tracker.

## Credits

- [Spinbits][link-author]
- [Jakub Lech](https://github.com/jakublech)
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/spinbits/google-analytics-4-events-dto-s.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/spinbits/google-analytics-4-events-dto-s/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/spinbits/google-analytics-4-events-dto-s.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/spinbits/google-analytics-4-events-dto-s.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/spinbits/google-analytics-4-events-dto-s.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/spinbits/google-analytics-4-events-dto-s
[link-travis]: https://travis-ci.org/spinbits/google-analytics-4-events-dto-s
[link-scrutinizer]: https://scrutinizer-ci.com/g/spinbits/google-analytics-4-events-dto-s/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/spinbits/google-analytics-4-events-dto-s
[link-downloads]: https://packagist.org/packages/spinbits/google-analytics-4-events-dto-s
[link-author]: https://github.com/spinbits
[link-contributors]: ../../contributors
