#Election Management Platform

A platform for conducting **secure online elections** efficiently. Built with Laravel 12 and Tailwind CSS v4.

## ✨ Features

### 🗳️ Election Management

-   **Multiple Vote Types:**
    -   **Single Choice** – Select one candidate from all candidates (e.g., President)
    -   **Multiple Choice** – Select up to a maximum number of candidates (e.g., "Select up to 2 Senators")
    -   **Yes/No Voting** – Vote yes or no for each candidate in a position (e.g., Executive Board approval)
-   **Category-Based Restrictions** – Restrict certain positions to specific voter categories (e.g., A user in "A" category can only vote for "A" category Reps)
-   **Position Management** – Admin can create, edit, and delete positions with custom vote types
-   **Candidate Management** – Add, edit, and remove candidates with photos and profile information
-   **Real-time Results** – Live vote counting and results display for authorized users
-   **Election Control** – Toggle election periods on/off from settings
-   **Flexible Authentication** – Users can log in with either User ID or Email

### 👥 Voter Management

-   **Admin Control** – Full system access (user management, settings, positions, candidates, results) and Election management (positions, candidates, results, election settings)
-   **Voter CRUD Operations** – Admins can create, view, edit, and delete voters
-   **Category-Based Organization** – Voters organized by categories (e.g., Board Members, Staff, Texans, Alumni)
-   **Voter Management** – Manage voter registration and eligibility

### ⚙️ Settings & Configuration

-   **Dynamic Settings** – Configure organization name, address, contact info from database
-   **Tenure Management** – Set current tenure
-   **Election Toggle** – Enable/disable election periods with start/end dates
-   **Registration Control** – Open/close new member registration

## 🛠️ Tech Stack

### Backend

-   **Laravel 12**
-   **PHP 8.2+**
-   **MySQL**

### Frontend

-   **Tailwind CSS v4**

## 📋 Requirements

-   PHP 8.2 or higher
-   Composer
-   Node.js 20+ and pnpm (or npm)
-   MySQL 5.7+ or MariaDB 10.3+

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/danolu/elections-manager.git
cd elections-manager
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
# Using pnpm (recommended)
pnpm install

# Or using npm
npm install
```

### 4. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Environment Variables

Edit `.env` and set your configuration:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Application
APP_NAME="Your Organization Name"
APP_URL=http://localhost
```

### 6. Database Setup

```bash
# Run migrations and seed database
php artisan migrate --seed

# Link storage for candidate photos
php artisan storage:link
```

This will create:

-   Users table with role-based access control
-   Positions table for dynamic voting positions
-   Candidates table linked to positions
-   Votes table for storing election results
-   Settings table with default values
-   Default admin user (check seeder for credentials)

### 7. Build Assets

