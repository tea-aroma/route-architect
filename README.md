# RouteArchitect

**A clean, class-based system for organizing Laravel routes.**

Say goodbye to bloated `web.php` files. With
`RouteArchitect`, you define routes as classes — reusable, composable, and auto-discoverable. Perfect for apps with complex structures, admin panels, or modular APIs.

## Why RouteArchitect?

- Keeps your `web.php` clean and maintainable.
- Supports deeply nested and reusable route groups.
- Generates route names, views, prefixes, and URLs automatically.
- Easily extendable, testable, and auto-discoverable.
- Ideal for complex apps with admin panels, modules, or APIs.

## Example:

```php
class AdminRouteArchitect extends RouteArchitect
{
    protected string $identifier = 'admin';

    protected array $routeArchitects = [ DashboardRouteArchitect::class ];
}

// Generates route name: admin.dashboard
class DashboardRouteArchitect extends RouteArchitect
{
    protected string $identifier = 'dashboard';

    protected array | string | null $action = [ DashboardController::class, "index" ];
}

// In another controller...
return view(route_architect()->getSequenceEntry(DashboardRouteArchitect::class)->view);
```

---

## Quick Start

Install the package:

```bash
composer require tea-aroma/route-architect
```

Generate your first `RouteArchitect` class:

```bash
php artisan make:route-architect AdminRouteArchitect --identifier=admin
```

This command will create a new class in `app/RouteArchitects`:

```php
namespace App\RouteArchitects;

use TeaAroma\RouteArchitect\Abstracts\RouteArchitect;

/**
 * AdminRouteArchitect.
 */
class AdminRouteArchitect extends RouteArchitect
{
    /**
     * The identifier.
     *
     * @var string
     */
    protected string $identifier = 'admin';
}
```

**Notice**: By default, the `identifier` is derived from the class name if not specified.

### Registering routes

- **Automatically** (default) — set `auto_scan = true` in the config.
- **Manually** — call `route_architect()->register()` with your `RouteArchitect` class.

```php
// web.php

route_architect()->register(AdminRouteArchitect::class);
```

---

## Configuration

You can publish the configuration file:

```bash
php artisan vendor:publish --provider="TeaAroma\RouteArchitect\Providers\RouteArchitectServiceProvider" --tag=config
```

Available options in `config/route-architect.php`:

| Option                      | Description                                                                 |
|-----------------------------|-----------------------------------------------------------------------------|
| `namespace`                 | Base namespace for generated `RouteArchitect` classes.                      |
| `directory`                 | Base folder for generated `RouteArchitect` classes.                         |
| `auto_scan`                 | Automatically registers all `RouteArchitect` classes.                       |
| `url_variable_template`     | Template for inserting route variables into URLs.                           |
| `url_delimiter`             | Delimiter for URL segments.                                                 |
| `url_segment_delimiter`     | Delimiter within individual URL segments.                                   |
| `route_name_delimiter`      | Delimiter for route name segments.                                          |
| `view_name_delimiter`       | Delimiter for view name segments.                                           |
| `action_delimiter`          | Delimiter between controller class and action method.                       |
| `sequences_group_name_mode` | Defines how the group name should be handled: `only-base` or `every-group`. |

---

## Available properties

When you define your `RouteArchitect` class, you can configure it using the following properties:

| Property               | Description                                                                        |
|------------------------|------------------------------------------------------------------------------------|
| `identifier`           | Acts as a base for `name`, `view`, `url`, `prefix`, and `action` if they are null. |
| `name`                 | Route name segment.                                                                |
| `view`                 | View name segment.                                                                 |
| `prefix`               | URL prefix to apply for this and nested routes.                                    |
| `url`                  | URL segment.                                                                       |
| `type`                 | HTTP method.                                                                       |
| `action`               | Controller action.                                                                 |
| `controller`           | Controller class to apply for this and nested routes.                              |
| `namespace`            | Namespace to apply for this and nested routes.                                     |
| `domain`               | Domain constraint.                                                                 |
| `customUrl`            | Custom URL, bypasses automatic generation.                                         |
| `middlewares`          | Middleware classes to apply.                                                       |
| `excludeMiddlewares`   | Middleware classes to exclude.                                                     |
| `routeArchitects`      | Nested `RouteArchitect` classes.                                                   |
| `variables`            | Route parameters for URL.                                                          |
| `autoScanRegisterMode` | Controls auto-registration behavior during scan.                                   |
| `sequencesGroupName`   | Sequences group name to apply for this and nested routes.                          |
| `registerMode`         | Defines how the route should be registered.                                        |

---

## License

This package is open-sourced software licensed under the [MIT license](https://github.com/tea-aroma/route-architect/blob/main/LICENSE.txt).
