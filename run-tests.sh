#!/bin/bash

printf "*** Running PHPUnit test cases ***\n\n"
vendor/bin/phpunit

printf "\n*** Running Jest and Selenium Web Driver test cases ***\n"
npm test
