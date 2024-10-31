# fee_calculator
calculating fee for a loan  based on set of rules and given term 


# requirements
app launched on 
docker version 20.10.11
docker-compose 1.29.2

# running
1. run command 
```
  docker-compose up --build
```

2. finnally go to [localhost:8000](http://localhost:8000/?term=24&amount=5500) in your browser
params term and  amount can be changed 


3. running tests
- first go to docker container and type in commands
  ```
  cd /app
  ./vendor/bin/phpunit tests/CalculatorTest.php
  ```