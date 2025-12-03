# Symfony Contact Form

A complete Symfony 7.3+ contact form application with TypeScript, Bootstrap 5, and full test coverage.

## Features

- ✅ **Symfony 7.3+** with modern PHP 8.3
- ✅ **Bootstrap 5** for responsive UI
- ✅ **TypeScript** with Webpack Encore
- ✅ **CSRF Protection** built-in
- ✅ **Form Validation** with NotBlank constraints
- ✅ **Database Storage** (MySQL/SQLite via Doctrine ORM)
- ✅ **Email Notifications** via Symfony Mailer
- ✅ **Printable Summary** with @media print CSS
- ✅ **Flash Messages** for success/error feedback
- ✅ **PHPUnit Tests** for backend
- ✅ **Jest Tests** for frontend
- ✅ **Clean Architecture** with CQRS-like separation

## Requirements

- PHP 8.3 or higher
- Composer
- Node.js 20+ and Yarn
- MySQL 8.0+ or PostgreSQL (optional - SQLite works out of the box)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/bassix/symfony-contact-form.git
cd symfony-contact-form
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
yarn install
```

4. Configure your database in `.env`:
```env
# For SQLite (default)
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

# For MySQL
DATABASE_URL="mysql://user:password@127.0.0.1:3306/contact_form?serverVersion=8.0.32&charset=utf8mb4"
```

5. Run database migrations:
```bash
php bin/console doctrine:migrations:migrate
```

6. Build frontend assets:
```bash
yarn build
```

## Usage

### Development

Start the Symfony development server:
```bash
symfony serve
# or
php -S localhost:8000 -t public/
```

Watch and rebuild assets on change:
```bash
yarn watch
```

### With Docker

Start MySQL database with Docker Compose:
```bash
docker compose up -d
```

Update `.env` to use MySQL:
```env
DATABASE_URL="mysql://symfony:symfony@127.0.0.1:3306/contact_form?serverVersion=8.0.32&charset=utf8mb4"
```

## Testing

### Backend Tests (PHPUnit)

Run all PHP tests:
```bash
vendor/bin/simple-phpunit
```

### Frontend Tests (Jest)

Run all JavaScript/TypeScript tests:
```bash
yarn test
```

Watch mode:
```bash
yarn test:watch
```

Coverage report:
```bash
yarn test:coverage
```

## Project Structure

```
.
├── assets/              # Frontend TypeScript/CSS
│   ├── __tests__/      # Jest tests
│   ├── app.ts          # Main TypeScript entry
│   └── styles/         # CSS files
├── config/             # Symfony configuration
├── migrations/         # Database migrations
├── public/             # Web root
│   └── build/         # Compiled assets (generated)
├── src/
│   ├── Controller/    # Controllers
│   ├── Entity/        # Doctrine entities
│   ├── Form/          # Form types
│   ├── Repository/    # Doctrine repositories
│   └── Service/       # Business logic services
├── templates/         # Twig templates
├── tests/             # PHPUnit tests
└── var/               # Cache, logs, SQLite database
```

## Architecture

### Entities

- **FormContact**: Stores contact form submissions (name, email, subject, message)
- **FormSubmissionMeta**: Stores metadata (IP, user agent, referer)

### Services

- **FormContactService**: Handles saving submissions and metadata (CQRS-like command)
- **MailManService**: Sends email notifications using Symfony Mailer

### Controller

- **ContactController**: 
  - `GET/POST /` - Display and handle form submission
  - `GET /contact/success/{id}` - Show submission summary (printable)

### Form Type

- **FormContactType**: Form builder with validation rules and CSRF protection

## Configuration

### Email Configuration

Edit `config/services.yaml`:
```yaml
parameters:
    app.mail.from: 'noreply@example.com'
    app.mail.to: 'admin@example.com'
```

### Mailer DSN

Edit `.env`:
```env
MAILER_DSN=smtp://localhost:1025
```

## Features in Detail

### CSRF Protection
All forms include CSRF token validation automatically.

### Validation
- Name: Required, min 2 chars, max 255 chars
- Email: Required, valid email format
- Subject: Optional, max 255 chars
- Message: Required, min 10 chars

### Printable Summary
The success page includes:
- Print button that triggers `window.print()`
- CSS `@media print` rules to hide UI elements
- Clean, professional printed output

### Metadata Collection
Each submission stores:
- IP address
- User agent
- Referer URL (if available)
- Submission timestamp

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Author

bassix
