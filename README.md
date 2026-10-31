<div align="center">

# 🚀 JobBoard App

**A modern job portal where candidates apply with a CV, and AI instantly scores how well they match the role.**

<p>
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img alt="Laravel" src="https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white">
  <img alt="Groq" src="https://img.shields.io/badge/AI-Groq-F55036?style=for-the-badge">
  <img alt="Cloudinary" src="https://img.shields.io/badge/Storage-Cloudinary-3448C5?style=for-the-badge&logo=cloudinary&logoColor=white">
  <img alt="License" src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge">
</p>

</div>

---

## 📑 Table of Contents

- [Overview](#-overview)
- [Ecosystem](#-ecosystem)
- [Features](#-features)
- [How the AI evaluation works](#-how-the-ai-evaluation-works)
- [Tech Stack](#-tech-stack)
- [Getting Started](#-getting-started)
- [Environment Variables](#-environment-variables)
- [Demo Account](#-demo-account)
- [Project Structure](#-project-structure)
- [Routes](#-routes)
- [Testing & Code Style](#-testing--code-style)
- [Troubleshooting](#-troubleshooting)
- [Roadmap](#-roadmap)
- [License](#-license)

---

## 🔎 Overview

**JobBoard App** is the public-facing side of the JobBoard platform. Job seekers can register, discover vacancies with search and filters, and apply by uploading a PDF CV (or reusing one they already uploaded).

Every application goes through an automated pipeline: the CV is stored in the cloud, its text is extracted and structured by an LLM, and the candidate is **scored against the vacancy** with written feedback. Recruiters then see these results in the [Job-backoffice](https://github.com/AbdoNasser23/Job-backoffice).

## 🧩 Ecosystem

```mermaid
flowchart LR
    JS["👤 Job Seeker"] --> APP["🌐 Job-app<br/>(this repo)"]
    APP -- "upload PDF" --> CL["☁️ Cloudinary"]
    APP -- "analyse & score" --> AI["🤖 Groq LLM"]
    APP --> SH[["📦 Job-shared"]]
    BO["🏢 Job-backoffice"] --> SH
    SH --> DB[("🗄️ Shared database")]
    REC["🛡️ Recruiters"] --> BO
```

| Repository | Purpose |
|---|---|
| [**Job-app**](https://github.com/AbdoNasser23/Job-app) | Public portal for job seekers *(you are here)* |
| [**Job-backoffice**](https://github.com/AbdoNasser23/Job-backoffice) | Admin & company-owner console that reviews the applications |
| [**Job-shared**](https://github.com/AbdoNasser23/Job-shared) | Shared models, migrations and seeders used by both apps |

## ✨ Features

### 🔐 Authentication
- Registration, login, logout, password reset and **email verification** (Laravel Breeze).
- Job-seeker-only area protected by a `role:job_seeker` middleware.

### 🔍 Job discovery
- Paginated feed of the latest vacancies.
- **Free-text search** across job title, location, category name and company name.
- **Type filters:** All · Full-time · Contract · Remote · Hybrid.
- Search terms and filters are preserved across pages.

### 📝 One-click applications
- Upload a **PDF CV** (validated: PDF only, max **5 MB**) or **pick a previously uploaded CV**.
- Friendly validation messages for missing, invalid or oversized files.
- CVs are stored on **Cloudinary**, so nothing sits on your server's disk.

### 🤖 AI resume analysis & job matching
- Text is extracted from the PDF and structured into **skills, summary, experience and education**.
- The candidate receives a **0 – 100 relevance score** and **written feedback** for the specific vacancy.

### 📋 My applications
- A paginated history of every application with its status (`pending`, `approved`, `rejected`).

### 👁️ Unique view tracking
- Each vacancy counts **one view per logged-in user**, which feeds the conversion-rate analytics in the backoffice.

## 🧠 How the AI evaluation works

```mermaid
sequenceDiagram
    actor U as Job Seeker
    participant A as Job-app
    participant C as Cloudinary
    participant G as Groq (LLM)
    participant D as Database

    U->>A: Submit application (PDF or saved CV)
    A->>C: Upload PDF (new CVs only)
    C-->>A: Secure file URL
    A->>A: Download PDF & extract text (pdftotext)
    A->>G: 1. Extract skills, summary, experience, education
    G-->>A: Structured JSON
    A->>D: Save resume details
    A->>G: 2. Score resume against vacancy
    G-->>A: ai_generated_score + ai_generated_feedback
    A->>D: Create application (status: pending)
    A-->>U: "Application submitted successfully!"
```

Design choices in `ResumeAnalysisServices`:

- The model is called through Groq's OpenAI-compatible endpoint using `openai/gpt-oss-120b` with **JSON-only responses**.
- Prompts instruct the model to use **only information found in the CV**, never invent missing details, and never treat missing information as proof of a missing qualification.
- The response is **strictly validated** (valid JSON, integer score between 0 and 100, plain-string feedback) before anything is saved.
- The score expresses **job relevance, not a hiring decision**; the final decision stays with the recruiter.

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Language | PHP 8.3+ |
| Framework | Laravel 13 |
| Views | Blade, Alpine.js |
| Styling | Tailwind CSS 3 + `@tailwindcss/forms` |
| Build tooling | Vite 8 |
| Authentication | Laravel Breeze |
| AI | [Groq](https://groq.com/) API (`openai/gpt-oss-120b`) |
| File storage | [Cloudinary](https://cloudinary.com/) (`cloudinary/cloudinary_php`) |
| PDF parsing | `spatie/pdf-to-text` (Poppler `pdftotext`) |
| Testing | Pest 5 |
| Code style | Laravel Pint |
| Shared code | [`job/shared`](https://github.com/AbdoNasser23/Job-shared) |

## 🚀 Getting Started

### Prerequisites

- PHP **8.3+** with the usual Laravel extensions
- [Composer](https://getcomposer.org/) 2+
- Node.js 20.19+ and npm
- MySQL / MariaDB (or SQLite for a quick start)
- **Poppler utilities** (provides `pdftotext`, required for CV parsing)
  ```bash
  # Ubuntu / Debian
  sudo apt install poppler-utils
  # macOS
  brew install poppler
  # Windows: install Poppler and add its `bin` folder to your PATH
  ```
- A free **[Groq](https://console.groq.com/)** API key
- A free **[Cloudinary](https://cloudinary.com/)** account

### 1. Clone and install

```bash
git clone https://github.com/AbdoNasser23/Job-app.git
cd Job-app

composer install
npm install
```

`job/shared` is pulled automatically from GitHub through the VCS repository declared in `composer.json`.

### 2. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Then edit `.env` (see [Environment Variables](#-environment-variables)): at minimum set the database, `GROQ_API_KEY` and `CLOUDINARY_URL`.

> ⚠️ **Job-app and Job-backoffice must point to the same database.** If you use SQLite, set `DB_DATABASE` to the same absolute file path in both projects.

### 3. Migrate and seed

Migrations come from the shared package and are loaded automatically.

```bash
php artisan migrate
php artisan db:seed
```

> If you already ran these from Job-backoffice against the same database, skip this step.

### 4. Run the app

```bash
npm run build        # or `npm run dev` for hot reloading
php artisan serve
```

Open **http://127.0.0.1:8000**.

## ⚙️ Environment Variables

The following keys are required in addition to the standard Laravel settings. `GROQ_API_KEY` and `CLOUDINARY_URL` are **not** part of `.env.example`, so add them manually:

```env
# Database (must be the same database used by Job-backoffice)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jobboard
DB_USERNAME=root
DB_PASSWORD=

# AI resume analysis – https://console.groq.com/keys
GROQ_API_KEY=your_groq_api_key

# CV storage – copy the "API environment variable" from your Cloudinary dashboard
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME

# Email (verification & password reset). `log` writes emails to storage/logs.
MAIL_MAILER=log
```

| Variable | Required | Purpose |
|---|:---:|---|
| `GROQ_API_KEY` | ✅ | Authenticates requests to the Groq API |
| `CLOUDINARY_URL` | ✅ | Credentials used to upload CVs |
| `DB_*` | ✅ | Shared database connection |
| `MAIL_*` | ➖ | Delivery of verification / reset emails |

> 🔒 Never commit your `.env` file or expose API keys.

## 🔑 Demo Account

After running the seeder:

| Role | Email | Password |
|---|---|---|
| Job Seeker | `job@seeker.com` | `123456789` |

You can also create your own account from the **Register** page. New accounts are always created as job seekers.

> 🔒 For local development only. Change or remove demo credentials before any deployment.

## 🗺️ Project Structure

```text
Job-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php     # Job feed, search & filters
│   │   │   ├── VacancyController.php       # Show, apply, upload CV, store application
│   │   │   ├── ApplicationController.php   # "My applications"
│   │   │   └── Auth/                       # Breeze authentication
│   │   ├── Middleware/RoleMiddleware.php   # role:job_seeker
│   │   └── Requests/ApplyProcessApplication.php  # PDF / 5 MB validation
│   └── Services/
│       └── ResumeAnalysisServices.php      # PDF text extraction + Groq calls
├── resources/views/
│   ├── home/  dashboard/  vacancy/  application/  auth/  layouts/
├── routes/
│   ├── web.php
│   └── auth.php
├── tests/                                  # Pest tests
└── composer.json                           # Requires job/shared
```

> Models, migrations and seeders live in the **Job-shared** package.

## 🧭 Routes

| Method | URI | Name | Description |
|---|---|---|---|
| `GET` | `/` | `home` | Landing page |
| `GET` | `/dashboard` | `dashboard` | Vacancy feed with search & filters |
| `GET` | `/vacancy/{vacancy}` | `vacancy.show` | Vacancy details (tracks a unique view) |
| `GET` | `/vacancy/{vacancy}/apply` | `vacancy.apply` | Application form |
| `POST` | `/vacancy/{vacancy}/apply` | `vacancy.processToApply` | Upload / select CV and run AI evaluation |
| `GET` | `/application` | `application.index` | The user's applications |

All routes except `/` and the authentication pages require a logged-in **job seeker**.

## 🧪 Testing & Code Style

```bash
composer test            # clears config cache, then runs the Pest suite
./vendor/bin/pint        # format the code with Laravel Pint
```

## 🩺 Troubleshooting

| Problem | Likely cause & fix |
|---|---|
| Errors mentioning `pdftotext` or a failed CV analysis | Install Poppler (see [prerequisites](#prerequisites)) and make sure `pdftotext` is on your `PATH`. |
| `Error Processing Request` after submitting | Check `GROQ_API_KEY`, your Groq quota and `storage/logs/laravel.log` for the underlying error. |
| CV upload fails | Verify `CLOUDINARY_URL` has the exact `cloudinary://KEY:SECRET@CLOUD` format. |
| Tables not found | Run `php artisan migrate`; the migrations come from `job/shared`. |
| No verification email arrives | With `MAIL_MAILER=log`, emails are written to `storage/logs/laravel.log`. |

## 🛣️ Roadmap

- [ ] Move AI analysis to a **queue** so applying returns instantly
- [ ] Candidate profile page and CV management
- [ ] Email notifications when an application status changes
- [ ] Saved jobs and job alerts
- [ ] Salary range and category filters

## 📄 License

Released under the [MIT License](https://opensource.org/licenses/MIT).

---

<div align="center">

**JobBoard App** — Find the role. Let AI do the matching.

Built by [AbdoNasser23](https://github.com/AbdoNasser23)

</div>
