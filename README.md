
To aquire our objective, we need this features on the application:

- User can register.
- User can see transaction history by date of their own.
- User add transactions for income and spending.
- User can categorize the transaction.
- User can see transaction summary on each month or a year.
- `-` sign on numbers indicates **spending/outcome** transaction.

Those are basic concept of the personal bookkeeping service.

## Getting Started
This application can be installed on local server and online server with these specifications :

#### Server Requirements
1. PHP 7.2 (and meet [Laravel 6.x server requirements](https://laravel.com/docs/6.x#server-requirements)),
2. MySQL or MariaDB database,
3. SQlite (for automated testing).

#### Installation Steps

1. Clone the repo : `git clone https://github.com/nadyaapril14/ManajemenDanaUASRPL.git`
2. `$ cd dompet`
3. `$ composer install`
4. `$ cp .env.example .env`
5. `$ php artisan key:generate`
6. Create new MySQL database for this application  
(with simple command: `$ mysqladmin -urootuser -p create dompet_db`)
7. Set database credentials on `.env` file
8. `$ php artisan migrate`
9. `$ php artisan serve`
10. Register new account.


## License

Dompet project is a free and open-sourced software under [MIT License](LICENSE).
