Projet tutoré *(PFE)*
===


##Installation

###Requirements
1. Clone the project
```bash
git clone https://github.com/JulienFauvel/pfe.git
```

2. Install [PHP 7](https://secure.php.net/)
3. Install [npm](https://nodejs.org/en/)
4. Install Bower globally
```bash
npm install -g bower
```
5. Install the front-end dependencies with bower

*In the project's directory*
```bash
bower update
```
6. Install [Composer](https://getcomposer.org/)
7. Get all dependencies

*In the project's directory*

```bash
php path/to/composer.phar install
```

##Database

We are using PostgreSQL as the DBMS.

Do not forget to uncomment :
```
extension=php_pdo_pgsql.dll (on Windows)
```

Set up the file app/config/parameters.yml
```yml
parameters:
    database_driver:   pdo_pgsql
    database_host:     127.0.0.1
    database_port:     5432
    database_name:     pfe
    database_user:     postgres
    database_password: password

    mailer_transport:  smtp
    mailer_host:       127.0.0.1
    mailer_user:       ~
    mailer_password:   ~

    # A secret key that's used to generate certain security-related tokens
    secret:            ThisTokenIsNotSoSecretChangeIt

```

Create the database :
```bash
php bin/console doctrine:database:create
```

Create the database tables :
```bash
php bin/console doctrine:schema:update --force
```

##Launch the app
```bash
php bin/console server:run
```