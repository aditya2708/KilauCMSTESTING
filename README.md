# Kilau CMS Testing

## Authentication driver

The application can authenticate either against the remote SSO service or against
local users stored in the database.

Set the `KILAU_AUTH_DRIVER` value in your `.env` file to control this behaviour:

```ini
KILAU_AUTH_DRIVER=remote
```

* `remote` (default): keeps the current behaviour and uses the external
  `login_sso` endpoint.
* `local`: uses the `users` table inside this Laravel installation. The login
  form expects an e-mail address and a password hashed with Laravel's default
  bcrypt helper (`php artisan tinker`, `User::create([...])`, etc.).

Remember to keep the `.env` file updated after copying it from `.env.example`:

```bash
cp .env.example .env
```

Switching between drivers does not require code changes – simply adjust the
`KILAU_AUTH_DRIVER` value and reload the application.
