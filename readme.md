# Simple file upload/delete/download API for Zalora

I am using Lumen PHP framework for this test to write an API using this micro-framework

## Installation
* `composer install`
* `cp .env.example .env`
* `touch database/database.sqlite`

### Edit .env file like below
```
APP_ENV=local
APP_DEBUG=true
APP_KEY=changeMeToArandomSecret
APP_TIMEZONE=UTC

DB_CONNECTION=sqlite

CACHE_DRIVER=memcached
QUEUE_DRIVER=sync

```
### Run database migrations
* Run `php artisan migrate` at the project root folder.

### Now the FUN begins!
* Run the API from localhost with `php -S localhost:8000 -t public` in this project's root folder

#### Uploading a file
* `curl -X POST  -F "data=@/Users/me/Downloads/yourfile.png" http://localhost:8000/upload`

#### Deleting a file
* `curl -X DELETE http://localhost:8000/upload\?filename\=yourfile.png`

#### Downloading a file
1. Open your browser
2. Go to `http://localhost:8000/upload?filename=yourfile.png` 
