# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Initial creation of the project.

## [0.0.2] - 2025-04-15

### Added

- Abstract class `RouteArchitect` providing base core routing logic and structure.
- `IsNotMiddleware` callable for filtering specific middlewares.
- Base configuration file for customizable behavior of this package.
- `RouteArchitectTypes` enum encapsulating supported method types of `type` property of the `RouteArchitect` class.
- `RouteArchitectHelpers` with base utility functions.

## [0.0.3] - 2025-04-15

### Added

- New properties, methods, getters, and setters in the `RouteArchitect` class.
- New helper functions in the `RouteArchitectHelpers` class.
- `RouteArchitectConfig` for encapsulating configuration names.
- New configuration options.

## [0.0.4] - 2025-04-16

### Added

- New properties and methods in the `RouteArchitect` class.
- New properties in the `RouteArchitectConfig` enum.
- Class `RouteArchitectSequences` for working with the sequence of `RouteArchitect` classes.
- New configuration options.

## [0.0.5] - 2025-04-17

### Added

- New properties, logic and methods in the `RouteArchitect` class.

### Changed

- Refactored methods accessing the collection in the `RouteArchitectSequences` class.
- Reordered methods in the `RouteArchitect` class for better organization.

## [0.0.6] - 2025-04-21

### Added

- New dependencies.
- New configuration option.
- New method `get_config()` in `RouteArchitectConfig`.
- New enums:
	- `RouteArchitectSequenceTypes`.
	- `RouteArchitectRouteMethodNames`.
	- `RouteArchitectErrors`.
- New logic and methods in `RouteArchitectHelpers`, including `get_callable()` and `get_closure()`.
- New logic and methods in `RouteArchitect`, including `get_name_sequences()` and `get_view_sequences()`, etc.
- New logic in `RouteArchitectSequences`.
- New property in `RouteArchitectErrors`.

### Changed

- Used `Collection::has()` instead of `contains()` for better accuracy in `RouteArchitectSequences`.
- Replaced array access in `get_method_name()` with `match` expression.
- Updated middleware managing to use `RouteArchitectMiddlewares` (**breaking change**).
- Renamed method `callable()` and `get_callable()` with `handle()` and `get_handle()` in `RouteArchitect` (**breaking change**).

### Removed

- Deprecated methods in `RouteArchitectHelpers` (**breaking change**).