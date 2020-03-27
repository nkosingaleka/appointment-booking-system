#!/bin/bash

node_modules/.bin/jsdoc front-end/js -r -d docs/front-end
vendor/bin/phpdoc -d ./back-end -t ./docs/back-end --sourcecode
