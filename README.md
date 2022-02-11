# php_challenge_lugingf
## Launch
Composer has a new version and there were dependencies conflict, so I had to downgrade composer by
```
composer self-update --1
```

After following command were workable:

```
composer install
php bin/console server:start 127.0.0.1:8001
```

## Tests
I provide few test examples just to demonstrate approach

## Api
### To retrieve Position info by id
```
http://localhost:8001/position/{id}
http://localhost:8001/position/13
```
#### Success response
```json
{
	"id": 13,
	"title": "Middle PHP Developer",
	"seniority_level": "Middle",
	"country": "PT",
	"city": "Lisbon",
	"salary": 425500,
	"currency": "SVU",
	"skillSet": [
		"PHP",
		"Falcon",
		"Unit-testing",
		"SOLID",
		"SQL",
		"MongoDB"
	],
	"companySize": "10-50",
	"companyDomain": "Communication"
}
```
#### Failed response
`status code 404`
```json
{
	"Error": "Position with ID 40 not found"
}
```

### To find Positions by location (city or country)
```
http://localhost:8001/positions/filter?country=NL
http://localhost:8001/positions/filter?city=Berlin
http://localhost:8001/positions/filter?city=Berlin&country=NL
```
#### Sorting usage
```
http://localhost:8001/positions/filter?country=NL&sort=salary
http://localhost:8001/positions/filter?country=NL&sort=seniorityLevel
```
#### Success response
```json
{
  "Positions": [
    {
      "id": 1,
      "title": "Senior PHP Developer",
      "seniority_level": "Senior",
      "country": "DE",
      "city": "Berlin",
      "salary": 747500,
      "currency": "SVU",
      "skillSet": [
        "PHP",
        "Symfony",
        "REST",
        "Unit-testing",
        "Behat",
        "SOLID",
        "Docker",
        "AWS"
      ],
      "companySize": "100-500",
      "companyDomain": "Automotive"
    },
    {
      "id": 2,
      "title": "Middle PHP Developer",
      "seniority_level": "Middle",
      "country": "DE",
      "city": "Berlin",
      "salary": 632500,
      "currency": "SVU",
      "skillSet": [
        "PHP",
        "Symfony",
        "Unit-testing",
        "SOLID"
      ],
      "companySize": "100-500",
      "companyDomain": "Automotive"
    },
    ...
    ...
  ]
}
```

### Most interesting position could be found like this
```
http://localhost:8001/position_match?skills=GoLang&salary=70000&currency=SVU
http://localhost:8001/position_match?skills=PHP
http://localhost:8001/position_match?skills=OOP,Microservices
```
