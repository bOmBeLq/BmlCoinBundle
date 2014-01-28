BmlCoinBundle
=============

What is this bundle?
--------------------
Simple cryptocurency (bitcoin, litecoin, dogecoint etc.) api for PHP.
Not all functions are implemented yet.

Entities
--------
Entities inside Entity folder should not be considered as persisted entities.
Create Your own model for storing transactions, balances etc.
These entities server solely as ease for reading wallet requests output.

Instalation
-----------

1. [..] @todo standard steps (adding to composer etc.) [..]

2. Define clients config
```php
    bml_coin:
      coins:
        dogecoin:
          rpc_user: dogecoinrpc
          rpc_password: EkGNSnVcjbMxW6iuZcmCPKt4D32LsZMQuCBfLFAhuYgv
          rpc_host: localhost
          rpc_port: 33334
        bitcoin:
          rpc_user: bitcoinrpc
          rpc_password: A3kcKYX1QsxE7PkvokD7PGY6brWZcWu8BnzKeREQ8Qma
          rpc_host: localhost
          rpc_port: 33336

```

3. Example usage @todo

Todo
----
* Better readme
* Service classes as parameters (for easier extending)
* implement all available wallet methods (getrwatransaction, listaccounts etc.)
* Test all methods (unit tests are mostly implemented, but live tests are missing)
