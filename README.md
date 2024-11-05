# Crafted Goods - E-commerce Platform

**Crafted Goods** is a dynamic e-commerce platform built with PHP, HTML, CSS, and MySQL. This project allows sellers to create accounts, add products, and manage their stores. Customers can browse various products, add them to their cart, and complete purchases. The platform also includes user authentication, product ratings, comments, and a personalized dashboard for each seller.

## Table of Contents

- [Crafted Goods - E-commerce Platform](#crafted-goods---e-commerce-platform)
  - [Table of Contents](#table-of-contents)
  - [Features](#features)
  - [Tech Stack](#tech-stack)
  - [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Project Structure](#project-structure)
    - [Database Schema](#database-schema)
    - [Usage](#usage)
    - [Seller Workflow](#seller-workflow)
    - [Future Improvements](#future-improvements)
    - [License](#license)

## Features

- **User Authentication**: Customers and sellers can create accounts, log in, and log out.
- **Product Management**: Sellers can add, edit, and delete products associated with their store.
- **Customer Shopping Experience**: Customers can browse products, add items to their cart, and complete checkout.
- **Product Comments and Ratings**: Customers can leave comments and rate products.
- **Seller Dashboard**: Personalized dashboard for sellers with product management capabilities.
- **Responsive Design**: Optimized layout for various screen sizes.

## Tech Stack

- **Front-End**: HTML, CSS, JavaScript
- **Back-End**: PHP, MySQL
- **Database Management**: XAMPP (or any MySQL server)
- **Version Control**: Git

## Getting Started

### Prerequisites

- **XAMPP** (or a local server with PHP and MySQL support)
- **Git** for version control
- **PHP** (version 7.4 or above recommended)
- **MySQL**

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/crafted-goods.git

2. **Set up the database:**:
- Open phpMyAdmin (or your MySQL client).
- Create a new database named crafted_goods.
- Import the database schema from database/schema.sql.

3. **Configure Database Connection:**:
- Open db_connect.php and configure the database credentials:
php

$servername = "localhost";
$username = "your_database_username";
$password = "your_database_password";
$dbname = "crafted_goods";

4. **Start the Server**:
- Open XAMPP and start Apache and MySQL.
- Access the project at http://localhost/crafted_goods.

### Project Structure

crafted_goods/
├── css/                     # Stylesheets
├── images/                  # Image assets for products and stores
├── includes/                # Navbar, footer, and shared components
├── js/                      # JavaScript files (if any)
├── database/                # SQL files for database structure
├── add-product.php          # Product addition handled on dashboard
├── cart.php                 # Shopping cart page
├── checkout.php             # Checkout page
├── db_connect.php           # Database connection file
├── index.php                # Home page
├── login.php                # Customer login page
├── register.php             # Customer registration page
├── seller-dashboard.php     # Seller dashboard with product management
├── seller-login.php         # Seller login page
├── delete-product.php       # Product deletion functionality
├── README.md                # Project documentation


### Database Schema

Below is a high-level overview of the database tables:

- **users**: Stores customer information.
- **stores**: Stores seller/store information.
- **products**: Stores product information linked to each seller.
- **cart**: Tracks items added to customers' carts.
- **comments**: Stores comments and ratings on products.

### Usage

- Customer Workflow
1. Register and log in as a customer.
2. Browse available products.
3. Add products to the cart.
4. Proceed to checkout and complete the purchase.
   
### Seller Workflow

- Customer Workflow
1. Register and log in as a seller.
2. Access the seller dashboard.
3. Add, edit, and delete products associated with your store.


### Future Improvements

- Admin Panel: Add an admin panel for better site management.
- Enhanced Product Search: Implement search filters for price range, categories, and rating.
- Order Management: Allow customers and sellers to track orders.
- Payment Integration: Integrate with a payment gateway for real transactions.
- Responsive UI Enhancements: Further improve responsive design for a seamless mobile experience.

### License

This project is licensed under the MIT License.
