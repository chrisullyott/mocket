# mocket

A mock of the "Pocket" app, made with Laravel.

## Local installation (Docker)

1. Install PHP with Homebrew (to ensure proper extensions are included).
2. Install Composer globally, and make sure vendor libraries are available in the path: `export PATH="$HOME/.composer/vendor/bin:$PATH"`.
3. Install [Docker for Mac](https://docs.docker.com/docker-for-mac/).
4. Start Docker Desktop.

## Application setup

1. Create a `.env` file from `.env.example`.
2. Run `docker-compose up -d`.
3. Install with `./dev install`.

To rebuild the application from scratch, in one line:

```
./dev d && ./dev b && sleep 15 && ./dev i
```

## The *dev* utility

Run arbitrary commands in the container with:

```
./dev <COMMAND>
```

Run Laravel Artisan in the container with:

```
./dev art <COMMAND>
```

Run unit tests with:

```
./dev test
```

Log into the container with:

```
./dev sh
```

## Resources for Docker and Laravel

- [aschmelyun/docker-compose-laravel](https://github.com/aschmelyun/docker-compose-laravel)
- [Dockerfile strategies for Git](https://stackoverflow.com/questions/33682123/dockerfile-strategies-for-git)
- [Create a local Laravel dev environment with Docker](https://www.youtube.com/watch?v=5N6gTVCG_rw)
- [A much better local Laravel dev environment with Docker](https://www.youtube.com/watch?v=I980aPL-NRM)
- [Basic Laravel Site](https://medium.com/@assertchris/laravel-basic-site-d5790d77367d)

