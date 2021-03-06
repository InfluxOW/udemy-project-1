# Just A Blog
[![Maintainability](https://api.codeclimate.com/v1/badges/24b04c0bac04a3341775/maintainability)](https://codeclimate.com/github/InfluxOW/udemy-project-1/maintainability)
![Main workflow](https://github.com/InfluxOW/udemy-project-1/workflows/Main%20workflow/badge.svg)

[https://udemy-project-1.herokuapp.com/](https://udemy-project-1.herokuapp.com/) \
Simple forum made by [Udemy.com](https://www.udemy.com/course/laravel-beginner-fundamentals) course.

# Development Setup
1. Run `make setup` to install dependencies, generate .env file, create SQLite database, apply migrations.
2. Run `make seed` if you want to seed the database.
3. Fill `.env` keys that are responsible for e-mail sending and AWS connection (they starts with MAIL_ and AWS_). Set `APP_DEBUG` as `true` if you want Debugbar to be enabled.
4. Run `make run` to launch web server (http://localhost:8000).
5. Run `make queue` to process the job queue.
6. Run `make lint test` to run linter and tests.
# Heroku Setup
1. Add Heroku Postgres addon.
2. Set all necessary `.env` keys.
3. Run `heroku ps:scale web=1 sqs=1 --app your-heroku-app`
