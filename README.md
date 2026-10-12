# 🍚 UduxPOS
### Smart Ordering & Point of Sale for a Family Food Business

**UduxPOS** is a web-based ordering and point-of-sale system designed to help manage a family-owned nasi uduk business. The application integrates online pre-orders, cashier operations, ingredient inventory, food production, cooked-food stock, and sales reporting into one centralized system.

Built with **Laravel**, UduxPOS aims to simplify daily operations, improve stock accuracy, and help small food businesses manage orders and production more efficiently.

> **One system. Smarter orders. Better stock control.**

---

## ✨ Key Features

### 🛍️ Customer Experience
- Browse the food catalog, prices, and menu availability.
- Place pre-orders for a selected pickup date and time.
- View order history and order status.
- Cancel eligible orders according to business rules.
- View food photos or fallback images when photos are unavailable.

### 🧾 Order Management
- Review, confirm, or reject customer orders.
- Track the complete order lifecycle.
- Manage pickup schedules and preparation start times.
- Set portion quotas for each menu and pickup date.
- Automatically enforce cancellation rules and quota limits.

### 💳 Point of Sale
- Record direct, in-store sales.
- Support cash payments at pickup.
- Calculate transaction totals and change.
- Record payment only when the money is actually received.
- Separate online orders from direct sales.

### 📦 Inventory Management
- Track raw ingredients and their current stock.
- Define recipes and ingredient quantities per portion.
- Automatically calculate ingredient usage during production.
- Record stock movements with timestamps, quantities, and reasons.
- Support stock adjustments with mandatory explanations.

### 🍳 Production & Cooked-Food Stock
- Record the number of portions produced for each menu.
- Increase cooked-food stock after production is recorded.
- Deduct cooked-food stock when a sale is completed.
- Track food that remains available for resale and food that must be discarded.
- Prevent sales from exceeding available cooked-food stock.
- Maintain a history of cooked-food stock adjustments.

### 📊 Sales & Operational Reports
- View total sales for a selected period.
- Separate online-order sales from direct sales.
- Review ingredient stock movements.
- Track leftover and discarded food.

---

## 🧠 What Makes UduxPOS Different?

UduxPOS is designed around the actual workflow of a small food business, where ingredients, production, and finished food must be tracked separately.

**1. Ingredient stock changes during production.**  
Raw ingredients are deducted according to the recipe when production is recorded, not when an order is placed or a sale is completed.

**2. Cooked-food stock is tracked independently.**  
Newly produced food increases cooked-food stock. Completed sales decrease that stock without deducting ingredients a second time.

**3. Leftovers are recorded transparently.**  
Eligible side dishes can be recorded as reusable leftovers within their permitted storage period. Rice leftovers must be recorded as discarded.

**4. Orders follow configurable business rules.**  
Pickup-date quotas, preparation schedules, order status transitions, and cancellation eligibility are enforced by the system.

**5. Every stock adjustment leaves a trace.**  
Inventory movements are recorded to support accountability and more reliable reporting.

---

## 🔄 Order Workflow

`Pending Confirmation` → `Confirmed` → `Preparing` → `Ready for Pickup` → `Completed`

Alternative final statuses:

- **Rejected** — the admin rejects the order with a recorded reason.
- **Cancelled** — the order is cancelled according to the applicable rules.

Order status changes are tracked, including confirmation and preparation timestamps.

---

## 🗃️ Core Data Modules

| Module | Purpose |
|---|---|
| Users | Customer accounts, admin accounts, and access roles |
| Menu | Food names, prices, photos, and availability |
| Recipes | Ingredient requirements per portion |
| Ingredients | Raw ingredient stock and minimum stock levels |
| Orders | Customer orders, pickup schedules, and status history |
| Menu Quotas | Portion limits by menu and pickup date |
| Preparation Settings | Configurable preparation start times |
| Production | Cooked-food production records |
| Cooked-Food Inventory | Available portions from production and eligible leftovers |
| Stock Movements | Auditable records of ingredient and cooked-food changes |
| Transactions | Sales sources, payment records, and completed transactions |

---

## 🛠️ Technology Stack

- **Framework:** Laravel
- **Language:** PHP
- **Database:** Relational database
- **Frontend:** HTML, CSS, JavaScript, and Laravel Blade
- **Development Environment:** Laragon / local PHP development environment
- **Version Control:** Git & GitHub

*The exact database engine and frontend libraries can be updated as implementation decisions are finalized.*

---

## 🚀 Getting Started

### Prerequisites

Make sure the following tools are installed:

- PHP compatible with the Laravel version used by the project
- Composer
- A supported database server
- Git
- Laragon or another local PHP development environment

### Installation

**1. Clone the repository**

```bash
git clone <YOUR_REPOSITORY_URL>
cd uduxPos
```

**2. Install dependencies**

```bash
composer install
```

**3. Configure environment variables**

```bash
cp .env.example .env
```

On Windows, you can also copy `.env.example` to `.env` using File Explorer.

**4. Generate the application key**

```bash
php artisan key:generate
```

**5. Configure the database**

Update the database connection settings in `.env` to match your local database configuration. Create the database before running migrations.

**6. Run database migrations**

```bash
php artisan migrate
```

Run this command only after the project's migrations and database configuration are ready.

**7. Start the development server**

```bash
php artisan serve
```

Open the application in your browser:

`http://127.0.0.1:8000`

---

## 🔐 Security & Data Integrity

UduxPOS is designed with the following requirements:

- Password hashing and role-based access control.
- Server-side validation and authorization.
- CSRF protection and safe output rendering.
- Database transactions for operations that modify multiple records.
- Server-side checks for stock availability and order quotas.
- Traceable inventory movements and stock adjustments.

---

## 🎯 Project Scope

The initial version focuses on the essential operations of a single family-owned food business:

- Customer ordering and pickup.
- Admin operations and cashier transactions.
- Recipe-based ingredient consumption.
- Cooked-food production and inventory.
- Configurable order quotas and cancellation rules.
- Cash payment recording and sales reporting.

Online payment gateways, delivery integration, native mobile applications, offline transactions, loyalty programs, and multi-branch support are outside the initial scope.

---

## 🗺️ Development Roadmap

- [ ] **Phase 1 — Foundation:** Database, authentication, access control, menu catalog, recipes, and inventory.
- [ ] **Phase 2 — Operations:** Pre-orders, order confirmation, quotas, cashier transactions, payments, and leftover tracking.
- [ ] **Phase 3 — Reporting & Testing:** Sales reports, stock movement history, cancellation tests, and stock integrity checks.
- [ ] **Phase 4 — Deployment:** Hosting, online database, HTTPS, and production readiness.

---

## 👩‍💻 Project Information

**Project:** UduxPOS  
**Category:** Web-Based Ordering & Point of Sale  
**Business Domain:** Small Food Business / UMKM  
**Purpose:** Academic project and practical business-management solution  
**Status:** In Development

---

<p align="center">
  <strong>UduxPOS</strong><br>
  <em>Helping small food businesses run smarter, one order at a time.</em>
</p>
