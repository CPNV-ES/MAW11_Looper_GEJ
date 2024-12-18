# MAW11_Looper_GEJ 
## Description

This is a project for the MAW11 course. We're supposed to rewrite [this website](https://maw-looper.mycpnv.ch)

## Getting Started
### Prerequisites

* Docker 4.33.0
* PHP 8.3.11
* Xdebug v3.3.2
* Postgres 16.4
* Pgadmin 8.11.0
* Composer 2.7.8

### Configuration
Before starting the docker environment, you need to follow the following steps:
You need to setup the `.env` file.
Copy the `.env.example` file and change the environment variables content.

## Deployment

You need to install composer requirements :
`composer install`

Now you can start the docker stack.

If you want xdebug and phpmyadmin, use the dev environment. If you dont need them, use the production environment.


### On dev environment
#### Docker 

```bash
docker-compose up
```

#### PHP -S

```bash
php -S localhost:8000 -t public
```

### On prod environment

```bash
docker-compose -f docker-compose-prod.yml up 
```

The application will be available at [127.0.0.1:8080](http://127.0.0.1:8080)


## Directory structure

```shell
.
├── docs
├── public
│   ├── assets
│   └── index.php
├── readme.md
├── src
│   ├── controllers
│   ├── models
│   └── views
└── tests
```

## Collaborate

* What you need to know:
  * How to propose a new feature (issue, pull request)
  * [How to commit](https://www.conventionalcommits.org/en/v1.0.0/)
  * [How to use your workflow](https://nvie.com/posts/a-successful-git-branching-model/)
  * [PSR12](https://www.php-fig.org/psr/psr-12/)
  * we use [IceCrum](https://icescrum.cpnv.ch/p/MAW11GEJ/#/project) for project management

## License

* [WTFPL](https://en.wikipedia.org/wiki/WTFPL).

## Contact

* [Ethann Schneider](mailto:pf70xyr@eduvaud.ch)
* [Guillaume Aubert](mailto:pt16wqr@eduvaud.ch)
* [Jomana Kaempf](mailto:pp37ufi@eduvaud.ch)

## Reccomandantion 

* Git 2.46.0
* Git-Flow-AVH 1.12.3
