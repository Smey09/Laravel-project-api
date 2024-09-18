# Laravel Project API

A RESTful API built with Laravel to manage user authentication, profiles, posts, likes, and comments. This project demonstrates common features like CRUD operations, user authentication, and relational database design.

## Features

-   **Authentication**:
    -   Register, Login, Logout
-   **User Profile**:
    -   Update, Delete
-   **Posts**:
    -   Create, Update, Delete
    -   Like/Unlike a post
    -   Comment on posts

## Database Schema Design

### User Table

```sql
id          BIGINT PRIMARY KEY AUTO_INCREMENT,
name        VARCHAR(50) NOT NULL,
email       VARCHAR(50) NOT NULL UNIQUE,
password    VARCHAR(50) NOT NULL,
profile_pic VARCHAR(50) NOT NULL,
bio         TEXT NULLABLE
```

### Post Table

```sql
id          BIGINT PRIMARY KEY AUTO_INCREMENT,
user_id     BIGINT FOREIGN KEY REFERENCES User(id),
caption     TEXT NOT NULL,
image       VARCHAR NULLABLE
```

### Like Table

```sql
id          BIGINT PRIMARY KEY AUTO_INCREMENT,
user_id     BIGINT FOREIGN KEY REFERENCES User(id),
post_id     BIGINT FOREIGN KEY REFERENCES Post(id)
```

### Comment Table

```sql
id          BIGINT PRIMARY KEY AUTO_INCREMENT,
user_id     BIGINT FOREIGN KEY REFERENCES User(id),
post_id     BIGINT FOREIGN KEY REFERENCES Post(id),
text        TEXT NOT NULL
```

## Project Setup

### Step 1: Create Migrations

Generate the necessary migrations for the `User`, `Post`, `Like`, and `Comment` tables:

```bash
php artisan make:migration create_users_table
php artisan make:migration create_posts_table
php artisan make:migration create_likes_table
php artisan make:migration create_comments_table
```

### Step 2: Create Models

Define models for the application:

```bash
php artisan make:model User
php artisan make:model Post
php artisan make:model Like
php artisan make:model Comment
```

### Step 3: Create Factories

Generate factories for testing with fake data:

```bash
php artisan make:factory UserFactory
php artisan make:factory PostFactory
php artisan make:factory LikeFactory
php artisan make:factory CommentFactory
```

### Step 4: Install Passport for Authentication

Install Laravel Passport for handling API authentication:

```bash
composer require laravel/passport
php artisan passport:install
```

### Step 5: Create Controllers

-   **User Authentication**:

    ```bash
    php artisan make:controller AuthController
    ```

-   **Post CRUD**:

    ```bash
    php artisan make:controller PostController
    ```

-   **Like Operations**:

    ```bash
    php artisan make:controller LikeController
    ```

-   **Comment Operations**:
    ```bash
    php artisan make:controller CommentController
    ```

## API Endpoints

### User

-   **Register**: `POST /api/register`
-   **Login**: `POST /api/login`
-   **Logout**: `POST /api/logout`
-   **Profile**:
    -   **View Profile**: `GET /api/user`
    -   **Update Profile**: `PUT /api/user`
    -   **Delete Profile**: `DELETE /api/user`

### Post

-   **Get All Posts**: `GET /api/posts`
-   **Create Post**: `POST /api/posts`
-   **Update Post**: `PUT /api/posts/{id}`
-   **Delete Post**: `DELETE /api/posts/{id}`
-   **Like Post**: `POST /api/posts/{id}/like`
-   **Comment on Post**: `POST /api/posts/{id}/comment`

### Like

-   **Like a Post**: `POST /api/posts/{post_id}/like`
-   **Unlike a Post**: `DELETE /api/posts/{post_id}/like`

### Comment

-   **Add Comment**: `POST /api/posts/{post_id}/comment`
-   **Delete Comment**: `DELETE /api/posts/{post_id}/comment/{comment_id}`

## Getting Started

1. Clone the repository:

    ```bash
    git clone https://github.com/Smey09/Laravel-project-api.git
    cd laravel-project-api
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Set up your `.env` file and configure the database connection:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT
    ```

4. Run migrations:

    ```bash
    php artisan migrate
    ```

5. Serve the application:
    ```bash
    php artisan serve
    ```

## License

This project is open-source and licensed under the [MIT License](LICENSE).
