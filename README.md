# Symplex Small Business to Prestashop integration

[![Build Status](https://travis-ci.org/athlan/symplex-prestashop.svg?branch=master)](https://travis-ci.org/athlan/symplex-prestashop)

Tool provides integration of [Symplex Small Busines](http://symplex.com.pl) to [Prestashop](https://www.prestashop.com) integration:

* Synchronize producs prices and quantites by EAN code
* Report products that coudn't be synced due to missing in Symplex

Note: This is open source product and have no commercial support. Contributions are welcome.

## Development environment

Development environment is setup by Docker and docker-compose.

In order to run it:

```
cd docker/dev

# First time only
docker-compose build

# Login to dev env
docker-compose run php bash

# Install deps
composer install
```
