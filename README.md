# Appointment Booking System

[![Build Status](https://travis-ci.com/lewisknewton/setp.svg?token=Nzy7DNUpFaaGScwuwTpx&branch=master)](https://travis-ci.com/lewisknewton/setp)

Project created by Team 9C for the Software Engineering Theory and Practice module (2019-2020). Please reference the linked [project board](https://github.com/users/lewisknewton/projects/1).

XAMPP was used as the local development and testing environment. Therefore, it is recommended that the project continues to be tested in the same way.

## The Team

| Username           | Name             | UP Number |
|--------------------|------------------|-----------|
| Alexander-Portland | Alexander Gordon | 896020    |
| jakelove15         | Jake Love        | 734426    |
| lewisknewton       | Lewis Newton     | 891791    |
| up876210           | Lucas Morandet   | 876210    |
| luketipler         | Luke Tipler      | 891550    |
| NabinG99           | Nabin Gurung     | 903868    |

## Set-up

### Installation 

Before installing the project, choose the installation folder. When using XAMPP to view the files in a browser, this should be in the *htdocs* folder (see below). Then, download a zip of the repository or, in the terminal, clone it using:

```
git clone https://github.com/lewisknewton/setp.git
```

Open the project folder using its name e.g. `cd setp`.

#### Dependencies

The project uses Composer and npm dependencies for automatic testing.

To install these dependencies, run `composer install` and `npm i`.

### Using XAMPP

1. Ensure the project folder is in the *htdocs/* folder (usually in *c://xampp/htdocs/*).
2. In the XAMPP Control Panel, start the *Apache* and *MySQL* modules to start their respective services.
3. Open your web browser.
4. Navigate to *localhost/{path}*, where *{path}* is to be replaced with the path to the project folder e.g. *localhost/setp*.

### Database Configuration

The system currently uses MySQL's default configurations. If you need to include your own configurations, please edit *back-end/.config.ini*. If you are using XAMPP on default settings, you should not need to edit this file.

To create the database and populate the tables, start the MySQL service and run the SQL code included in *back-end/database*:

#### Using the command-line

In the terminal, run the following commands:

```
mysql -u root -p < back-end/database/database.sql
mysql -u root -p appointment_booking_system < back-end/database/test_data.sql
```

NOTE: With local MySQL installations, the path to the MySQL binary may need to be included e.g.

```
c:/xampp/mysql/bin/mysql -u root -p < back-end/database/database.sql
c:/xampp/mysql/bin/mysql -u root -p appointment_booking_system < back-end/database/test_data.sql
```

#### Using phpMyAdmin

1. Navigate to the *SQL* tab.
2. Copy and paste the contents of *back-end/database/database.sql* into the text area.
3. Navigate to the *SQL* tab (now under the *appointment_booking_system* database).
4. Copy and paste the contents of *back-end/database/test_data.sql* into the text area.

## Testing

> **NOTE**: The project's Composer and npm dependenices must be installed prior to running the test cases, and a server with the MySQL service must be running. If using XAMPP, please start the *Apache* and *MySQL* modules.

To run the PHPUnit and Jest test cases, run the `run-test.sh` script in the project root folder. This will execute the `phpunit` and `npm test` commands.

Alternatively, you can run either `phpunit` or `npm test` yourself.
