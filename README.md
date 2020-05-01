# Pizzas-api
API for create and order pizzas based on Symfony and API Platform.
## Install instructions
1. First make sure you have [Symfony Requirements](https://symfony.com/doc/4.2/setup.html "Symfony Requirements") and a running MySQL server.
2. Download or clone this repository.
3. (Optional) modify `DATABASE_URL` in the .env file to set your correct MySQL configuration.

## Usage instructions
1. Create the database and tables by running: 
`php bin/console doctrine:migrations:migrate`
2. Open a terminal and run: `symfony server:start`. This will start a local server on http://127.0.0.1:8000

That is it! You can go to http://localhost:8000/api to see the docs and test the API or directly use it.

**Note:** This works better with header `accept: application/ld+json` but also supports usual `accept: application/json`.

## Some notes
### How to add toppings to each pizza or pizzas to each order?
Using `accept: application/ld+json`, when making any request (except for DELETE) you will see in the response an `@id` key that represents that resource.
The value of this key is the one you can use in the POST and PUT request to add items to orders or pizzas.

Example of POST body for Pizzas:
```json
{
  "name": "Vegan",
  "price": 150,
  "toppings": [
    "/api/toppings/5",
    "/api/toppings/6",
    "/api/toppings/7",
    "/api/toppings/10",
    "/api/toppings/11"
  ],
  "description": "Healthy"
}
```
