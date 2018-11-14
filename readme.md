# Command Line Utility for exporting CSV with payment dates

It exports payment dates(salary date and bonus date at a fictionary company) for next 12 months to the file provided at command line

## Getting Started

These instructions will get you a copy of the project up and running on your machine

### Prerequisites

PHP 5 >= 5.3.0 / PHP 7

### Installing

1. Extract utility.zip folder or clone repository https://github.com/Mohinik11/utility.git
2. open terminal, and run following commands
3. `cd {location to utility}\utility`
4. `composer install`
5. `composer dump-autoload -o`


## Running the application

1. open terminal, and run following commands
2. `cd {location to utility}\utility`
3. `php fetchSalesPaymentDates.php filename`
4. open folder {location to utility}\utility, and open filename.csv file


## Running tests

1. open terminal, and run following commands
2. `cd {location to utility}\utility`
3. `vendor/bin/phpunit tests`

