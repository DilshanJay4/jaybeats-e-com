# Jaybeats 🎧 — Headphones & Audio Accessories E-Commerce

**Jaybeats** is a procedural PHP + MySQL e-commerce web application designed for selling headphones, wireless earbuds, bluetooth speakers, gaming headsets, and audio accessories.

It features a customer storefront and an admin management panel built with **Vanilla HTML, CSS, JavaScript, PHP 8.1, and MySQL/MariaDB**.

---

## 🚀 Quick Start (Single Command with Docker)

The easiest way to run the entire project (web application + auto-seeded database) is using **Docker Compose**:

```bash
docker compose up --build
```

Once running, access the application in your browser:

* 🛒 **Storefront**: [http://localhost:8000/home.php](http://localhost:8000/home.php)
* 🔐 **Admin Panel**: [http://localhost:8000/admin/admin_login.php](http://localhost:8000/admin/admin_login.php)

To stop the containers:
```bash
docker compose down
```

---

## 🔑 Default Credentials

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin` | `111` |
| **Customer** | `dilshan@gmail.com` | `111` |

---

## 🛠️ Local Setup (Without Docker)

If you prefer to run the project using a local PHP CLI server and MySQL:

1. **Import the Database**:
   ```bash
   mysql -u root -p < jaybeats_db.sql
   ```
2. **Configure Database Connection** (Optional):
   The application connects via [`components/connect.php`](components/connect.php). By default, it reads environment variables (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`) with fallbacks to `localhost`, `jaybeats_db`, `root`, and `mysql`.

3. **Start PHP Development Server**:
   ```bash
   php -S localhost:8000
   ```

---

## ✨ Features & Functionality

### Storefront (Customers & Guests)
* 🎧 **Hero Banner & Sliders**: Featured audio products and promotions.
* 📦 **Product Catalogue & Search**: Filter products by audio categories (**Headphones**, **Earbuds**, **Wireless**, **Gaming**, **Speakers**, **Accessories**) or search by keywords using secure prepared statements.
* 👁️ **Quick View**: Inspect individual audio product details.
* 🛒 **Cart Management**: Add items, update quantities, remove items, or clear cart.
* 💳 **Checkout Flow**: Select delivery address and payment methods (*Cash on Delivery, Credit Card, Debit Card, Bank Transfer*).
* 📋 **Order Tracking**: View past orders and payment status (*Pending / Completed*).
* 👤 **User Profiles & Auth**: Secure registration, login, profile updates, and bcrypt password hashing.
* ✉️ **Contact Form**: Send messages directly to store administration.

### Admin Panel
* 📊 **Dashboard**: Real-time business metrics (pending/completed revenue, total orders, product counts, registered users, admin accounts, unread messages).
* 🛠️ **Product CRUD**: Add new audio products with 2MB image uploads, edit product prices/categories, or delete items.
* 🚚 **Order Management**: Review placed customer orders and update payment status to `completed` or delete orders.
* 👥 **Account Management**: Manage customer accounts and register/delete admin users.
* 📬 **Messages**: Read and delete customer contact inquiries.

---

## 🧰 Technology Stack

* **Frontend**: Vanilla HTML5, Vanilla CSS3, Vanilla JavaScript, Swiper 8 (sliders), Font Awesome 6 (icons).
* **Backend**: PHP 8.1 (procedural page controllers), PDO prepared statements, PHP native sessions.
* **Database**: MySQL 8.0 / MariaDB (`jaybeats_db`).
* **Containerization**: Docker & Docker Compose.

---

## 📁 Project Structure

```
jaybeats/
├── admin/                  # Guarded admin panel scripts
│   ├── admin_login.php     # Admin login
│   ├── dashboard.php       # Dashboard statistics
│   ├── products.php        # Product CRUD & image uploads
│   ├── update_product.php  # Product editor
│   └── placed_orders.php   # Order management
├── components/             # Shared PHP includes
│   ├── connect.php         # PDO database connection
│   ├── user_header.php     # Storefront header & navigation
│   ├── admin_header.php    # Admin header & navigation
│   ├── add_cart.php        # Cart handler logic
│   └── footer.php          # Storefront footer
├── css/                    # Custom stylesheets
│   ├── style.css           # Storefront design
│   └── admin_style.css     # Admin panel design
├── js/                     # Vanilla JS scripts
├── uploaded_img/           # Web-writable product upload directory
├── Dockerfile              # PHP 8.1 Apache container build spec
├── docker-compose.yml      # Orchestration for web server & MySQL database
└── jaybeats_db.sql         # Database schema & initial seed data
```

---

## 🔐 Security Highlights

* **Bcrypt Password Hashing**: All user and admin passwords use PHP `password_hash()` and `password_verify()`.
* **SQL Injection Prevention**: All queries use PDO prepared statements with parameter binding.
* **Strict Admin Auth Guards**: Guard checks verify logged-in session state (`empty($admin_id)`) before rendering admin pages.
* **Server-Side Form Validation**: Order user details are populated directly from server-side session state to prevent hidden field tampering.
