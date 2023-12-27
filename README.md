# Dispatch Adobe Commerce Plugin
[Dispatch - Marketplace Listing](https://commercemarketplace.adobe.com/dispatch-sales-channel.html)

Dispatch enables merchants using Adobe Commerce (Magento 2) to engage and sell products to customers directly through various sales and marketing channels.

Your implementation will allow your business to start selling in new channels with Dispatch, while having orders and payments processed through existing PSP, just like your business’s ecommerce website.
 
## Installation
Add the plugin:

[Dispatch - Marketplace Listing](https://commercemarketplace.adobe.com/dispatch-sales-channel.html)
  
1. Install via composer
   Dispatch will provide an Adobe Commerce Plugin/ Setup will look like this:
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

## AdobeCommerce Integration Keys
Dispatch needs an AdobeCommerce Integration configured so it has access to create orders and sync products on your behalf. Dispatch never accesses any data unrelated to the Products and Orders it serves via your configured Dispatch Sales Channels.

The integration needs access to the following resources to read product data and create orders on your behalf:

- Sales
- - Operations 
- - Billing Agreements
- - Transactions
- - Shopping Cart Management
- - Catalog (Readonly)
- - Categories (Readonly)
- - Carts
- Stores
- - Settings (Sitemap, developer, analytics etc. not needed)
- - Inventory (Readonly)
- - Stocks (Sales Stock only)
- - Taxes
- - Currency
- - Attributes

If you have any concerns or questions about these permissions, contact your Dispatch representative. 

Once you have configured this key, you need to share it with your account rep or email support@dispatch.co to request secure transmission of this key.
   


## Magento backend configuration

Important - when making changes, click "Save Config" before clicking "Sync" to send your configuration to Dispatch. You can test that all fields are filled out properly by clicking the Test Connection button.

1. ```Dispatch -> SalesChannel -> General Settings -> Enable Module```
    
    The configuration path is ```sales_channel/general/enable```
    ![Example showing Sales Enable](https://res.cloudinary.com/dispatchxyz/image/upload/v1702309832/adobecommercegithub/base_adobecommerce_guide_copy_zbck5s.png)
    

2. ```Dispatch -> SalesChannel -> General Settings -> Dispatch API Key```

    The configuration path is ```sales_channel/general/api_key```. The Dispatch API key will be provided by Dispatch team. Email support@dispatch.co to request a key.
    ![Example showing Dispatch API key](https://res.cloudinary.com/dispatchxyz/image/upload/v1702309831/adobecommercegithub/base_adobecommerce_guide_copy_2_wfzbsr.png)
    

3. ```Dispatch -> SalesChannel -> General Settings -> Dispatch Account Id```

    The configuration path is ```sales_channel/general/account_id```. The Dispatch Account Id will be provided by Dispatch team. Email support@dispatch.co to request an Account Id.
    ![Example showing Account Id](https://res.cloudinary.com/dispatchxyz/image/upload/v1702309831/adobecommercegithub/base_adobecommerce_guide_copy_3_jzdzz4.png)    


4. ```Dispatch -> SalesChannel -> General Settings -> Catalog Id```

    This configuration will let you control which category you would like to sync with Dispatch platform. You can either choose All Categories or Specific one based on your needs.
    ![Example showing Catalog Id](https://res.cloudinary.com/dispatchxyz/image/upload/v1702309831/adobecommercegithub/base_adobecommerce_guide_copy_4_impx0h.png)   


5. ```Dispatch -> SalesChannel -> General Settings -> Preferred Service Provider Method```

    This configuration will let you control which Payment Processor you would like to allow customer to checkout through the Dispatch platform. You can select the Specific one based on your needs.   
    ![Example showing Preferred Payment](https://res.cloudinary.com/dispatchxyz/image/upload/v1702309984/adobecommercegithub/base_adobecommerce_guide_2_copy_ft44qw.png)   
 

6. ```Dispatch -> SalesChannel -> General Settings -> Payment Method Publishable/Client Key```

    This configuration will let you share Payment Service Provider public key with Dispatch platform. 
    ![Example showing Sales Enable](https://res.cloudinary.com/dispatchxyz/image/upload/v1702309984/adobecommercegithub/base_adobecommerce_guide_2_copy_2_rbqd8f.png)   
 

 ## Payment Flow Overview

The Dispatch SDK acts like a headless PWA microsite and leverages your PSP publishable keys + Adobe Commerce API suite (guest-checkout) to place orders through your OMS. [Check out our full documentation with interactive examples](https://www.notion.so/iex-xyz/Dispatch-Integration-Guide-Adobe-Commerce-Magento-2-825048ece93f485487d4a09a56cfffae).

## Support
Create a GitHub issue on this repo describing your bug or feature and email support@dispatch.co and we will work to resolve any error you encounter.