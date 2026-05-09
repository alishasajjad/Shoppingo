# 🛒 SHOPPINGO - Online Shopping System

A complete Database-Driven E-Commerce Web Application developed using PHP, MySQL, HTML, CSS, and JavaScript. This project demonstrates real-world implementation of relational database concepts, ER modeling, normalization, and secure CRUD operations.

---

## 📌 Project Overview

SHOPPINGO is a web-based online shopping system that allows users to register, login, browse products, add items to cart, place orders, and track order status.

It also includes an Admin Panel for managing products, users, orders, and order tracking.

This project is developed as part of the Database Systems course to demonstrate practical implementation of RDBMS concepts.

---

## 🗄️ Database Architecture

- DBMS: MySQL  
- Version: 5.0+  
- Charset: UTF-8  
- Collation: utf8_general_ci  

### Tables:
- users → customer information  
- items → product catalog  
- users_items → cart & orders  
- order_tracking → order status updates  
- admin → admin data  

---

## 🔗 Database Relationships

- One User → Many Orders  
- One Item → Many Orders  
- Orders → Tracking History  

Foreign keys ensure data integrity between tables.

---

## ⚙️ Core Features

### 👤 User Side
- Registration & Login  
- Product Browsing  
- Shopping Cart  
- Order Placement  
- Order Tracking  
- Profile Management  

### 🛠️ Admin Side
- Admin Login  
- Product Management (Add/Edit/Delete)  
- User Management  
- Order Management  
- Order Tracking Updates  

---

## 🔐 Security Features

- Password hashing (MD5 / password_hash)  
- Session-based authentication  
- Input validation  
- Foreign key constraints  
- ENUM-based order status  

---

## 💻 Implementation

### Database Connection
$con = mysqli_connect("localhost", "root", "", "shop");

## Example Queries

SELECT * FROM users WHERE email = ? AND password = ?;
INSERT INTO items (name, price, stock) VALUES (?, ?, ?);
INSERT INTO users_items (user_id, item_id, status) VALUES (?, ?, 'Added to cart');

## ⚙️ Installation Guide

1. Create Database
CREATE DATABASE shop;
2. Import SQL File
mysql -u root -p shop < database/shop.sql
4. Configure Connection
$con = mysqli_connect("localhost", "root", "", "shop");
6. Run Project

## Start XAMPP:
Apache ON
MySQL ON

## Open:
http://localhost/online-shopping/index.php

## 🚀 Future Enhancements
Payment Gateway Integration
Wishlist Feature
Product Reviews & Ratings
Email/SMS Notifications
Admin Analytics Dashboard
Mobile Application
AI-based Recommendations

## 🛠️ Technologies Used
PHP
MySQL
HTML5
CSS3
JavaScript
XAMPP

## 🎯 Objective

To build a secure, scalable, and database-driven e-commerce system demonstrating real-world use of RDBMS concepts, web development, and backend integration.

- Click here to watch the complete project demonstration video: https://youtu.be/zsMRHkqFOt8

## 📜 License

Academic Project Only.

If you find this project useful, please consider starring the repository and supporting its development.
