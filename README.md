# 🎬 Film Streaming API (PHP Native)

<p align="center">
  <img src="https://img.shields.io/badge/PHP-Native-blue?style=for-the-badge&logo=php">
  <img src="https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge&logo=mysql">
  <img src="https://img.shields.io/badge/API-REST-green?style=for-the-badge">
  <img src="https://img.shields.io/badge/Status-Active-success?style=for-the-badge">
  <img src="https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge">
</p>

<p align="center">
  A lightweight and scalable <b>REST API</b> for a Film Streaming Mobile Application.<br>
  Built using <b>PHP Native</b> with a focus on simplicity and performance.
</p>

---

## ✨ Overview

**Film Streaming API** is a backend service designed to support a mobile streaming application.

It provides endpoints for:

* User authentication
* Movie streaming data
* Reviews and ratings
* Bookmarks and watch history
* Download tracking
* VIP access system

This project is suitable for **learning**, **API integration**, and **portfolio showcase**.

---

## 🔗 Mobile App Repository

Frontend (Mobile App):
👉 https://github.com/BangJue/Film-Streaming-Mobile-Application

---

## 🚀 Features

* 🎬 Movie API (list, detail, recommendations)
* 👤 Authentication & profile management
* ⭐ Reviews & ratings system
* 🔖 Bookmark system
* 📥 Download tracking
* 🕒 Watch history
* 💎 VIP content system

---

## 🧰 Tech Stack

| Category | Technology               |
| -------- | ------------------------ |
| Backend  | PHP Native               |
| Database | MySQL / MariaDB          |
| API Type | REST API (JSON)          |
| Server   | Apache (XAMPP / Laragon) |

---

## 📁 Project Structure

/uploads
</br>
/add_rating.php
</br>
/add_review.php
</br>
/auth.php
</br>
/bookmark_manager.php
</br>
/change_password.php
</br>
/download_manager.php
</br>
/get_home.php
</br>
/get_movies.php
</br>
/get_recommendations.php
</br>
/get_reviews.php
</br>
/get_user.php
</br>
/helpers.php
</br>
/koneksi.php
</br>
/manage_bookmark.php
</br>
/movies.php
</br>
/reviews.php
</br>
/update_photo.php
</br>
/update_profile.php
</br>
/user_action.php
</br>
/vip_purchases.php

---

## ⚙️ Installation Guide

### 1. Clone Repository

```bash
git clone https://github.com/your-username/film-streaming-api.git
```

### 2. Move to Local Server

Place the project inside:

```
htdocs (XAMPP)
/www (Laragon)
```

### 3. Setup Database

* Open phpMyAdmin
* Create database: `db_streaming`
* Import `.sql` file

### 4. Configure Database

Edit `koneksi.php`:

```php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "db_streaming";
```

### 5. Run API

```
http://localhost/film-streaming-api/
```

Example:

```
GET  /get_movies.php
POST /auth.php
```

---

## 🔐 Demo Account

Email: [demo@streaming.com](mailto:demo@streaming.com)
Password: 123456

> Note: For production, always use hashed passwords.

---

## ⚠️ Important Notes

1. Set upload folder permission:

```
chmod 777 uploads/
```

2. Update base URL in `update_photo.php`:

```php
$base_url = "http://your-ip/film-streaming-api/uploads/";
```

3. Limitations:

* No JWT authentication
* No rate limiting
* Basic validation only

---

## 📊 Database Overview

Main tables:

* users
* movies
* genres
* categories
* reviews
* bookmarks
* downloads
* watch_history
* statuses
* years

---

## 🧠 Technical Notes

This project uses simple file-based routing.

Recommended improvements:

* Use JWT Authentication
* Use prepared statements (PDO/MySQLi)
* Apply MVC architecture
* Add validation & sanitization
* Use .env configuration

---

## 📜 License

MIT License

Copyright (c) 2026 BangJue

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software...

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.

---

## ⭐ Final Notes

This project is intended for:

* Learning backend development
* Mobile app integration
* Portfolio projects

For scalability, consider upgrading to:

* Laravel (structured backend)
* Node.js (async performance)
