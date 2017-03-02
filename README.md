#  Demo of Symfony DI container and setup

## Setup

- clone repo
- composer install


## Configure

In `config/config.yml` update the `api_manager_name` parameter. It can be one of:

- supplier_1
- supplier_2


## Run 

php demp.php <command>


*Possible commands:*

- php demo.php simulate:contacts:get
- php demo.php simulate:contacts:update
- php demo.php simulate:payments:get
- php demo.php simulate:payments:update


Setting of `api_manager_name` will determine which mapping config is used. 
