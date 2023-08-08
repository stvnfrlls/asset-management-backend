# AMS - Laravel REST API for Asset Management System

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Error Handling](#error-handling)

## Introduction

The Laravel REST API for Asset Management is a web application that provides a backend service for managing assets. It is built on the Laravel framework, which is known for its expressive syntax and robust features. This API allows users to perform CRUD operations (Create, Read, Update, Delete) on assets and manage asset-related information efficiently.

## Features

- Create, Read, Update, and Delete assets.
- Search assets based on various criteria.
- Assign assets to users or locations.
- Track asset status and history.
- Secure API endpoints using authentication.
- Error handling with informative error messages.

## Requirements

Before setting up the Laravel REST API, ensure you have the following prerequisites:

- PHP 7.4 or higher
- Composer
- MySQL
- Web server (Apache)
- Laravel's server requirements (see [Laravel documentation](https://laravel.com/docs/installation#server-requirements))

## Installation

Follow these steps to set up the project:

1. Clone the repository: `git clone https://gitlab.com/qpax-interns/asset-management-backend.git`
2. Navigate to the project directory: `cd your-repo`
3. Install PHP dependencies: `composer install`
4. Copy the `.env.example` file and rename it to `.env`. Update the database credentials and other configuration settings in the `.env` file.
5. Run the database migrations: `php artisan migrate`
6. Seed the database with sample data: `php artisan db:seed`
7. Run Laravel Passport command: `php artisan passport:install`
8. Start the development server: `php artisan serve`

## Configuration

Explain important configuration options and environment variables here, if any.

## Usage

Provide instructions on how to use the API, including sample API requests and responses.

## API Endpoints

**Unauthenticated Endpoints:**

- **POST /login**: User login (match for both GET and POST requests).
- **GET /getAssetType**: Get all asset types.
- **GET /getCategories**: Get all categories.
- **GET /getClassifications**: Get all classifications.
- **GET /getManufacturers**: Get all manufacturers.
- **GET /getDepartments**: Get all departments.
- **GET /getStatusType**: Get all status types.
- **GET /getUserRoles**: Get all user roles.
- **GET /getDisposalMethod**: Get all disposal methods.
- **GET /getSoftwareCategory**: Get all software categories.
- **GET /getLicensesStatus**: Get all license statuses.
- **GET /verifyUpload**: Verify upload status.

**Authenticated Endpoints:**

- **GET /verifyUpload**: Verify upload status.
- **GET /dashboardData**: Get dashboard data.
- **GET /assets**: Get all assets.
- **GET /assets/{id}**: Get a specific asset by ID.
- **POST /addAsset**: Add a new asset.
- **POST /updateAsset/{id}**: Update an existing asset by ID.
- **GET /purchases**: Get all purchases.
- **GET /purchases/{id}**: Get a specific purchase by ID.
- **POST /addPurchases**: Add a new purchase.
- **POST /updatePurchases/{id}**: Update an existing purchase by ID.
- **GET /location**: Get all locations.
- **GET /location/{id}**: Get a specific location by ID.
- **POST /addLocation**: Add a new location.
- **POST /updateLocation/{id}**: Update an existing location by ID.
- **GET /devspec**: Get all device specifications.
- **GET /devspec/{id}**: Get a specific device specification by ID.
- **POST /addDevspec**: Add a new device specification.
- **POST /updateDevspec/{id}**: Update an existing device specification by ID.
- **GET /components**: Get all components.
- **GET /components/{id}**: Get a specific component by ID.
- **POST /addComponents**: Add a new component.
- **POST /updateComponents/{id}**: Update an existing component by ID.
- **GET /licenses**: Get all licenses.
- **GET /licenses/{id}**: Get a specific license by ID.
- **POST /addLicenses**: Add a new license.
- **POST /deleteLicense/{id}**: Delete a license by ID.
- **POST /updateLicenses/{id}**: Update an existing license by ID.
- **GET /availableOS**: Get available operating systems.
- **GET /logs**: Get all transfer logs.
- **GET /logs/{id}**: Get a specific transfer log by ID.
- **POST /transfer**: Transfer an asset to a new location.
- **GET /auditlogs**: Get all audit logs.
- **POST /auditlogs**: Add a new audit log.
- **GET /disposed**: Get all disposed assets.
- **GET /disposed/{id}**: Get a specific disposed asset by ID.
- **POST /dispose**: Dispose of an asset.
- **GET /getAll**: Search for assets using various parameters.
- **GET /getAllDetails**: Search for assets with detailed information.
- **GET /getDevice**: Search for devices.
- **GET /getData**: Get inventory data.
- **GET /getDeviceAssetNo**: Get device asset numbers.
- **GET /getAssetNo**: Get asset numbers.
- **GET /getAssetList**: Get a list of assets.
- **GET /availableOffice**: Get available offices.
- **GET /getAssetsWithDeviceSpecs**: Get assets with device specifications.
- **POST /upload**: Upload a file.
- **GET /user**: Get the authenticated user's details.
- **GET /getUserList**: Get a list of users.
- **GET /logout**: Log out the authenticated user.
- **POST /register**: Register a new user account.
- **POST /updatePassword/{id}**: Update a user's password by ID.
- **POST /delete/{id}**: Delete a user account by ID.
- **POST /AssetType**: Add a new asset type.
- **POST /AssetType/{id}**: Update an existing asset type by ID.
- **POST /DeleteAssetType/{id}**: Delete an asset type by ID.
- **POST /Category**: Add a new category.
- **POST /Category/{id}**: Update an existing category by ID.
- **POST /DeleteCategory/{id}**: Delete a category by ID.
- **POST /Classification**: Add a new classification.
- **POST /Classification/{id}**: Update an existing classification by ID.
- **POST /DeleteClassification/{id}**: Delete a classification by ID.
- **POST /Department**: Add a new department.
- **POST /Department/{id}**: Update an existing department by ID.
- **POST /DeleteDepartment/{id}**: Delete a department by ID.
- **POST /DisposalMethod**: Add a new disposal method.
- **POST /DisposalMethod/{id}**: Update an existing disposal method by ID.
- **POST /DeleteDisposalMethod/{id}**: Delete a disposal method by ID.
- **POST /LicenseStatus**: Add a new license status.
- **POST /LicenseStatus/{id}**: Update an existing license status by ID.
- **POST /DeleteLicenseStatus/{id}**: Delete a license status by ID.
- **POST /Manufacturer**: Add a new manufacturer.
- **POST /Manufacturer/{id}**: Update an existing manufacturer by ID.
- **POST /DeleteManufacturer/{id}**: Delete a manufacturer by ID.
- **POST /SoftwareCategory**: Add a new software category.
- **POST /SoftwareCategory/{id}**: Update an existing software category by ID.
- **POST /DeleteSoftwareCategory/{id}**: Delete a software category by ID.
- **POST /StatusType**: Add a new status type.
- **POST /StatusType/{id}**: Update an existing status type by ID.
- **POST /DeleteStatusType/{id}**: Delete a status type by ID.
- **POST /UserRole**: Add a new user role.
- **POST /UserRole/{id}**: Update an existing user role by ID.
- **POST /DeleteUserRole/{id}**: Delete a user role by ID.

## Authentication

Laravel Passport, the OAuth2 server for Laravel, generates an access token upon successful user login. This token is sent to the frontend and stored in an HTTP-only cookie for secure storage. Subsequent requests to the backend API automatically include the token from the cookie, providing seamless authorization. Passport verifies the token's authenticity on the backend, allowing access to protected resources. Tokens have an expiration time for enhanced security, requiring users to log in again to get a new token once it expires.

## Error Handling

Detail how errors are handled in the API and provide examples of error responses.
