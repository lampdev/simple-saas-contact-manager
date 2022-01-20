# Contact Manager Trial App

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
