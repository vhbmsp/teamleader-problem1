# TeamLeader - Problem 1

This is the API solution to calculate promotional discounts.


## Usage
Starting the webserver from the project root:

```bash
cd public/
# Start webserver
php -S 127.0.0.1:7000
```

Orders Json requests should be sent with POST method to:

```
http://127.0.0.1:7000/api/promo
```

The **data/** folder has the original json data files for the project. We can send an order directly with those files from the project root with:

```
curl -H "Content-Type: application/json" --data "@data/order1.json" http://127.0.0.1:7000/api/promo
```

The expected response should be like this:
```json
{
"discount": {
    "discount": 4.99,
    "reason": "Premium Customer 10% discount"
  }
}
```

## Runing the Tests

From the project root, run:

```
bin/phpunit
```

## Author
Vasco Pinheiro