# IT490 2020 Spring Semester Project

## About
This project is a software as a service that allows users to pull movies from IMDb using an API.

## Features
#### Users can:
- Sign up
- Login
- Logout

Basic features everyone expects. 

#### Unique features:
- Users can pull a movie from the API and give the movie a score. This information is inserted into a table for users only.
- Once a movie is pulled it will also be inserted to another table that will be accessed by the entire website, not just one user.
- Users can delete movies from their list but NOT the overall database.
- Users can review movies that are in the Movie Table
- User reviews are displayed on their profile, alongside their favorite movies (Movies they gave a score that is 9 or higher)
- Each movie that was pulled from the API gets its own page. 
  - On the page it will display: The Title, Year, Runtime, and a brief explation of the plot.
  - User Reviews will be publicly displayed too on said movie.
  
## How it works

This project uses RabbitMQ as the Producer/Consumer middle-man software between each server. We run an App (Frontend), Database (Backend), and a API (Backend) server. In between all these servers is the RabbitMQ server that runs the RabbitMQ software. 
Part-way through the semester we decided to not use MySQL and opt-in for SQLite. While it was a bit of a hassle to adapt our current code to, it made for a more enjoyable and painless experience.

SQLite Database is automatically created if not found in the /rmq/ folder (which does not get committed!). It will create all the needed tables, set the forgein keys, and such. No extra setup is needed, as it is automatic. 

#### databaseMQServer.php

This is the heart of the entire project. This PHP file runs the database portion of the project. In here users will be inserted, selected, etc. when they login or register. From here also all their information pertaining to movies is displayed. The file will output all requests with User IDs attached to know who's doing what. 
This file contains 12 functions.

#### apiMQServer.php

This is mainly used to talk to the API. It contains one function, which is used to call on the API we used. Once it gets the query, it is encoded in json and sent off to the databaseMQServer.php file. 

