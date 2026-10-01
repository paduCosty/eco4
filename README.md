# Eco4 — Environmental Volunteering Platform

A Laravel web application for organising environmental volunteer events (greening and clean-up actions) across Romania. Anyone can propose an event at a location, coordinators and admins review and run it, volunteers sign up, and supporters can donate online.

I was the primary developer of this application, from database design to production deployment.

## What it does

**For the public**
- Browse approved events by region → city → location
- Propose a new event at a location
- Register as a volunteer for an event
- Share a direct link to any event
- Donate through **PayPal** or **Netopia** (Romanian card payments)
- Contact form

**For coordinators**
- Manage the events assigned to them
- See registered volunteers and email them directly from the app
- Upload and manage photos for each event

**For admins**
- Approve or decline proposed events
- Manage locations, cities and regions
- Full overview of all events and volunteers

## Technical highlights

- **Role-based access** with custom middleware for admin, coordinator and partner roles
- **Two payment integrations**: PayPal (`srmklive/paypal`) and Netopia (`netopia/payment`)
- **Image handling through a CDN** via a dedicated `CdnService`, including upload and deletion of event photos
- **External API integration** (`ApiApplicationService`) that pulls terms, privacy policy and app details from a CRM
- **SEO**: dynamic `sitemap.xml` generated from approved events (`spatie/laravel-sitemap`)
- Relational data model for countries, regions, cities, event locations, registrations and photos (25 migrations)
- Server-rendered Blade views with Tailwind CSS, built with Vite

## Stack

- PHP 8.1, Laravel 10
- MySQL
- Blade, Tailwind CSS, Vite
- PayPal and Netopia payment gateways
- CDN storage for images

## Running it locally

```bash
git clone https://github.com/paduCosty/eco4.git
cd eco4

composer install
npm install

cp .env.example .env
php artisan key:generate

# configure DB_* in .env, then either run the migrations
php artisan migrate
# or import the empty database dump
# mysql -u <user> -p <database> < database/db_eco4_bcp.sql

npm run dev
php artisan serve
```

### Payments (optional)

- **PayPal** — add your PayPal sandbox credentials to `.env` (see the `srmklive/paypal` package documentation).
- **Netopia** — follow the official Netopia documentation: https://github.com/mobilpay/composer

## Project structure (main parts)

```
app/
  Http/Controllers/   Event, Location, City, Volunteer, Contact, PayPal, Netopia
  Http/Middleware/    RoleMiddleware, CoordinatorMiddleware, CheckUserRole
  Models/             EventLocation, UserEventLocation, EventRegistration, Region, City, ...
  Services/           CdnService, ApiService, ApiApplicationService
routes/web.php        public, coordinator and admin routes
```

## Author

Constantin Păduraru — Laravel / PHP developer
[LinkedIn](https://www.linkedin.com/in/constantin-paduraru)
