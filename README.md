<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://user-images.githubusercontent.com/5760249/132945127-a7d3a4bb-1ffc-4658-8096-c9cfc2f5c3dd.png" width="400"></a>
</p>

# Laravel 10 + Vite + Vue2 + Vuetify2 

## Requirement
- php 8.1 or 8.2
- node 16 or above

## ⚡️ How to install

1. `composer install`
2. `cp .env.example .env`
3. `php artisan key:generate`   
4. `npm install`
5. `npm run build`
6. `php artisan migrate`
7. `php artisan serve`


## Notes

- It runs on an SQLite database for ease of setup.
  The migration command will prompt you to create the SQLite database.



## Features

- Add a task
- Complete a task
- Delete a task
- Filter the list of tasks to either uncompleted, or all