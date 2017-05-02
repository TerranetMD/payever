# Installation
==============

### Clone the repository
`git clone git@github.com:TerranetMD/payever.git ./payever`

### Enter into app folder
`cd payever`

### Install composer dependencies
`composer install`

### Create database schema
`php app/console doctrine:schema:create`

### Load fixtures
`php app/console doctrine:fixtures:load`

### Run tests
`cd app; phpunit; cd ../`

### Run web server
`php app/console server:run`

### Enjoy!
