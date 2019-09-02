# Weather spy project #

A small app to demonstrate periodically fetching of data from upstream source API (OpenWeatherMap) and displaying the results in a dashboard-like area.

## How to run the app ##

1. `git clone` this repo and navigate to this folder
2. `composer install`
3. `php bin/console server:run` to launch the native PHP server
4. In another terminal launch `php bin/console weatherspy:fetch` to initiate the fetching process
5. Navigate to `http://127.0.0.1:8000/` to view the app
6. If you need to access the `/admin` area use the test admin user with credentials -> username:`test@test.com` and password:`password`

## How to use the app ##

- On the initial page (/) you can see the latest weather status of each of the favourite cities that have been defined by the admin
- An admin can use the admin section of the tool to add/remove favourite cities (that will be picked by the background process)
- If the background process is started, the app will fetch the weather data for each city every <b>10</b> minutes (no need to run the sync more often since the API updates its own data every 10 minutes)
- By visiting `Weather Data` section of the tool, a user can see all the data that was collected by the app over a predefined period of time

## A few points about the app ##
- App uses SQLite DB located in `/db/` path, only for this sample projects purposes. A full SQL solution would be suitable for production
- App comes already prefilled with some data, again for ease of display.
- In case we want to delete the DB and start fresh, then we have to perform the following series of steps in a terminal:
    1) `php bin/console doctrine:schema:create`
    2) `php bin/console doctrine:migrations:migrate`
    3) `php bin/console doctrine:fixtures:load`

    and as a last step, import the cities.sql in the newly created DB (on `/db/app.db`)
- City management was a bit difficult (and interesting) to treat. Since OpenWeatherMap is returning multiple results for the same city (but with different ID's) [ see https://openweathermap.org/find?q= ] there was a need to let the user differentiate within these results. In the end, the same approach as OpenWeatherMap is followed, where:
    1) The user types the name of the desired city
    2) Results come directly from the app's DB and the user selects the desired city to be saved in the list of favourite cities.

    An autocomplete approach could be developed to help towards a better UX.
- As a known limitation, the user cannot select cities that contain accented characters (i.e. Gorkhā, Nepal) without writing the accented character. That is a known limitation of the upstream source as well.
- UI is pretty basic (and borderline ugly) - Since I'm not a frontend/UI/UX dev, it takes me considerably more time and effort to produce a clear interface than those that are proficient in this. Time was allocated only for the backend code for this app.
- API key can be changed in the .env file. Yes, it would be good not to include it in the version control. It is included only for ease of testing and it will be revoked soon.
- Unit tests don't cover the whole app; Unfortunately the time I had on my hands was not sufficient for full extend. I tried to include different types of tests though.

## Libraries ##

The app is developed in Symfony 4 with a couple of libs/modules to ease the development

- `doctrineextensions` to use some extra SQL functions in doctrine (like DAY(), HOUR() etc)
- `doctrine-fixtures-bundle` to load the first user into DB
- `doctrine-migrations-bundle` to manage DB migrations
- A couple of `symfony/` extra modules (`form`, `maker`, `security`, `validator`) that provide helper functions in some areas of our codebase

For front-end the app relies to pretty standard libraries such as:
- `jQuery`
- `Bootstrap 4`
- `Datatables`
- `FontAwesome`
- `SB Admin 2` template