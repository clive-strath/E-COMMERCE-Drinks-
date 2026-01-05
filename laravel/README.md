# Drinks E-commerce Platform

A Laravel-based e-commerce platform for selling drinks online with customer shopping cart, checkout, and admin management features.

## Features

### Customer Features
- Browse products by category
- Search products
- Add items to cart
- Update/remove cart items
- Checkout with cash on delivery
- View order history
- User authentication (register/login)

### Admin Features
- Manage categories (CRUD)
- Manage products (CRUD)
- View and manage orders
- Update order status
- Inventory management
- Admin dashboard

## Tech Stack
- Laravel 12.44.0
- PHP 8.3
- MySQL/MariaDB
- Blade templating
- Tailwind CSS (via Breeze)

## Installation

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=E-COMMERCE
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass
   ```

5. Run migrations and seed:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. Create storage link:
   ```bash
   php artisan storage:link
   ```

7. Build assets:
   ```bash
   npm run build
   ```

8. Start development server:
   ```bash
   php artisan serve
   ```

## Default Users

### Admin User
- Email: admin@example.com
- Password: password

### Customer User
- Email: customer@example.com
- Password: password

## Database Schema

### Categories
- id, name, slug, timestamps

### Products
- id, name, slug, description, price, size, stock, image, status, category_id, timestamps

### Carts & Cart Items
- Carts: id, user_id, timestamps
- Cart Items: id, cart_id, product_id, quantity, price, timestamps

### Orders & Order Items
- Orders: id, order_number, user_id, customer details, delivery info, total_amount, status, payment_status, payment_method, timestamps
- Order Items: id, order_id, product_id, quantity, price, size, timestamps

### Payments
- id, order_id, amount, method, status, transaction_id, gateway_response, timestamps

## Routes

### Public Routes
- `/` - Home page with featured products
- `/products` - Product catalog with filtering
- `/products/{product}` - Product detail page

### Authenticated Routes
- `/cart` - Shopping cart
- `/checkout` - Checkout process
- `/orders` - Order history
- `/orders/{order}` - Order details

### Admin Routes (Admin role required)
- `/admin/dashboard` - Admin dashboard
- `/admin/categories` - Category management
- `/admin/products` - Product management
- `/admin/orders` - Order management

## Payment Methods

Currently supports:
- Cash on Delivery (default)

Ready to integrate:
- Stripe
- PayPal

## Order Status Flow

1. **pending** - Order placed
2. **paid** - Payment confirmed
3. **preparing** - Order being prepared
4. **out_for_delivery** - Order with delivery person
5. **delivered** - Order completed
6. **cancelled** - Order cancelled

## Development Notes

- Uses Laravel Breeze for authentication scaffolding
- Implements role-based access control (Customer/Admin)
- Session-based cart for guests, database-based for logged users
- Inventory management with stock checking
- Order number generation with unique identifiers

## Future Enhancements

- Online payment integration (Stripe/PayPal)
- Product reviews and ratings
- Promotions and discounts
- Delivery fee calculation
- Email notifications
- SMS notifications
- Mobile app API
