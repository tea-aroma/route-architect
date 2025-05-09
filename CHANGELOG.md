# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Released]

## [1.0.0] - 2025-05-09

### Documentation

- Updated README for clarity and better structure.
- Updated LICENSE.

---

## [Unreleased]

### Added

- Initial creation of the project.

---

## [0.0.2] - 2025-04-15

### Added

- Abstract class `RouteArchitect` providing base core routing logic and structure.
- `IsNotMiddleware` callable for filtering specific middlewares.
- Base configuration file for customizable behavior of this package.
- `RouteArchitectTypes` enum encapsulating supported method types of `type` property of the `RouteArchitect` class.
- `RouteArchitectHelpers` with base utility functions.

---

## [0.0.3] - 2025-04-15

### Added

- New properties, methods, getters, and setters in the `RouteArchitect` class.
- New helper functions in the `RouteArchitectHelpers` class.
- `RouteArchitectConfig` for encapsulating configuration names.
- New configuration options.

---

## [0.0.4] - 2025-04-16

### Added

- New properties and methods in the `RouteArchitect` class.
- New properties in the `RouteArchitectConfig` enum.
- Class `RouteArchitectSequences` for working with the sequence of `RouteArchitect` classes.
- New configuration options.

---

## [0.0.5] - 2025-04-17

### Added

- New properties, logic and methods in the `RouteArchitect` class.

### Changed

- Refactored methods accessing the collection in the `RouteArchitectSequences` class.
- Reordered methods in the `RouteArchitect` class for better organization.

---

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

---

## [0.1.0] - 2025-04-22

### Added

- New methods in `RouteArchitect`, including `has_name_sequence()`, `has_view_sequence()`, `get_middlewares_array()`, `get_exclude_middlewares_array()` (**breaking change**).
- New logic for managing sequences in `RouteArchitect` (**breaking change**).
- New `RouteArchitectRegistrar` class for registering routes.

### Changed

- Normalized tab indentation for all files.
- Renamed the `ignore_middlewares` to `exclude_middlewares` (**breaking change**).

---

## [0.1.1] - 2025-04-22

### Fixed

- Access enum value in `RouteArchitectRegistrar`.

---

## [0.1.2] - 2025-04-22

### Fixed

- Change logic in `get_handle()` method in `RouteArchitect`.

---

## [0.1.3] - 2025-04-23

### Added

- New `namespace` and `domain` properties with accessors in `RouteArchitect`.
- New `namespace` and `domain` processing in `RouteArchitectRegistrar`.

### Changed

- Renamed `get_namespace()` method to `get_classname()` in `RouteArchitect` and `RouteArchitectSequences` (**breaking change**).

---

## [0.1.4] - 2025-04-23

### Fixed

- Corrected method call for new processing in `RouteArchitectRegistrar`.

---

## [0.2.0] - 2025-04-26

### Added

- Added check in `domain_processing` method in `RouteArchitectRegistrar`.
- New `view_name_delimiter` configuration option and new property to `RouteArchitectConfig`.
- New `url` property with accessors in `RouteArchitect`.
- New `normalize_with_delimiter`, `get_variables_string` and `is_associative_variables` methods in `RouteArchitect`.
- New `namespace` and `directory` configuration options and new properties to `RouteArchitectConfig`.
- Logic for generating `RouteArchitect` classes with console command.
- Facade and service for `RouteArchitect`.
- Global `route_architect()` helper for easy access to `RouteArchitect` facade.

### Changed

- Reordered methods in `register` method in `RouteArchitectRegistrar`.
- Logic in `get_domain` method in `RouteArchitect`.
- Logic in getters of `name`, `view`, `prefix` and `url` in `RouteArchitect`.
- New commands and singleton in `RouteArchitectServiceProvider` and dependencies in `composer.json`.
- Value for `stub_path` property in `RouteArchitectGenerator`.
- Logic in `extract_path` method and `directory`, `namespace` and `stub_path` getters in `RouteArchitectGenerator`.
- Message for `FILE_EXIST` property in `RouteArchitectGeneratorStates`.
- Logic in `generate` method in `RouteArchitectGenerator`.

### Removed

- Unnecessary import in `RouteArchitect`.

---

## [0.3.0] - 2025-04-30

### Added

- Migrated project codebase from `snake_case` to `camelCase`.
- New `RouteArchitectRegisterMode` trait to manage registration logic.
- New `RouteArchitectRegisterModes` enum to encapsulate registration modes.
- Added `RouteArchitectRegisterMode` into `RouteArchitect`.
- New `UNDEFINED_NAMESPACE` and `NO_PHP_FILES` properties in `RouteArchitectErrors`.
- Logic for automatically scanning and registering `RouteArchitect` classes.

### Changed

- Replaced lazy initialization with direct assignment in `RouteArchitect`.
- Replaced exception with logging for `NO_PHP_FILES` case in the `scan` method in `RouteArchitectAutoScanner`.

### Removed

- Removed unused `variables_to_string`, `get_callable` and `get_closure` methods in `RouteArchitectHelpers`.
- Removed `mode` property and change logic in `getRegistrationMode()` method in `RouteArchitectScannedEntry`.

---

## [0.4.0] - 2025-05-08

### Added

- New `sequences`, `sequencesGroupName`, `context` and `calledRouteArchitect` properties in `RouteArchitect`.
- New `hasSequencesGroupName()`, `isSequencesGroupNameModeEveryGroup()`, `getContext()` and other methods in `RouteArchitect`.
- New `getSequences()` and `getSequenceEntry()` in `RouteArchitectService`.
- New `RouteArchitectContext` class for trace management.
- New `RouteArchitectSequenceEntry` class for per-sequence representation of `RouteArchitect`. 
- New `sequences_group_name_mode` configuration option and new property to `RouteArchitectConfig`.
- New `RouteArchitectSequencesGroupNameModes` enum to encapsulate sequences group name modes.
- New `FindSequenceEntryCallable` callable for finding sequences by names. 

### Changed

- Refactored logic of `Sequences` processing.
- Refactored logic of `Registrar` processing.
- Reformatted indentation and updated comments across the project.

### Removed

- Removed unnecessary `RouteArchitectMethodNames` and `RouteArchitectSequenceTypes` enums.
- Removed `nameSequences` and `viewSequences` properties in `RouteArchitect`.
- Removed `getRouteName()` and `getViewName()` methods in `RouteArchitectService`.
