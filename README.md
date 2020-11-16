# Pyntax - Data Framework.

This library automates the process of defining Manager's and Repositories. The idea originated
from the problem of rewriting the same code again and again while creating new projects.

# Installation
```shell script
composer required "pyntaxinc/data-framework"
```

# Concepts
Let's say we are building a CRM, we have the following entities to create:

1. User
2. Contact
3. Notes (Calls or Meetings)

In the above scenario both Contact and Notes are owned by a User. (This is the logic we will abstract)

## Manager
Manager or Service class basically has all the business logic for the given entity or domain. 
The manager takes a Repository as a paramter which takes care of the CRUD. 

## Repository
This is an abstract layer that takes care of the CRUD (Create, Read, Update and Delete) actions. The reason
why this is an abstract layer because we can either have an ORM linked to this Repository or a caching 
engine like Redis.  


 ## ToDo: Adding more.