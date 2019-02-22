# Scranton Herald Website

This is a website that I created for a web development module at university. The back-end has been designed using the Model-View-Controller architecture. The front-end has been designed using the Bootstrap framework with elements of JavaScript used for form validation and ajax for refreshing content. 

Use of jQuery Mobile has been demonstrated here as a graph that displays live data from an Internet of Things device (Electric Imp). 

The website also demonstrates use of a Rest API (OpenWeatherMap) and RSS feeds (both internal and external, and using XSLT). 

## Demo

You can view a live version of this website here: https://mickmelon.com/scrantonherald

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them

```
Web server environment
```

### Installing

Upload the files to your web host or local development environment.

Edit the app/Config.php file to match your database connection details.

```
const DB_SERVER = 'your server';
const DB_NAME = 'database name';
const DB_USER = 'your database username';
const DB_PASS = 'your database password';
```

## Authors

* **Michael McMillan** - [MickMelon](https://github.com/mickmelon)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
