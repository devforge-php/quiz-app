# Quiz App API Documentation

## Overview

This project is a quiz app with authentication and user profiles. The API allows users to register, log in, manage profiles, take quizzes, and provides administrative functionalities.

---

## 1. Authentication API

### Register
- **POST** `/api/register`
  - Registers a new user.
  - **Request Body:**
    ```json
    {
      "name": "user_name",
      "email": "user@example.com",
      "password": "your_password",
      "password_confirmation": "your_password"
    }
    ```

### Email Verification
- **POST** `/api/verifiy`
  - Verifies the user's email after registration.
  - **Request Body:**
    ```json
    {
      "code": "verification_code"
    }
    ```

### Login
- **POST** `/api/login`
  - Logs in a registered user.
  - **Request Body:**
    ```json
    {
      "email": "user@example.com",
      "password": "your_password"
    }
    ```

### Logout
- **POST** `/api/logout`
  - Logs out the user.

---

## 2. Admin API

### Manage Categories
- **CRUD:** `/api/category`
  - Create, update, delete categories (e.g., PHP, JavaScript, Go).

### Manage Questions
- **CRUD:** `/api/question`
  - Create questions linked to a category and difficulty level.

### Manage Answers
- **CRUD:** `/api/answer`
  - Create answers linked to a question.
  - **is_correct** field determines if the answer is correct (1 or 0).

### Manage Users
- **CRUD:** `/api/users`
  - Admin can manage registered users.

### Notifications
- **GET** `/api/notifactions`
  - Admin receives notifications when a new user registers.

---

## 3. User API

### Get Questions
- **POST** `/api/questions`
  - **Parameters:**
    ```json
    {
      "category": "PHP",
      "level": "Beginner",
      "limit": 10
    }
    ```

### Check Answers
- **POST** `/api/check-answers`
  - **Request Body:**
    ```json
    {
      "question_id": 1,
      "answer": "user_answer"
    }
    ```

### View Rankings
- **GET** `/api/levels`
  - Retrieves user rankings based on scores.

### Search Users
- **GET** `/api/search?query={search_term}`
  - Search users by username.

---

## 4. Profile Management

### View Profile
- **GET** `/api/profile`
  - Retrieves user profile information.

### Update Profile
- **POST** `/api/profile`
  - **Request Body:**
    ```json
    {
      "name": "new_name",
      "last_name": "new_last_name",
      "image": "profile_image_url"
    }
    ```

### Update User Information
- **PUT** `/api/userupdate`
  - **Request Body:**
    ```json
    {
      "name": "new_name",
      "email": "new_email@example.com"
    }
    ```

### Update Password
- **PATCH** `/api/passwordupdate`
  - **Request Body:**
    ```json
    {
      "old_password": "current_password",
      "new_password": "new_password"
    }
    ```

---

## 5. Authentication

All endpoints except registration and login require authentication via `sanctum` tokens. Upon successful login, the API will return a token that should be included in the `Authorization` header as `Bearer token_value` for protected routes.

**Example of an authenticated request header:**
```plaintext
Authorization: Bearer your_token_here
```

