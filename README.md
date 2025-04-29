# Event Ticketing System

A Laravel-based REST API for managing events and ticket bookings. This system allows users to browse events, book tickets, and administrators to manage venues, events, and bookings.

## Features

- User authentication with Laravel Sanctum
- Event management (CRUD operations)
- Ticket booking system with rate limiting
- User profile with preferred event categories
- Admin dashboard for managing venues, events, and bookings
- Role-based access control

## Prerequisites

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Node.js & NPM (for frontend assets)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd event-ticketing-system
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
```

4. Configure your `.env` file with your database credentials and other settings:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_ticketing
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run database migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
```

7. Start the development server:
```bash
php artisan serve
```

## API Endpoints

### Authentication
- POST `/api/login` - User login
- POST `/api/register` - User registration

### User Routes
- GET `/api/user/events` - List all events
- GET `/api/user/events/{event}` - View specific event
- POST `/api/user/events-book` - Book tickets for an event
- GET `/api/user/bookings` - View user's bookings
- GET `/api/user/profile` - Get user profile
- PUT `/api/user/profile` - Update user profile

### Admin Routes
- GET `/api/admin/venues` - List all venues
- POST `/api/admin/venues` - Create new venue
- GET `/api/admin/events` - List all events
- POST `/api/admin/events` - Create new event
- GET `/api/admin/bookings` - List all bookings
- PUT `/api/admin/bookings/{booking}` - Update booking status

## Rate Limiting

- Ticket booking is limited to 3 attempts per minute per user
- API routes are protected against brute force attempts

## Testing

Run the test suite:
```bash
php artisan test
```

## License

This project is licensed under the MIT License.
