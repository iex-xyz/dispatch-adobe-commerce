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
   php bin/magento setup:upgrade
   ```
3. Compile the module code and other existing module
   ```
   php bin/magento setup:di:compile;
   ```
4. Static content deployment
   ```
   php bin/magento s:s:d -f;
   ```   
   


## Magento backend configuration

1. ```Dispatch -> SalesChannel -> General Settings -> Enable Module```
    
    The configutation path is ```sales_channel/general/enable```


2. ```Dispatch -> SalesChannel -> General Settings -> Dispatch API Key```

    The configutation path is ```sales_channel/general/api_key```. The Dispatch Api key will be provided by Dispatch team.
    

3. ```Dispatch -> SalesChannel -> General Settings -> Dispatch Account Id```

    The configutation path is ```sales_channel/general/account_id```. The Dispatch Account Id key will be provided by Dispatch team.


4. ```Dispatch -> SalesChannel -> General Settings -> Catalog Id```

    This configuration will let you controll which category you would like to sync with Dispatch platform. You can either choose All Categories or Specific one based on your needs.


5. ```Dispatch -> SalesChannel -> General Settings -> Preferred Payment Method```

    This configuration will let you controll which Payment you would like to allow customer to checkout through   Dispatch platform. You can select the Specific one based on your needs.    

6. ```Dispatch -> SalesChannel -> General Settings -> Payment Method Publishable/Client Key```

    This configuration will let you share the public key with Dispatch platform. 

