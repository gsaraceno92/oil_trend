# Oil Trend

Php application to get oil trend data using JSON-RPC format.

Step to follow:

- [Installation](#installation)
- [Setup docker project](#setup)
- [Test](#running-tests)
- [Site](#site)

---

## Installation

- Clone the project as follow:

  `git clone git@github.com:gsaraceno92/oil_trend.git`

- Copy [**_.env.example_**](src/.env.example) into **_.env_**

---

## Setup

These are the instructions to follow to set up the project on your local environment.

1.  Build the Docker image

        docker-compose up --build -d

2.  Use `docker image ls` and `docker container ls` (or `docker ps`) to see your images and the running containers

3.  Enter into the container with

        docker exec -it php_oil_trend bash

### **Starting and stopping containers**

Once created, the containers can be **started** anytime with the following command:

    docker-compose up -d

To **stop** the containers, use instead:

    docker-compose stop

---

## **Running tests**

Run the files inside [tests](src/Tests) directory as follow:

    docker exec -it php_oil_trend vendor/bin/phpunit Tests/

---

## Site

The app will run through http://localhost:8005.

Use the method **_GetOilPriceTrend_** to retrieve oil trend data filtering dates using format ISO8601, e.g.:

```
"params": {
    "startDateISO8601": "2020-01-01",
    "endDateISO8601": "2020-01-10"
}
```
