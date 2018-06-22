#!/bin/bash

# looks for ./vendor/bin/phpunit first
#  and falls back to ~/.composer/vendor/bin/phpunit

# Installation:
# run the following in your shell or add to your .bashrc
# source phpunit-alias.sh

phpunit () {
    if [ -e ./vendor/bin/phpunit ]
    then
        echo "./vendor/bin/phpunit $@"
        ./vendor/bin/phpunit $@
    else
        echo "~/.composer/vendor/bin/phpunit $@"
        ~/.composer/vendor/bin/phpunit $@
    fi
}

phpunitf () {
    if [ -e ./vendor/bin/phpunit ]
    then
        echo "./vendor/bin/phpunit --filter $@"
        ./vendor/bin/phpunit --filter $@
    else
        echo "~/.composer/vendor/bin/phpunit --filter $@"
        /Users/dweller/.composer/vendor/bin/phpunit --filter $@
    fi
}

phpunitx () {
    if [ -e ./vendor/bin/phpunit ]
    then
        echo "./vendor/bin/phpunit --stop-on-failure $@"
        ./vendor/bin/phpunit --stop-on-failure $@
    else
        echo "~/.composer/vendor/bin/phpunit --stop-on-failure $@"
        /Users/dweller/.composer/vendor/bin/phpunit --stop-on-failure $@
    fi
}
