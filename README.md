# Quiz Generator API

An AI-powered backend API that generates interactive quizzes based on user input using a chat-based system.
Developed as part of a fullstack project.

---

## Overview

This project is a Laravel-based REST API that allows users to:

* Create chat sessions
* Send topics as messages
* Generate quizzes using AI
* Store and retrieve chat history

The system integrates with OpenAI to generate structured quiz data in JSON format.

---

## Tech Stack

* Backend: Laravel
* Authentication: Laravel Sanctum
* Database: MySQL
* AI Integration: OpenAI API
* Architecture: RESTful API

---

## Features

* User authentication (Register / Login)
* Chat session management
* AI-generated quizzes
* JSON-based structured responses
* Persistent chat history
* Scalable API design

---

## Frontend Application

This API is consumed by a React-based frontend application that provides a chat interface for generating and interacting with quizzes.

Frontend repository:
https://github.com/cerine0205/quiz-generator.git

---

## API Endpoints

### Authentication

* POST /api/register
* POST /api/login
* GET /api/user
* POST /api/logout

---

### Chats

* GET /api/chats
* POST /api/chats
* GET /api/chats/{id}
* DELETE /api/chats/{id}

---

### Generate Quiz

* POST /api/chats/{id}/generate

Request Body:

```json
{
  "topic": "JavaScript basics"
}
```

---

## Database Structure

### users

* id
* name
* email
* password

### chats

* id
* user_id
* title

### messages

* id
* chat_id
* sender (user / ai)
* content (JSON)

### Relationships

* A user can have many chats
* A chat can have many messages

---

## AI Response Format

The AI must return a strict JSON structure:

```json
{
  "title": "Quiz Title",
  "questions": [
    {
      "type": "mcq",
      "question": "Question text",
      "options": ["A", "B", "C", "D"],
      "correct_answer": "A"
    }
  ]
}
```

---

## Future Improvements

* Quiz scoring system
* Difficulty levels
* File-based quiz generation (PDF, text)
* Real-time streaming responses
* Analytics dashboard

---

