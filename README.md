<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Managing Subscriptions and Publications System
![IMAGE](laravel_10_x_back_end_postmen.png)


### About project 

- ***This project is a subscription and publication management system that provides users with the ability to subscribe to various subscription plans, create publications, and view active publications.***

### 1.Subscription Plans

The system administrator has the ability to dynamically define and manage subscription plans. Each plan has its attributes, such as name, cost, number of available publications, and an activation switch. Information about subscription plans is stored in a database table.

### 2.Subscription Management

Each user can have only one active subscription plan at a time. After a user subscribes to a plan, their record in the database is updated to reflect the chosen plan. Once payment is confirmed, the activation switch of the plan is set toactive".

### 3.Publication Creation

Users are provided with the ability to create publications. The details of the publications are stored in a database table. Additionally, the publications table has a status field that indicates whether the publication is a draft or active.

### 4.Displaying Publications

To display all active publications, a feed similar to a blog is created. Furthermore, filters are implemented to search for publications by title, author, identifier, and publication date. Using these filters, relevant publications can be retrieved from the database.

### 5.API Documentation

- *The project's API is documented using Postman for testing and documenting the API. This allows us to make requests to the API and verify their responses. All available endpoints, parameters, and API responses are described using Postman.*

## Requirements

-   PHP = ^8.2
-   Laravel Framework = ^10.*
-   MySql = ^8.0

## Installation:

```sh
composer i
# Optional
npm i

```

- .env:

```ini
# copy .env.example -> .env 
# Replace by yours
APP_URL=[HOST_URL]
DB_DATABASE=[DATABASE_URL]

```
- generate key:

```sh
php artisan key:generate --force
```

- migrate with demo datas:

```sh
php artisan migrate:fresh --seed
```

- in postman_collection.v3.json:

```json
// Replace by yours
// [HOST_URL]

	"variable": [
		{
			"key": "BASE_URL",
			"value": "[HOST_URL]",
			"type": "string"
		},
		{
			"key": "TOKEN",
			"value": ""
		}
	]

```
- **import postman_collection.v4.json from your` Postman**

This project provides an efficient way to manage subscriptions and publications, offering a user-friendly interface for both users and the system administrator. With this system, users can easily subscribe to plans, create publications, and view active publications.