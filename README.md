# gPlaces API

## Introduction

This Laravel application provides a RESTful API for managing places. It allows you to perform CRUD operations on places and search for places based on certain name.

## Getting Started

### Prerequisites

Make sure you have the following installed on your system:

- PHP >= 7.4
- Composer
- Laravel

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/fernandoboueres/gPlaces.git
   git clone git@github.com:fernandoboueres/gPlaces.git
2. Clone the repository:

   ```bash
   composer install
3. Copy the .env.example file and configure your database settings:

    ```bash
   cp .env.example .env
4. Run migrations:

    ```bash
   php artisan migrate
5. For testing run the development server:

    ```bash
   php artisan serve
   ```
    It will be running on localhost under 8000 port.

    `http://localhost:8000` or `http://127.0.0.1:8000` to acess.

## API Endpoints

### List Places

- **Endpoint:** `api/places`
- **Method:** GET
- **Query Parameters:**
  - `name` (optional): Filter places by name.

### Get a Single Place

- **Endpoint:** `/places/{slug}`
- **Method:** GET
- **Parameters:**
  - `{slug}`: Place slug.

### Create a Place

- **Endpoint:** `/places`
- **Method:** POST
- **Body Parameters:**
  - `name`: Name of the place.
  - `city`: City of the place.
  - `state`: State of the place.

### Update a Place

- **Endpoint:** `/places/{slug}`
- **Method:** PUT
- **Parameters:**
  - `{slug}`: Place slug.
- **Body Parameters:**
  - `name`: Updated name of the place.
  - `city`: Updated city of the place.
  - `state`: Updated name of the place.

### Delete a Place

- **Endpoint:** `/places/{slug}`
- **Method:** DELETE
- **Parameters:**
  - `{slug}`: Place ID.

## Request and Response Examples


### List Places

```bash
curl -X GET -H "Accept: application/json" "http://localhost:8000/api/places"
```

### Create a Place

```bash
curl -X POST -H "Accept: application/json" "http://localhost:8000/api/places?name=New%20Place&city=Sao%20Luis&state=Maranhao"
```

### List Queried Places

```bash
curl -X GET -H "Accept: application/json" "http://localhost:8000/api/places?name=New"
```

### Update a Place

```bash
curl -X PUT -H "Accept: application/json" "http://localhost:8000/api/places/new-place?name=Updated%20Place"
```

### Delete a Place

```bash
curl -X DELETE -H "Accept: application/json" "http://localhost:8000/api/places/updated-place"
```