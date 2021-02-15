# PIRATES

![](https://static.tvtropes.org/pmwiki/pub/images/potc_monocle2.jpg)

Launch your server and find the Treasure.

## Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;

## Installation

1. Clone the current repository.

```bash
$ git clone https://github.com/froldev/symfony-pirats.git
```

2. Move into the directory and create an `.env.local` file.
   **This one is not committed to the shared repository.**
   Set `db_name` to **pirats**.

3. Execute the following commands in your working folder to install the project:

```bash
$ composer install
$ bin/console d:d:c (create the DataBase)
$ bin/console d:m:m (execute migrations and create tables)
$ bin/console d:f:l (execute fixtures to display the map)
```

> Reminder: Don't use composer update to avoid problem

> Assets are directly into _public/_ directory, **we will not use** Webpack with this checkpoint

## Usage

Launch the server with the command below and run yarn watch to compile the folder with pictures and styles sass;

```bash
$ symfony server:start
$ yarn watch
```
