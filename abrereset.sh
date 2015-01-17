#!/bin/bash 

app/console assetic:dump
app/console assets:install
#app/console cache:clear --env=prod
app/console cache:clear



