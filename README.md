# Symfony 4 Tutorial: The Spacebar (Symfonycasts)

## Description

This is me coding along the [Symfony 4 tutorial from Symfonycasts][1].

## Requirements

- [Docker][2]
- [Docker-Compose][3]

## Getting started

1. Clone this repository: `$ git clone git@github.com:thled/the_spacebar.git`
1. Change to project directory: `$ cd the_spacebar`
1. (optional) Change ports, DB configurations etc. in `.env` if you want to.
1. Build and start the docker containers: `$ docker-compose up`
1. Install dependencies: `$ docker-compose exec php composer install`
1. Create DB: `$ docker-compose exec php bin/console doctrine:database:create`
1. Create DB schema: `$ docker-compose exec php bin/console doctrine:migrations:migrate`
1. Load fixtures: `$ docker-compose exec php bin/console doctrine:fixtures:load`

## Usage

- Open `localhost:80` in your browser. If you modified `.env` change the port accordingly.
- You can manage the DB with Adminer on `localhost:8080`.

[1]: https://symfonycasts.com/tracks/symfony
[2]: https://docs.docker.com/install/linux/docker-ce/ubuntu/
[3]: https://docs.docker.com/compose/install/

