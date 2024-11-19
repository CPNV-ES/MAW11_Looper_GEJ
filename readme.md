# MAW11_Looper_GEJ 
## Description

This is a project for the MAW11 course. We're supposed to remake [this website](https://maw-looper.mycpnv.ch)

## Getting Started
### Prerequisites

* Docker 4.33.0
* PHP 8.3.11
* Xdebug v3.3.2
* Postgres 16.4
* Pgadmin 8.11.0
* Composer 2.7.8

### Configuration

Make `.env` file 
and put the 
```env
POSTGRES_USER=admin
POSTGRES_PASSWORD=mysecretpassword
PGADMIN_DEFAULT_EMAIL=admin@example.com
PGADMIN_DEFAULT_PASSWORD=admin
```
or copy `.env.example`

## Deployment
### On dev environment
#### Docker 

```bash
docker-compose up
```

#### PHP -S

```bash
php -S localhost:8000 -t public
```

### On integration environment

```bash
docker-compose -f docker-compose-prod.yml up
```

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
  * we use [IceScrum](https://icescrum.cpnv.ch/p/MAW11GEJ/#/project) for project management

## License

* [WTFPL](https://en.wikipedia.org/wiki/WTFPL).

## Contact

* [Ethann Schneider](mailto:pf70xyr@eduvaud.ch)
* [Guillaume Aubert](mailto:pt16wqr@eduvaud.ch)
* [Jomana Kaempf](mailto:pp37ufi@eduvaud.ch)

## Reccomandantion 

* Git 2.46.0
* Git-Flow-AVH 1.12.3
