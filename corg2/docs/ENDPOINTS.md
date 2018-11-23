# Endpoints

## HTML

Method|Endpoint|Usage
---|---|---
GET|/activities(/{activity_id})|
GET|/auth|
GET|/customers(/{customer_id})|
GET|/dashboard|
GET|/files(/{file_id})|

## JSON

The default and hidden query string in GET requests is `for=standard`. There is also the value `fetch` for some GET methods (which must be stated explicitly).

In order to get/download an uploaded file, use the query string `alt=media`.

### Activities

Method|Endpoint|Usage
---|---|---
DELETE|/activities/{activity_id}|Remove an Activity
DELETE|/activities|Remove all Activities
DELETE|/customers/{customer_id}/activities|Remove all Customer's Activities
DELETE|/files/{file_id}/activities|Remove all File's Activities
GET|/activities/{activity_id}|Get an Activity
GET|/activities|Get all Activities
GET|/customers/{customer_id}/activities|Get all Customer's Activities
GET|/files/{file_id}/activities|Get all File's Activities
POST|/activities|Create an Activity

### Associations

Method|Endpoint|Usage
---|---|---
DELETE|/associations|Remove all Associations
DELETE|/customers/{customer_id_1}/associations/{customer_id_2}|Remove a Customer's Association
DELETE|/customers/{customer_id}/associations|Remove all Customer's Associations
GET|/associations|Get all Associations
GET|/customers/{customer_id}/associations|Get all Customer's Associations
POST|/customers/{customer_id_1}/associations/{customer_id_2}|Create a Customer's Association

### Customers

Method|Endpoint|Usage
---|---|---
DELETE|/files/{file_id}/customers|Remove all File's Customers
DELETE|/customers|Remove all Customers
DELETE|/customers/{customer_id}|Remove a Customer
GET|/files/{file_id}/customers|Get all File's Customers
GET|/customers|Get all Customers
GET|/customers/{customer_id}|Get a Customer
POST|/customers|Create a Customer
PUT|/customers/{customer_id}|Update a Customer

### Files

Method|Endpoint|Usage
---|---|---
DELETE|/activities/{activity_id}/files|Remove all Activity's Files
DELETE|/customers/{customer_id}/files|Remove all Customer's Files
DELETE|/files{file_id}|Remove a File
DELETE|/files|Remove all Files
GET|/activities/{activity_id}/files|Get all Activity's Files
GET|/customers/{customer_id}/files|Get all Customer's Files
GET|/files{file_id}|Get a File
GET|/files|Get all Files
POST|/files|Create a File
POST|/files|Upload a File

### Login

Method|Endpoint|Usage
---|---|---
DELETE|/auth|Log out a User
POST|/auth|Log in a User
PUT|/auth|Register a User

### References

Method|Endpoint|Usage
---|---|---
DELETE|/activities/{activity_id}/references/{file_id}|Remove a Activity's File Reference
DELETE|/activities/{activity_id}/references|Remove all Activity's File References
DELETE|/files/{file_id}/references/{activity_id}|Remove a File's Activity Reference
DELETE|/files/{file_id}/references|Remove all File's Activity References
DELETE|/references|Remove all References
GET|/references|Get all References
POST|/activities/{activity_id}/references/{file_id}|Create a Activity's File Reference
POST|/files/{file_id}/references/{activity_id}|Create a File's Activity Reference

## Vcard

Method|Endpoint|Usage
---|---|---
GET|/customers/{customer_id}|Get a Customer
