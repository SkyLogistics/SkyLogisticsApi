# Docker / PHP 7.4 console / composer / phpunit 

Sky logistics docker project for console php 7.4 projects with composer and phpunit.

## Prerequisites

Install Docker and optionally Make utility.

Commands from Makefile could be executed manually in case Make utility is not installed.

## Build container.

    Make build
    
## Run docker containers

    Make up
    
## Check docker containers

    Make check

## Copy dist configs

If dist files are not copied to actual destination, then
    
    Make copy-dist-configs
    
## Install the composer dependencies

    Make vendors-install
    
## Run unit tests

Runs container and executes unit tests.

    Make unit-tests
    
## Run functional tests

Runs container and executes unit tests.

    Make functional-tests

## Static analysis

Static analysis check

    Make static-analysis
    
## Run cs-fixer
    
    Make cs-fix
	    
## Results

Create parcel

     docker exec -it php74-cli php examples/createParcel.php

Get Parcel Info (history, statuses, info)

     docker exec -it php74-cli php examples/getParcelInfo.php

Get statuses

     docker exec -it php74-cli php examples/getStatuses.php

Get warehouses

     docker exec -it php74-cli php examples/getWarehouses.php