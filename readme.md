# Simple file upload/delete/download API for Zalora

I am using Lumen PHP framework for this test to write an API using this micro-framework

## Installation
* `composer install`
* `cp .env.sqlite .env`
* `chmod 777 /tmp/zalora/storage /tmp/zalora/storage/logs /tmp/zalora/storage/app /tmp/zalora/storage/framework /tmp/zalora/storage/framework/cache`
* `mkdir -p /tmp/zalora/storage/app /tmp/zalora/storage/framework/cache /tmp/zalora/storage/framework/views /tmp/zalora/storage/logs /tmp/zalora/database`
* `touch /tmp/zalora/database/database.sqlite`
* `touch database/database.sqlite`

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

##### Note!
The API will check if the file exists (using checksums) and if it exists it will reject the file.

Thank you for reviewing!
