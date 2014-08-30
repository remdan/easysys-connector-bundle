easysys-connector-bundle
========================

EasysysConnectorBundle



## Installation

### Step 1: Download the EasysysConnectorBundle

Add EasysysConnectorBundle to your composer.json using the following construct:

```{.json}
{
    "require": {
        "remdan/easysys-connector-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the following command:

``` bash
$ php composer.phar update remdan/easysys-connector-bundle
```
Composer will now fetch and install this bundle in the vendor directory ```vendor/remdan```


### Step 2: Enable the bundle

Enable the bundle in the kernel:

```{.php}
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Remdan\EasysysConnectorBundle\RemdanEasysysConnectorBundle(),
    );
}
```

### Step 3: Configure the bundle

This bundle was designed to just work out of the box. The only thing you have to configure in order to get this bundle up and running is the easysy-config.

```{.yaml}
# app/config/config.yml

remdan_easysys_connector:
    auth_adapter: ~
    http_adapter: ~
    auth:
        token:
            public_key:         ~
            signature_key:      ~
            user_id:            ~
            company:            ~
    resource_manager: ~
```