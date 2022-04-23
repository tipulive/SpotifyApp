# Weather-Forecast

# SpotifyApp Preview 
![Preview](https://user-images.githubusercontent.com/80526946/164886008-a0e03514-be79-4139-aced-c57873d9d86b.gif)


## Prerequisites

You will need the following things properly installed on your computer.

* [Git](https://git-scm.com/) or any Terminal(command)
* [Php and laravel](https://laravel.com/docs/8.x/http-tests) 
* [Xamp server](https://www.apachefriends.org/index.html/) then make sure Mysql and Apache service are running
* [Google Chrome](https://google.com/chrome/) or any others browsers

## API and Credentials

* [Visit Spotify to Setup Credentials](https://developer.spotify.com/dashboard/) login or create Account there

* Create APP there and add your redirect url
* Copy SPOTIFY_CLIENT_ID,SPOTIFY_CLIENT,SPOTIFY_REDIRECT_URI and fill in your .env.example file
* if you are using Development mode make sure you will add Users and Access 

## Installation('Windows')

* Open Your Terminal or Git Console
* Type `git clone https://github.com/tipulive/SpotifyApp.git` 
* Type `cd SpotifyApp`
* `under SpotifyApp Folder open .env.example fill`
- SPOTIFY_CLIENT_ID
- SPOTIFY_CLIENT
- SPOTIFY_REDIRECT_URI
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

* `change .env.example file to .env`
* Type `php artisan migrate` in your Terminal to migrate your Database




## Running / Development

* Type `php artisan serve` Terminal under Project folder to run This Project.
* [open Your Browser and visite](http://localhost:8000/auth/login)  this is to Authenticate or signup then call back will save callback payload data(user profile info ) to database
- ## Run Some Application End Point
- [\users`](http://localhost:8000/users) :to view all saved users from database
- [\userStore_listening`](http://localhost:8000/userStore_listening) :to get recently-played from Spotify and Store in Database from 

- [\user_listening`](http://localhost:8000/user_listening) :to view all saved recently-played from database

- [\logout`](http://localhost:8000/logout) :to logout 

### Running Tests 

* `php artisan test` on your Terminal
### Note

* i have decided to use only routes/web.php instead of API because it is a small project and it is web project too

* this is only Feature Testing
