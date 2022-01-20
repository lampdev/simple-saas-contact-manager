# Contact Manager Trial App

## Make the App up and running

1. Navigate to the project folder and create the `.env` file

```
cp .env.example .env
```

2. Install the application's dependencies by the following script:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

3. To make the app running we have to start Docker by means of the `vendor/bin/sail` script:

```
./vendor/bin/sail up -d
```

You can configure a Bash alias:

```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

And execute Sail commands by simply typing `sail`:

```
sail up -d
```

4. Generate the application key:

```
sail php artisan key:generate
```

5. Run migrations

```
sail php artisan migrate
```

If you are experiencing database connection issues, please try to use the following .env variables:

```
DB_HOST=mysql

DB_DATABASE=mysql
```

Now you may access the project in your web browser at: http://localhost

To stop all of the containers use `sail stop` command.

To stop and remove containers, networks, images, and volumes use `sail down` command.


## UI

All the added UI functinality you can find in the `resources/js/Pages/Dashboard.vue` file.

## Backend

All the added routes are in the `routes/web.php` file:

```
Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => ['auth', 'web']
], function () {
    Route::resource('/contacts', 'ContactController');
    Route::get('/download-contacts-csv', 'ContactController@userContactsToCsv');
    Route::get('/count-click', 'CountClick');
    
});
```

## Klaviyo

The app uses `klaviyo/php-sdk`.

Please add `Klavio` api keys to the .env `KLAVIYO_PUBLIC_KEY` and `KLAVIYO_SECRET_KEY` keys accordingly.
