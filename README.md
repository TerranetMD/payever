# Installation
==============

### Clone the repository
`git clone git@github.com:TerranetMD/payever.git ./payever`

### Enter into app folder
`cd payever`

### Install composer dependencies
`composer install`

### Load fixtures
`php app/console doctrine:fixtures:load`

### Run tests
`cd app && phpunit`

### Run web server
`php app/console server:run`