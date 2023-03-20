# Simple Real-Estate API

## Installation

-  Clone repository into desired folder
-  In terminal run : composer install
-  Create database named 'real-estate' [if different rename database name in .env file]
-  In terminal run : php artisan migrate
-  In terminal run : php artisan db:seed --class="DatabaseSeeder"
-  In terminal run : php artisan serve

## Project Overview

This project  allows customers to manage an inventory of a real estate agency. An API consumer is able to create real-estate entries (houses or apartments) and search them. Each entry is defined by the following properties:
- its type (house or apartment)
- address
- size (in m2)
-  number of bedrooms
- price
- geographical location ( latitude, longitude )

###  Authentication
There's no authentication enabled.

### Endpoints

* **POST['/units/store'] - Stores new units**

    - ##### JSON & Validation rules
    - 
```json
      	{
      		"id_type" : 1,
      		"address": "",
      		"size" : 25,
      		"bedrooms" : 2,
      		"price" : "125000",
      		"latitude" : 90,
      		"longitude" : 160
      	}

```

- id_type : // 1 (apartment) / 2 (house)
- address : // Required, String
- size (in m2) : // Required, Integer
- bedrooms : // Required, Integer
- price : // Required, Decimal
-  latitude : // Required, Decimal between -90 and 90
- longitude : // Required, Decimal between -180 and 180


* **GET [ '/units' ] - Getting all units, includes searching them**

  Searching for entries can be done by any search string (address in this case) , size, number of bedrooms, price point and radius distance .Contains query strings and their values, as well as key-values within the request body.

  Query strings are :
    - Address ->  search=
    - Size -> min_size=  | max_size=
    - Bedrooms -> min_bedrooms=  |  max_bedrooms=
    - Price -> min_price= | max_size=
    - Radius distance -> distance=latitude,longitude,radius

  Example:

  /units?search=Lisandro&min_size=10&max_size=50&min_bedrooms=1&max_bedrooms=5&min_price=10000&max_price=5000000&min_bedrooms=1&distance=50,130,1000


## Coding Overview

### Database structure
UnitTypes : id, type ( aparment/house)
Units : id_type, address, size, bedrooms, price, latitude, longitude.

* Added an **fulltext index** on address for better performanse search, as so the **composite index** for size, bedrooms, latitude and longitude.*

* Added an *Database seeder* which seeds Units table used for testing.*

### Bussiness logic

A few things I would single out:
1. #### _Filterable Trait_

Using the *Filterable Trait* for applying search filters.

The idea was to presents a clean, composable, easy-to-understand approach to filtering collections in Laravel.

This trait has a *scopeFilter()* method with a QueryFilters injected with dependency injection.

QueryFilters class has an *filters()* method which returns an associative array contain input values in the url and body of the request.

Also has *apply()* method loops through the associative array returned by filters() and if the inheriting class has a method with the name of the request key, it executes that method, passing it a parameter with the request value if exists.

UnitFilters class is a child class of QueryFilters which is used for storing all methods for filtering units. Each method returns an Eloquent Builder $builder instance.

Later on, in controller:

    public function index(UnitFilters $filters){  
	    $units = Unit::select('id','address','size','bedrooms','price')->filter($filters)->simplePaginate(); 
    }

2. #### UnitsRequest

UnitRequest  is made to get the validation rules that apply to the request.
Its contains rules() for applying validation rules,
failedValidation() throwing an exception with messages() .

- #### Query Performances
As I am aware of how important it is to provide good performance when working and retriving a large amount of data, I would highlight some things that I have applied -

- indexes  ( in order to get faster results when searching through that particular column )
-  pagination ( for limiting query results per page, because certainly the user is not presented with a million+ records at once)

Things that I haven't used and I think have a lot of impact on performance, and which could be applied in further development:

- Laravel's DB facade query builder ( Much faster than Eloquent ORM )

Code written using Eloquent is more readable and thus more maintainable than code written using the DB facade ,can use methods, scopes, accessors, modifiers etc. inside of a model, which is a maintainable pattern but has the perfomance issues working with large amount of data.


- Using chunk

When proccessing large data , instead of retrieving all at once, we can retrieve a subset of results and process them in groups

- Using  caching

To reduce this overhead when retriving a milions+ records , we could perform the query and then store its results in the cache and next time we need to run this query, we can grab the results from the cache rather than executing the database query again.
  
