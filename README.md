

-- Features  of App 
-- Authentication (Login, Register, Logout)
-- User Profile (Update, Delete)
-- Post (Create, Update, Delete, Like, Comment)

+ Database Schema Design
 - User
    id bigint primary key autoincrement,
    name varchar(50), not null,
    email varchar(50), not null unique,
    password varchar(50), not null,
    profile_pic varchar(50) not null,
    bio text nullable,
-  Post
    id bigint primary key autoincrement,
    user_id bigint foreign key references User(id),
    caption text not null,
    image varchar nullable,
- Like 
    id bigint primary key autoincrement,
    user_id bigint foreign key references User(id),
    post_id bigint foreign key references Post(id),
- Comment   
    id bigint primary key autoincrement,
    user_id bigint foreign key references User(id),
    post_id bigint foreign key references Post(id),
    text text not null

1. Create Migration 
2. Create Model
3. Create Factory to generate fake data for testing
4. Install Passport (package) for Authentication 
5. Create Controller to handle User Authentication
6. Create Post Controller to handle Post CRUD operations
7. Create Like Controller to handle Like operations
8. Create Comment Controller to handle Comment operations

+ API Endpoints
- User
    - Register
    - Login
    - Logout
    - Profile
- Post
    - Get
    - Create
    - Update
    - Delete
    - Like
    - Comment
# Laravel-project-api
