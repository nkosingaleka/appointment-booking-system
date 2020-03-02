#!/bin/bash

printf "*** Running PHPUnit test cases ***\n\n"
cd back-end
vendor/bin/phpunit

printf "\n*** Running Jest test cases ***\n"
cd ../front-end
npm test
