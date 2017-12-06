# Algolia's instantsearch demo using Slim Framework 3

This demo application is using Algolia's instantsearch with the PHP framework Slim.
It uses some Apple applications sample data to display a list that can be filtered by the searchbar and faceted by categories.
In the backend, you can add a new application or delete one by specifying its ObjectID.

## Install the Application
1. ```composer update ```
2. ```composer start ```
3. go to ```localhost:8080``` for FRONT or ```localhost:8080/admin/login``` for BACKOFFICE

## Test online
Go to https://algoliasearch-slim.herokuapp.com/

## Technologies
* PHP - Slim Framework 3 (https://www.slimframework.com/)
* Algolia's instantsearch (https://community.algolia.com/instantsearch.js/)
* Twig template engine (https://twig.symfony.com/)
* SASS (http://sass-lang.com/)
* Gulp to preprocess SASS files (https://gulpjs.com/)
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

## Use of REST API
You can use two API functions :

* Add an application

```POST /api/1/apps``` 

With a JSON object like this one :

```json
{
  "name": "Damcou book",
  "image": "http://www.hostingpics.net/thumbs/49/53/04/mini_495304applelogoblue175px.jpg",
  "link": "http://itunes.apple.com/us/app/ibooks/id364709193?mt=8",
  "category": "Books",
  "rank": 3
}
```

You will receive the newly created application ObjectID in response.

* Delete an application


```DELETE /api/1/apps/:id```

Where :id is the ObjectID of the application

## Launch test with PHPUnit

```composer test ```

* Example of functional tests on the two API endpoints
* Example of unit tests on the 3 Helpers

## Structure
* ```src/app ``` - Application (PHP classes)
* ```src/public ``` - Assets + index.php
* ```src/slim ``` - Some Slim Framework files
* ```src/templates ``` - Twig templates
* ```src/tests ``` - PHPUnit tests
* ```composer.json ```
* ```phpunit.xml ```

```
path/to/app
|-- node_modules   - javascript modules (gulp)
|-- src
|   |-- app        - Application (PHP classes)
|   |-- public     - Assets + index.php
|   |-- slim       - Some Slim Framework files
|   |-- templates  - Twig templates
|   `-- tests      - PHPUnit tests
|-- vendor         - PHP modules (composer)
|-- composer.json
|-- gulpfile.js
|-- package.json
|-- phpunit.xml
`-- README.md 

```

## Contact
If you have any question, fell free to send me an email to damien.couchez[@]gmail[.]com