```bash
# Development build
pnpm run dev

# Production build
pnpm run build
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

## 🔑 Default Credentials

After seeding, you can log in with:

-   **User ID or Email:** Check your seeder file for default admin credentials

**Note:** Users can log in using either their User ID or Email address.

## ⚙️ Configuration

### Settings Management

Access the settings page to configure:

-   Organization name and contact information
-   Current tenure
-   Election period toggle

All settings are stored in the database and can be updated without code changes.

### Key Routes

#### **Public Routes**

-   `/login` – User login (User ID or Email)
-   `/register` – New user registration (when enabled)
-   `/forgot-password` – Password reset request

#### **User Routes** (Authenticated)

-   `/` – User dashboard
-   `/vote/{position-slug}` – Vote for a specific position
-   `/election` – Election overview

#### **Admin Routes**

-   `/users` – User management (Admin only)
-   `/positions` – Position management (Admin)
-   `/candidates` – Candidate management (Admin)
-   `/results` – Election results (Admin)
-   `/settings` – System settings (Admin with role-based access)

## 🗳️ Voting System

### Overview

The platform features a **fully database-driven voting system** where all positions, candidates, and vote types are managed dynamically through the database. No code changes are needed to add new positions or change voting rules.

### Vote Types

#### **1. Single Choice**

-   Users select **one candidate** from all candidates in the position
-   Example: Presidential election
-   UI: Radio buttons

#### **2. Multiple Choice**

-   Users select **up to a maximum number** of candidates
-   Set `max_vote` to define the limit (e.g., "Select up to 2 Senators")
-   UI: Checkboxes with validation

#### **3. Yes/No Voting**

-   Users vote **yes or no for EACH candidate** in the position
-   All candidates must receive a vote (cannot skip any)
-   Example: Executive board approval voting
-   UI: Yes/No buttons for each candidate

### Category-Based Restrictions

Positions can be restricted to specific user categories:

-   **No category** (default) – All users can vote
-   **With category** (e.g., "100l", "200l", "alumni") – Only users in that category can vote
-   System automatically skips restricted positions during voting flow
-   Examples:
    -   "100 Level Class Rep" (category: "100l") → Only 100-level students can vote
    -   "Alumni Representative" (category: "alumni") → Only alumni can vote

### Managing Elections

#### **Creating Positions** (Admin only)

1. Navigate to `/positions`
2. Click "Add New Position"
3. Fill in:
    - Position Name (e.g., "President")
    - Vote Type (single, multiple, or yes-no)
    - Max Votes (for multiple choice only)
    - Category (optional restriction)

#### **Adding Candidates** (Admin only)

1. Navigate to `/candidates`
2. Click "Add New Candidate"
3. Select position from dropdown
4. Upload photo and add candidate details

#### **Viewing Results** (Admin only)

-   Navigate to `/results` to see live vote counts
-   Results are calculated in real-time from the database
-   Breakdown by position with vote percentages

### Voting Flow

1. User logs in during election period
2. System shows available positions (excluding category-restricted ones)
3. User votes for each position according to its type
4. System validates votes and prevents duplicate voting
5. User is redirected to next position or completion page

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/    # Application controllers
│   │   ├── Auth/           # Authentication controllers
│   │   ├── VoteController.php
│   │   ├── PositionController.php
│   │   ├── CandidateController.php
│   │   └── UserController.php
│   ├── Models/              # Eloquent models
│   │   ├── User.php        # User model with roles
│   │   ├── Position.php    # Voting positions
│   │   ├── Candidate.php   # Election candidates
│   │   └── Vote.php        # Vote records
│   ├── Services/           # Business logic
│   │   └── ElectionService.php
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database migrations
│   │   ├── create_users_table.php
│   │   ├── create_positions_table.php
│   │   ├── create_candidates_table.php
│   │   └── create_votes_table.php
│   └── seeders/            # Database seeders
├── resources/
│   ├── css/
│   │   └── app.css        # Tailwind CSS with @theme config
│   ├── js/
│   │   ├── app.js         # JavaScript entry point
│   │   └── bootstrap.js   # Bootstrap file
│   └── views/             # Blade templates
│       ├── auth/          # Login, register, password reset
│       ├── users/         # User management views
│       ├── positions/     # Position management views
│       ├── candidates/    # Candidate management views
│       ├── vote/          # Voting interface
│       └── results/       # Results display
├── public/
│   ├── assets/            # Static assets (images, vendor JS/CSS)
│   ├── storage/           # Symlinked storage (candidate photos)
│   └── build/             # Compiled assets (generated by Vite)
├── routes/
│   └── web.php            # Web routes
├── vite.config.js         # Vite configuration
└── package.json           # Node dependencies
```

## 🎨 Customization

### Tailwind Theme

Customize colors and design tokens in `resources/css/app.css`:

```css
@theme {
    --color-primary: #7366ff;
    --color-secondary: #f73164;
}
```

### Custom Components

The project includes custom component classes for easy migration from Bootstrap:

-   `.btn-primary`, `.btn-secondary`, `.btn-danger`, etc.
-   `.card`, `.card-body`
-   `.form-control`, `.form-group`
-   `.alert-success`, `.alert-danger`, etc.

## 🧪 Development

### Running Development Server

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (hot reload)
pnpm run dev
```

### Building for Production

```bash
pnpm run build
```

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

## 👨‍💻 Author

**Daniel Oluborode**

-   GitHub: [@danolu](https://github.com/danolu)

## 🙏 Acknowledgments

-   Built with [Laravel](https://laravel.com)
-   Styled with [Tailwind CSS](https://tailwindcss.com)
