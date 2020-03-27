# Appointment Booking System

[![Build Status](https://travis-ci.com/lewisknewton/setp.svg?token=Nzy7DNUpFaaGScwuwTpx&branch=master)](https://travis-ci.com/lewisknewton/setp)

Project created by Team 9C for the Software Engineering Theory and Practice module (2019-2020). Please reference the linked [project board](https://github.com/users/lewisknewton/projects/1).

[XAMPP](https://www.apachefriends.org/index.html) was used as the local development and testing environment, with [http://localhost/uni/setp](http://localhost/uni/setp) as the URL. Therefore, it is recommended that the project continues to be tested in the same way.

## Branches

All branches have been retained to aid review. Namely, these are:

* `prototype-one`, which included:
  * a very basic UI
  * partially-automated testing
  * comment-only documentation
  * key features for the steps involved in requests and bookings
* `prototype-two` \*, which included:
  * a more user-friendly UI
  * fully-automated testing
  * automatic documentation generation
  * additional, non-critical features such as all cancellations, preferences, and more robust validation

\* Currently merged with `master`. 

## The Team

| Username           | Name             | UP Number |
|--------------------|------------------|-----------|
| Alexander-Portland | Alexander Gordon | 896020    |
| jakelove15         | Jake Love        | 734426    |
| lewisknewton       | Lewis Newton     | 891791    |
| up876210           | Lucas Morandet   | 876210    |
| luketipler         | Luke Tipler      | 891550    |
| NabinG99           | Nabin Gurung     | 903868    |

## SCM

General notes on the source control management plan followed by the team are available in [scm-plan.md](scm-plan.md).

## Set-up

### Installation 

Before installing the project, choose the installation folder. When using XAMPP to view the files in a browser, this should be in the *htdocs* folder (see below). Then, download a zip of the repository or, in the terminal, clone it using:

```
git clone https://github.com/lewisknewton/setp.git
```

Open the project folder using its name e.g. `cd setp`.

#### Dependencies

The project uses [Composer](https://getcomposer.org/) and [npm](https://www.npmjs.com/) dependencies for automatic testing and documentation generation, which can be installed by running the `composer install` and `npm i` commands in the root folder.

### Using XAMPP

1. Ensure the project folder is in the *htdocs/* folder (usually in *c://xampp/htdocs/*).
2. In the XAMPP Control Panel, start the *Apache* and *MySQL* modules to start their respective services.
3. Open your web browser.
4. Navigate to *localhost/{path}*, where *{path}* is to be replaced with the path to the project folder e.g. *localhost/uni/setp*.

### Database Configuration

The system currently uses MySQL's default configurations. If you need to include your own configurations, please edit [back-end/.config.ini](back-end/.config.ini). If you are using XAMPP on default settings, you should not need to edit this file.

To create the database and populate the tables, start the MySQL service and run the SQL code included in [back-end/database](back-end/database):

#### Using the command-line

In the terminal, run the following commands:

```
mysql -u root -p < back-end/database/database.sql
mysql -u root -p appointment_booking_system < back-end/database/test_data.sql
```

> **NOTE**: With local MySQL installations, the path to the MySQL binary may need to be included e.g. `c:/xampp/mysql/bin/mysql`.

You will be asked to enter your password. If you are using the default `root` user account, this password should be empty and you should be able to simply press the enter key.

Alternatively, run the [setup-db.sh](setup-db.sh) script in the project root folder, which uses the same default path for the binary (*c:/xampp/mysql/bin/mysql*). This uses a blank password by default, which can be changed by entering your own in the quotation marks of the `--password=""` option.

#### Using phpMyAdmin

1. Navigate to the *SQL* tab.
2. Copy and paste the contents of [back-end/database/database.sql](back-end/database/database.sql) into the text area.
3. Navigate to the *SQL* tab (now under the *appointment_booking_system* database).
4. Copy and paste the contents of [back-end/database/test_data.sql](back-end/database/test_data.sql) into the text area.

## Testing

Automated testing is available using [PHPUnit](https://phpunit.de/) for the [back-end](back-end) scripts and [Jest](https://jestjs.io/) and [Selenium WebDriver](https://www.selenium.dev/) for interactivity. To run these test cases, run the [run-test.sh](run-tests.sh) script in the project root folder. This will execute the `vendor/bin/phpunit --configuration phpunit.xml --stderr` and `npm test` commands.

Alternatively, you can run either `vendor/bin/phpunit --configuration phpunit.xml --stderr` or `npm test` yourself. To run the Selenium WebDriver tests without opening browser windows and rendering pages (i.e. in `headless` mode), run `npm run test-headless` instead of `npm test`.

It is recommended that the database is re-created before testing.

> **NOTE**: The project's Composer and npm dependenices must be installed prior to running the test cases, and a server with the MySQL service must be running. If using XAMPP, please start the *Apache* and *MySQL* modules.

> **NOTE**: Due to the use of headers in the [back-end](back-end), all PHPUnit tests must be run with the `--stderr` option. The `--configuration phpunit.xml` option, however, may be omitted.

### Test Accounts

Several accounts have been defined in [back-end/database/test_data.sql](back-end/database/test_data.sql) for testing. Their email addresses are as follows:

* Administrative staff:
  * as1@test.com
  * as2@test.com
* Medical staff:
  * ms1@test.com
  * ms2@test.com
* Patients:
  * pa1@test.com
  * pa2@test.com
* Patients (unverified):
  * pa3@test.com
  * pa4@test.com

The password for all test accounts is *test123*.

### Default URL

The default URL at which to access the system is [http://localhost/uni/setp](http://localhost/uni/setp). If your server does not serve files at this URL, [http://localhost](http://localhost) is assumed instead.

## Documentation

Single and multi-line comments are provided throughout the project. Many are docblocks, from which documentation has been automatically generated using [phpDocumentor](https://www.phpdoc.org/) for the [back-end](back-end) and [JSDoc](https://jsdoc.app/) for the [front-end](front-end).

Generated documentation for both directories may be found in [docs](docs). Alternatively, you can generate the documentation yourself by running the [generate-docs.sh](generate-docs.sh) script in the project root folder or by running the following commands:

```
node_modules/.bin/jsdoc front-end/js -r -d docs/front-end
vendor/bin/phpdoc -d ./back-end -t ./docs/back-end --sourcecode
```

> **NOTE**: The project's Composer and npm dependenices must be installed prior to running the automatic documentation generation commands.

> **NOTE**: When running phpDocumentor, the [GraphViz](https://www.graphviz.org/) package needs to be installed and added to your PATH.
