# MARKSYS - Marketing & Sales Lead Management System

![Laravel](https://img.shields.io/badge/Laravel-v11-red)
![Filament](https://img.shields.io/badge/Filament-v4.0-blue)
![PHP](https://img.shields.io/badge/PHP-8.2+-purple)

## 📋 TABLE OF CONTENTS

- [About Project](#about-project)
- [System Architecture](#system-architecture)
- [Data Flow Diagram](#data-flow-diagram)
- [System Flow](#system-flow)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [User Roles](#user-roles)
- [Business Rules](#business-rules)

---

## 🎯 ABOUT PROJECT

**MARKSYS** adalah sistem manajemen leads yang mengintegrasikan departemen Marketing dan Sales dalam satu platform. Sistem ini dirancang untuk mengoptimalkan proses dari lead generation hingga closing deal dengan tracking pricing yang ketat dan perhitungan profit otomatis.

### Key Objectives:
- ✅ Memisahkan role Marketing dan Sales dengan jelas
- ✅ Tracking pricing dengan aturan 5% (target price ± 5%)
- ✅ Kalkulasi profit otomatis dari setiap transaksi
- ✅ Dashboard analytics real-time untuk setiap role
- ✅ Exclude rejected leads dari perhitungan average dan profit

---

## 🏗️ SYSTEM ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────────┐
│                     MARKSYS APPLICATION                          │
│                   (Laravel 11 + Filament v4)                     │
└─────────────────────────────────────────────────────────────────┘
                               │
                ┌──────────────┼──────────────┐
                │              │              │
         ┌──────▼──────┐ ┌────▼─────┐ ┌─────▼──────┐
         │   ADMIN     │ │ MARKETING │ │   SALES    │
         │   PANEL     │ │   PANEL   │ │   PANEL    │
         └─────────────┘ └───────────┘ └────────────┘
                │              │              │
                └──────────────┼──────────────┘
                               │
                    ┌──────────▼──────────┐
                    │   LEADSDATA MODEL   │
                    │   (Single Source    │
                    │    of Truth)        │
                    └──────────┬──────────┘
                               │
                    ┌──────────▼──────────┐
                    │   MySQL DATABASE    │
                    └─────────────────────┘
```

### Panel Structure:

#### 1. **ADMIN PANEL** (`/admin`)
- Full access ke semua data
- Complete analytics dashboard
- User management
- Status: waiting, approved, follow-up, rejected

#### 2. **MARKETING PANEL** (`/marketting`)
- Create dan input leads baru
- Set target price (harga marketing)
- View waiting leads (pending approval dari sales)
- View pricing guidelines untuk sales team

#### 3. **SALES PANEL** (`/sales`)
- Review leads dari marketing
- Approve/reject leads
- Set fixed price (harga final)
- Follow-up tracking
- Performance analytics dengan target 5%

---

## 📊 DATA FLOW DIAGRAM

### DFD Level 0 (Context Diagram)

```
                    ┌──────────────────┐
                    │   MARKETING      │
                    │   DEPARTMENT     │
                    └────────┬─────────┘
                             │
                    Input Leads + Target Price
                             │
                             ▼
        ┌────────────────────────────────────────────┐
        │                                            │
        │         MARKSYS LEAD MANAGEMENT            │
        │              SYSTEM                        │
        │                                            │
        └──────────┬────────────────┬────────────────┘
                   │                │
         Analytics │                │ Approve/Reject
         Dashboard │                │ + Fixed Price
                   │                │
                   ▼                ▼
        ┌──────────────┐   ┌──────────────┐
        │    ADMIN     │   │    SALES     │
        │  DEPARTMENT  │   │  DEPARTMENT  │
        └──────────────┘   └──────────────┘
```

### DFD Level 1 (Main Processes)

```
┌─────────────────────────────────────────────────────────────────────┐
│                         MARKSYS SYSTEM                              │
└─────────────────────────────────────────────────────────────────────┘

    MARKETING                                                   SALES
        │                                                         │
        │ 1. Input Lead                                          │
        ▼                                                         │
  ┌──────────┐                                                   │
  │ Process  │ → Store → [LEADSDATA DB]                          │
  │ 1.1      │           status: waiting                         │
  └──────────┘           target_price: set                       │
        │                                                         │
        │ 2. Notification                                        │
        └────────────────────────────────────────────────────────┤
                                                                  │
                                                    3. Review Lead │
                                                                  ▼
                                                            ┌──────────┐
                                     Update Status ←────── │ Process  │
                                     Update Fixed Price    │ 2.1      │
                                                            └──────────┘
                                                                  │
                        ┌─────────────────────────────────────────┤
                        │                                         │
                   4a. APPROVED                              4b. REJECTED
                        │                                         │
                        ▼                                         ▼
                 ┌──────────┐                              ┌──────────┐
                 │ Process  │                              │ Process  │
                 │ 3.1      │                              │ 3.2      │
                 └────┬─────┘                              └────┬─────┘
                      │                                         │
         status: approved                          status: rejected
         fixed_price: set                         (Excluded from avg)
                      │                                         │
                      ├─────────────────┬───────────────────────┤
                      │                 │                       │
                      ▼                 ▼                       ▼
              ┌──────────────┐  ┌──────────────┐      ┌──────────────┐
              │   Calculate  │  │   Calculate  │      │   No Action  │
              │   Average    │  │   Profit     │      │   (Excluded) │
              │   Price      │  │              │      │              │
              └──────────────┘  └──────────────┘      └──────────────┘
                      │                 │
                      └────────┬────────┘
                               │
                               ▼
                      ┌──────────────┐
                      │   Display    │
                      │  Analytics   │
                      │  Dashboard   │
                      └──────────────┘
```

### DFD Level 2 (Detailed Calculation Process)

```
┌─────────────────────────────────────────────────────────────────┐
│                   CALCULATION SUBSYSTEM                         │
└─────────────────────────────────────────────────────────────────┘

Input: LEADSDATA (All Records)
    │
    ├─────────────────────┬──────────────────────┬───────────────┐
    │                     │                      │               │
    ▼                     ▼                      ▼               ▼
┌────────┐          ┌────────┐           ┌────────┐       ┌────────┐
│WAITING │          │APPROVED│           │FOLLOW-UP│       │REJECTED│
└───┬────┘          └───┬────┘           └───┬────┘       └───┬────┘
    │                   │                    │               │
    │ Include           │ Include            │ Include       │ EXCLUDE
    │                   │                    │               │
    └───────────────────┴────────────────────┘               X
                        │
                Filter: status != 'rejected'
                        │
        ┌───────────────┴───────────────┐
        │                               │
        ▼                               ▼
┌──────────────────┐          ┌──────────────────┐
│  AVG TARGET      │          │  AVG FIXED       │
│  PRICE           │          │  PRICE           │
│                  │          │                  │
│ SUM(target_price)│          │ SUM(fixed_price) │
│ ───────────────  │          │ ───────────────  │
│ COUNT(records)   │          │ COUNT(records)   │
└────────┬─────────┘          └────────┬─────────┘
         │                             │
         │                             │
         └──────────────┬──────────────┘
                        │
                        ▼
              ┌──────────────────┐
              │  CALCULATE       │
              │  AVG PROFIT      │
              │                  │
              │ avg_fixed_price  │
              │      MINUS       │
              │ avg_target_price │
              └────────┬─────────┘
                       │
                       ▼
              ┌──────────────────┐
              │  PROFIT BY       │
              │  SOURCE          │
              │                  │
              │ GROUP BY         │
              │ source_leads     │
              │ (exclude reject) │
              └────────┬─────────┘
                       │
                       ▼
              ┌──────────────────┐
              │  DISPLAY TO      │
              │  DASHBOARD       │
              └──────────────────┘
```

---

## 🔄 SYSTEM FLOW

### 1. MARKETING WORKFLOW

```
START
  │
  ▼
┌─────────────────────────┐
│ Marketing Login         │
│ (/marketting)           │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ View Dashboard          │
│ - Total Leads           │
│ - Waiting Approval      │
│ - Avg Target Price      │
│ - Sales Target (+5%)    │
│ - Min Discount (-5%)    │
│ - Price Range           │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ Create New Lead         │
│ Input:                  │
│ - Customer Name         │
│ - Product               │
│ - Source Leads          │
│ - Target Price ★        │
│ - Notes                 │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ Submit Lead             │
│ Status: WAITING         │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ Lead sent to Sales      │
│ for approval            │
└───────────┬─────────────┘
            │
            ▼
          END
```

**★ Target Price Rules:**
- Harga yang diset marketing sebagai baseline
- Sales harus aim 5% di atas target price
- Min discount hanya 5% di bawah target price
- Range acceptable: 95% - 105% dari target price

---

### 2. SALES WORKFLOW

```
START
  │
  ▼
┌─────────────────────────┐
│ Sales Login             │
│ (/sales)                │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ View Dashboard          │
│ - Waiting Approval      │
│ - Approved              │
│ - Follow-up             │
│ - Rejected              │
│ - Avg Target Price      │
│ - Target Fixed (+5%)    │
│ - Actual Fixed Price    │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ Review Lead from        │
│ Marketing               │
│                         │
│ See:                    │
│ - Target Price          │
│ - Target Fixed (5%)     │
│ - Recommended Range     │
└───────────┬─────────────┘
            │
     ┌──────┴──────┐
     │             │
     ▼             ▼
┌─────────┐   ┌─────────┐
│ APPROVE │   │ REJECT  │
└────┬────┘   └────┬────┘
     │             │
     ▼             ▼
┌──────────────┐ ┌──────────────┐
│ Set Fixed    │ │ Status:      │
│ Price        │ │ REJECTED     │
│              │ │              │
│ Validation:  │ │ Excluded     │
│ ≥ 95% target │ │ from AVG     │
│ ≤ 105% ideal │ │ calculation  │
└──────┬───────┘ └──────────────┘
       │
       ▼
┌──────────────────┐
│ Color Indicator: │
│                  │
│ 🔴 RED:         │
│ < 95% target     │
│ (Too Low!)       │
│                  │
│ 🔵 BLUE:        │
│ 95% - 105%       │
│ (At Target)      │
│                  │
│ 🟢 GREEN:       │
│ ≥ 105% target   │
│ (Exceeding!)     │
└──────┬───────────┘
       │
       ▼
┌──────────────────┐
│ Status: APPROVED │
│ or FOLLOW-UP     │
└──────┬───────────┘
       │
       ▼
     END
```

---

### 3. ADMIN WORKFLOW

```
START
  │
  ▼
┌─────────────────────────┐
│ Admin Login             │
│ (/admin)                │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ View Complete Dashboard │
│                         │
│ ALL METRICS:            │
│ ✓ Total Leads           │
│ ✓ Waiting Approval      │
│ ✓ Approved              │
│ ✓ Follow-up             │
│ ✓ Rejected              │
│ ✓ Avg Target Price      │
│ ✓ Target Fixed (+5%)    │
│ ✓ Avg Fixed Price       │
│ ✓ Avg Profit            │
│                         │
│ CHARTS:                 │
│ ✓ Leads by Source       │
│ ✓ Profit by Source      │
│                         │
│ TABLE:                  │
│ ✓ All Leads Detail      │
│ ✓ Target vs Actual      │
│ ✓ Profit per Lead       │
│ ✓ Status Filter         │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ Manage Users            │
│ - Create User           │
│ - Assign Role           │
│   (admin/marketting/    │
│    sales)               │
└───────────┬─────────────┘
            │
            ▼
┌─────────────────────────┐
│ Monitor All Leads       │
│ - Edit any lead         │
│ - View full history     │
│ - Export reports        │
└───────────┬─────────────┘
            │
            ▼
          END
```

---

## ✨ FEATURES

### 🎨 Dashboard Features

#### Admin Dashboard
- ✅ Complete overview of all leads
- ✅ 9 statistical cards (status breakdown + pricing metrics)
- ✅ Leads by Source bar chart
- ✅ Profit by Source doughnut chart
- ✅ Advanced leads table with filters
- ✅ Target vs Actual price comparison
- ✅ Profit calculation per lead
- ✅ User management

#### Marketing Dashboard
- ✅ Total leads counter
- ✅ Waiting approval tracking
- ✅ Average target price display
- ✅ Sales target guideline (+5%)
- ✅ Minimum discount guideline (-5%)
- ✅ Acceptable price range display
- ✅ Leads by Source doughnut chart
- ✅ Waiting leads table

#### Sales Dashboard
- ✅ Status breakdown (waiting, approved, follow-up, rejected)
- ✅ Average target price from marketing
- ✅ Target fixed price goal (+5%)
- ✅ Actual fixed price with validation
- ✅ Profit by Source doughnut chart
- ✅ Complete leads table with:
  - Target price column
  - Target fixed (+5%) column
  - Actual fixed price with color indicator
  - Profit calculation
  - Status filter

### 🎯 Pricing System

#### Target Price (Marketing)
- Base price set by marketing team
- Used as reference for sales team

#### Fixed Price (Sales)
- Final price set by sales team
- Must be within acceptable range

#### Pricing Rules (5% System)
```
Target Price: RM 1,000

Sales Target (Goal):
RM 1,050 (105% - aim for this!)

Acceptable Range:
RM 950 - RM 1,050 (95% - 105%)

Minimum (Max Discount):
RM 950 (95% - don't go below!)
```

#### Color Indicators
- 🔴 **RED** (Danger): < 95% of target price (too low!)
- 🔵 **BLUE** (Primary): 95% - 105% of target price (at target range)
- 🟢 **GREEN** (Success): ≥ 105% of target price (exceeding target!)

### 📊 Analytics & Calculations

#### Included in Calculations:
- ✅ Waiting
- ✅ Approved
- ✅ Follow-up

#### Excluded from Calculations:
- ❌ Rejected (no transaction occurred)

#### Calculated Metrics:
1. **Average Target Price** = SUM(target_price) / COUNT(non-rejected leads)
2. **Average Fixed Price** = SUM(fixed_price) / COUNT(non-rejected leads)
3. **Average Profit** = Average Fixed Price - Average Target Price
4. **Profit by Source** = SUM(fixed_price - target_price) GROUP BY source_leads (exclude rejected)

### 🔒 Role-Based Access Control

| Feature | Admin | Marketing | Sales |
|---------|-------|-----------|-------|
| View All Leads | ✅ | ❌ | ❌ |
| Create Lead | ✅ | ✅ | ❌ |
| Set Target Price | ✅ | ✅ | ❌ |
| Approve/Reject | ✅ | ❌ | ✅ |
| Set Fixed Price | ✅ | ❌ | ✅ |
| View Profit | ✅ | ❌ | ✅ |
| User Management | ✅ | ❌ | ❌ |
| Full Analytics | ✅ | Partial | Partial |

---

## 🛠️ TECH STACK

### Backend
- **Laravel 11** - PHP Framework
- **Filament v4.0** - Admin Panel Framework
- **MySQL** - Database
- **PHP 8.2+** - Programming Language

### Frontend
- **Livewire** - Dynamic UI
- **Alpine.js** - JavaScript Framework
- **Tailwind CSS** - CSS Framework
- **Chart.js** - Data Visualization

### Key Packages
- `filament/filament` - Admin panel
- `filament/widgets` - Dashboard widgets
- `filament/tables` - Data tables
- `filament/forms` - Form builder

---

## 📦 INSTALLATION

### Requirements
- PHP >= 8.2
- Composer
- MySQL >= 5.7
- Node.js & NPM (for assets)

### Steps

1. **Clone Repository**
```bash
git clone <repository-url>
cd project-rama
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run Migrations**
```bash
php artisan migrate
```

6. **Seed Database (Optional)**
```bash
php artisan db:seed
```

7. **Build Assets**
```bash
npm run build
```

8. **Start Server**
```bash
php artisan serve
```

9. **Access Application**
- Admin: `http://localhost:8000/admin`
- Marketing: `http://localhost:8000/marketting`
- Sales: `http://localhost:8000/sales`

---

## 👥 USER ROLES

### Admin
**Access:** Full system access

**Responsibilities:**
- Monitor overall system performance
- Manage users and permissions
- View complete analytics
- Oversee marketing and sales operations

**Default Credentials:**
```
Email: admin@example.com
Password: password
```

### Marketing
**Access:** Lead creation and marketing analytics

**Responsibilities:**
- Generate and input new leads
- Set target prices
- Monitor waiting approvals
- Track lead sources

**Default Credentials:**
```
Email: marketing@example.com
Password: password
```

### Sales
**Access:** Lead approval and sales analytics

**Responsibilities:**
- Review leads from marketing
- Approve or reject leads
- Set fixed prices (within 5% rules)
- Follow-up on leads
- Close deals

**Default Credentials:**
```
Email: sales@example.com
Password: password
```

---

## 📜 BUSINESS RULES

### 1. Lead Status Flow
```
CREATE (Marketing)
    ↓
WAITING (Pending Sales Approval)
    ↓
    ├→ APPROVED (Transaction Closed)
    ├→ FOLLOW-UP (Needs More Discussion)
    └→ REJECTED (Not Converting)
```

### 2. Pricing Rules (5% System)

**For Marketing:**
- Set realistic target price based on product/service value
- Consider market conditions
- This becomes the baseline for sales

**For Sales:**
- **Goal:** Achieve 105% of target price (5% above)
- **Acceptable Range:** 95% - 105% of target price
- **Minimum:** Don't go below 95% (max 5% discount)
- **Validation:** System shows color indicators

**Example:**
```
Marketing sets Target Price: RM 10,000

Sales Guidelines:
- Goal (Green): ≥ RM 10,500 (105%)
- Acceptable (Blue): RM 9,500 - RM 10,500 (95-105%)
- Too Low (Red): < RM 9,500 (<95%)
```

### 3. Calculation Rules

**Included in Averages & Profit:**
- Waiting leads (potential revenue)
- Approved leads (closed deals)
- Follow-up leads (in progress)

**Excluded from Averages & Profit:**
- Rejected leads (no transaction = no revenue)

**Profit Formula:**
```
Profit per Lead = Fixed Price - Target Price

Average Profit = (SUM of all profits) / (COUNT of non-rejected leads)
```

### 4. Data Consistency Rules

- **Target Price:** Set once by marketing, can be edited by admin
- **Fixed Price:** Set by sales only when approving
- **Status Changes:** Audited and tracked
- **Lead Source:** Required for analytics
- **Customer Info:** Required for all leads

---

## 📈 DASHBOARD METRICS EXPLAINED

### Key Performance Indicators (KPIs)

#### 1. Total Leads
Total number of all leads in the system (all statuses)

#### 2. Waiting Approval
Leads that marketing has submitted but sales hasn't reviewed yet

#### 3. Approved
Successfully closed deals

#### 4. Follow-up
Leads currently being pursued by sales

#### 5. Rejected
Leads that didn't convert (excluded from calculations)

#### 6. Average Target Price
Mean of all target prices (excluding rejected)
- Shows marketing's pricing baseline

#### 7. Target Fixed Price (+5%)
What sales should aim for
- Formula: Avg Target Price × 1.05

#### 8. Average Fixed Price
Mean of actual selling prices (excluding rejected)
- Shows actual sales performance

#### 9. Average Profit
Mean profit across all deals
- Formula: Avg Fixed Price - Avg Target Price
- **Green:** Positive profit (good!)
- **Red:** Negative profit (pricing issue!)

#### 10. Profit by Source
Total profit grouped by lead source
- Helps identify most profitable channels
- Excludes rejected leads

---

## 🎨 UI/UX FEATURES

### Animations
- Smooth fade-in animations for widgets
- Staggered card loading effects
- Hover effects on interactive elements
- Chart animations on load

### Styling
- **Uppercase Labels:** All text in UPPERCASE for professional look
- **Color-Coded Indicators:** Instant visual feedback
- **Responsive Design:** Works on all screen sizes
- **Dark Mode Ready:** Theme support

### User Experience
- **Real-time Updates:** Data refreshes automatically
- **Search & Filter:** Quick data access
- **Sort Columns:** Organize data your way
- **Export Options:** Download reports
- **Inline Editing:** Quick updates

---

## 🔧 CUSTOMIZATION

### Adding New Status

1. Update database enum:
```php
// In migration
$table->enum('status', ['waiting', 'approved', 'follow-up', 'rejected', 'new-status']);
```

2. Update widgets to include new status in calculations

3. Add color mapping:
```php
'new-status' => 'info',
```

### Changing Pricing Rules

Edit percentage in widget files:
```php
// Current: 5%
$targetFixedPrice = $avgTargetPrice * 1.05;
$minDiscountPrice = $avgTargetPrice * 0.95;

// Example: Change to 10%
$targetFixedPrice = $avgTargetPrice * 1.10;
$minDiscountPrice = $avgTargetPrice * 0.90;
```

### Adding New Dashboard Widget

1. Create widget:
```bash
php artisan make:filament-widget CustomWidget --panel=admin
```

2. Register in Panel Provider:
```php
->widgets([
    \App\Filament\Widgets\CustomWidget::class,
])
```

---

## 📝 DATABASE SCHEMA

### Main Table: `leadsdatas`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| customer_name | varchar | Customer name |
| product | varchar | Product/service |
| source_leads | varchar | Lead source |
| status | enum | waiting, approved, follow-up, rejected |
| target_price | decimal | Price set by marketing |
| fixed_price | decimal | Price set by sales |
| notes | text | Additional notes |
| created_at | timestamp | Creation time |
| updated_at | timestamp | Last update time |

### Users Table: `users`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | User name |
| email | varchar | User email |
| password | varchar | Hashed password |
| role | enum | admin, marketting, sales |
| created_at | timestamp | Creation time |
| updated_at | timestamp | Last update time |

---

## 🐛 TROUBLESHOOTING

### Issue: Follow-up count shows 0

**Cause:** Data has inconsistent status format (e.g., "followup" vs "follow-up")

**Solution:**
```bash
php artisan tinker
App\Models\Leadsdata::where('status', 'followup')->update(['status' => 'follow-up']);
```

### Issue: Dashboard not updating

**Solution:**
```bash
php artisan optimize:clear
php artisan filament:cache-components
```

### Issue: Permission denied errors

**Solution:**
Check middleware in PanelProvider:
```php
->authMiddleware([
    Authenticate::class,
    RoleMiddleware::class . ':admin',
])
```

---

## 📞 SUPPORT

For issues or questions:
1. Check this documentation
2. Review [Filament Documentation](https://filamentphp.com/docs)
3. Check [Laravel Documentation](https://laravel.com/docs)

---

## 📄 LICENSE

This project is licensed under the MIT License.

---

## 🙏 ACKNOWLEDGMENTS

- **Laravel** - The PHP Framework for Web Artisans
- **Filament** - The elegant TALL stack admin panel
- **Chart.js** - Simple yet flexible JavaScript charting

---

**Built with ❤️ using Laravel & Filament**

*Last Updated: December 2025*
