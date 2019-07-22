
> ### Example Laravel codebase containing  CRUD, auth, advanced patterns and more
> App to facilitate management of record labels, artists and contracts, plus community features.
> - Community: All users can post stuff, like and follow others.
> - Records labels can automate digital signing of contracts.



This repo is functionality complete but business domain logic(artists, songs) needs refactoring!
Its currently used in pre-prod env

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


 Clone the repository & switch to the repo folder


 Install all the dependencies using composer

  
    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Generate a new JWT authentication secret key

    php artisan jwt:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**

Open the DummyDataSeeder and set the property values as per your requirement

    database/seeds/DummyDataSeeder.php

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh

## API Specification

To locally run the provided Postman collection against your backend, execute:

```
APIURL=http://localhost:3000/api ./run-api-tests.sh
```

For more details, see [`run-api-tests.sh`](run-api-tests.sh).

##### Considerations for your backend with [CORS](https://en.wikipedia.org/wiki/Cross-origin_resource_sharing)

If the backend is about to run on a different host/port than the frontend, make sure to handle `OPTIONS` too and return correct `Access-Control-Allow-Origin` and `Access-Control-Allow-Headers` (e.g. `Content-Type`).

##### Authentication Header:

`Authorization: Token jwt.token.here`

##### JSON Objects returned by API:

Make sure the right content type like `Content-Type: application/json; charset=utf-8` is correctly returned.

##### Users (for authentication)

```JSON
{
  "user": {
    "email": "jake@jake.jake",
    "token": "jwt.token.here",
    "username": "jake",
    "bio": "I work at statefarm",
    "image": null
  }
}
```


----------

# Code overview

## Dependencies

- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens
- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the JWT auth middleware
- `app/Http/Requests/Api` - Contains all the api form requests
- `app/Social/Favorite` - Contains the files implementing the favorite feature
- `app/Social/Filters` - Contains the query filters used for filtering api requests
- `app/Social/Follow` - Contains the files implementing the follow feature
- `app/Social/Paginate` - Contains the pagination class used to paginate the result
- `app/Social/Slug` - Contains the files implementing slugs to articles
- `app/Social/Transformers` - Contains all the data transformers
- `app/Adobe/` - Contains the implementation of digital signing(needs refactoring)
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api.php file
- `tests` - Contains all the application tests
- `tests/Feature/Api` - Contains all the api tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

## Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

    http://localhost:8000/api

Request headers

| **Required** 	| **Key**              	| **Value**            	|
|----------	|------------------	|------------------	|
| Yes      	| Content-Type     	| application/json 	|
| Yes      	| X-Requested-With 	| XMLHttpRequest   	|
| Optional 	| Authorization    	| Token {JWT}      	|

Refer the [api specification](#api-specification) for more info.

----------
 
## Authentication
 
This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token.

----------

## Cross-Origin Resource Sharing (CORS)
 
This applications has CORS enabled by default on all API endpoints. The default configuration allows requests from `http://localhost:3000` and `http://localhost:4200` to help speed up your frontend testing. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
