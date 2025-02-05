# Sample PHP web application
Sample PHP web application using the Kangaroo Rewards API

# Application structure

```
/public
    /index.php        <-- Main UI and routing logic
/app
    /auth.php            <-- Authentication logic (password grant)
    /api.php             <-- API request helper and API endpoint functions
    /config.php          <-- Configuration (client ID, secret, etc.)
```

# How to Use

## Setup
Clone the repository. Rename the app/config.php.example to config.php and update it with your credentials.

## Starting the web server

```
$ cd ~/public
$ php -S localhost:8000
```

## Extend

This sample covers most endpoints from the documentation. You can add additional cases to index.php and more API helper functions in api.php as needed.

