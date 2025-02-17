Quiz App API Documentation
Overview
This project is a quiz app with authentication and user profiles. It provides an API to register, log in, view and update profiles, and take quizzes.

API Endpoints
1. Authentication
Register
POST /register
Registers a new user.
Request body:
json
Копировать
Редактировать
{
  "name": "user_name",
  "email": "user@example.com",
  "password": "your_password"
}
Verify
POST /verifiy
Verifies the user email after registration.
Request body:
json
Копировать
Редактировать
{
  "email": "user@example.com",
  "verification_code": "code_from_email"
}
Login
POST /login
Logs in a registered user and provides an authentication token.
Request body:
json
Копировать
Редактировать
{
  "email": "user@example.com",
  "password": "your_password"
}
Logout
POST /logout
Logs out the user. Requires authentication.
Authentication: Bearer token required in the header.
2. Profile Management
View Profile
GET /profile
Retrieves the user's profile information.
Authentication: Bearer token required in the header.
Update Profile
POST /profile
Updates the user's profile information.
Request body:
json
Копировать
Редактировать
{
  "name": "new_name",
  "email": "new_email@example.com"
}
Update User Info
PUT /userupdate
Updates the user's information such as name or email.
Request body:
json
Копировать
Редактировать
{
  "name": "new_name",
  "email": "new_email@example.com"
}
Update Password
PATCH /passwordupdate
Updates the user's password.
Request body:
json
Копировать
Редактировать
{
  "current_password": "current_password",
  "new_password": "new_password"
}
3. Quiz and Questions
Get Questions
POST /questions
Retrieves a set of quiz questions for the user.
Authentication: Bearer token required in the header.
Check Answers
POST /check-answers
Checks the answers provided by the user.
Request body:
json
Копировать
Редактировать
{
  "question_id": 1,
  "answer": "user_answer"
}
Get Levels
GET /levels
Retrieves a list of available quiz levels (e.g., Beginner, Intermediate, Advanced).
Search Questions
GET /search
Searches for quiz questions by keyword.
Request parameters:
query: The search keyword.
Authentication
All endpoints except registration and login require authentication via sanctum tokens. Upon successful login, the API will return a token that should be included in the Authorization header as Bearer token_value for protected routes.

Example of an authenticated request header:

plaintext
Копировать
Редактировать
Authorization: Bearer your_token_here
Error Handling
400 Bad Request: Invalid data provided.
401 Unauthorized: Invalid or missing authentication token.
404 Not Found: Resource not found.
500 Internal Server Error: Server error.
Conclusion
This API allows users to register, log in, manage their profiles, and take quizzes. Authentication is handled using Laravel Sanctum, and all the routes that modify data or access user-specific information require a valid API token.







