# Algolia's instantsearch demo using Slim Framework 3

This demo application is using Algolia's instantsearch with the PHP framework Slim.
It uses some Apple applications sample data to display a list that can be filtered by the searchbar and faceted by categories.
In the backend, you can add a new application or delete one by specifying its ObjectID.

## Install the Application
1. ```composer update ```
2. ```composer start ```
3. go to ```localhost:8080``` for FRONTEND or ```localhost:8080/admin/login``` for BACKEND

## Technologies
* PHP - Slim Framework 3 (https://www.slimframework.com/)
* Algolia's instantsearch (https://community.algolia.com/instantsearch.js/)
* Twig template engine (https://twig.symfony.com/)
* PHPUnit (https://phpunit.de/)

## This project uses 2 indices
* appstore (sort by rank DESC) : master
* appstore_rank_asc (sort by rank ASC) : replica of appstore

## Application data structure
* name
* image
* link
* category
* rank

## Structure
* ```src/app ``` - Application (PHP classes)
* ```src/public ``` - Assets + index.php
* ```src/slim ``` - Some Slim Framework files
* ```src/templates ``` - Twig templates
* ```src/tests ``` - PHPUnit tests
* ```composer.json ```
* ```composer.lock ```
* ```phpunit.xml ```

## Contact
If you have any question, fell free to send me an email to damien.couchez@gmail.com