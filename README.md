# SalesChannel By Dispatch

Dispatch enables merchants using Adobe Commerce (Magento 2) to engage and sell products to customers directly through various sales and marketing channels.

## What does it do?

Your implementation will allow your business to start selling in new channels with Dispatch, while having orders and payments processed through existing PSP, just like your business’s ecommerce website.
 
## Installation
  
1. Install via composer
   Dispatch will provide an Adobe Commerce Plugin (In Progress). Setup will look like this:
   Note: both repositories need to be configured until the package and its dependency are available through packagist.
   ```
   
   composer config repositories.dispatch-sales-channel git https://github.com/iex-xyz/nexus-box-adobe-commerce.git
   composer require dispatch/sales-channel or
   composer require dispatch/sales-channel dev-main
   ```
2. Enable module
   ```
   bin/magento setup:upgrade
   ```
   
## Upgrading

```
bin/magento setup:upgrade
```


## Magento backend configuration

1. ```Dispatch -> SalesChannel -> General Settings -> Enable Module```
    
    The configutation path is ```sales_channel/general/enable```


2. ```Dispatch -> SalesChannel -> General Settings -> Dispatch API Key```

    The configutation path is ```sales_channel/general/api_key```
    
