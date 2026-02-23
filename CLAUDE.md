# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Install dependencies
composer install

# Run all tests
vendor/bin/phpunit

# Run a single test file
vendor/bin/phpunit tests/Unit/InstallingPackageTest.php

# Run a specific test suite (Unit or Feature)
vendor/bin/phpunit --testsuite=Unit

# Version bump (uses npm for tagging, auto-pushes via postversion script)
npm version patch|minor|major
```

## Architecture

This is a Laravel package that provides versioning and configuration infrastructure for other Laravel packages. It is designed to be **extended** by consumer packages, not used standalone.

### Core Extension Points

Consumer packages extend this package by:
1. Creating a `Package` class extending `VersionablePackage` with a static `prefix()` method
2. Creating a service provider extending `VersionablePackageServiceProvider` with `getPackageClass()`, `addToRegister()`, and `addToBoot()`
3. Creating a facade extending `VersionablePackageFacade`
4. Creating a test case extending `VersionablePackageTestCase`

### Key Abstracts

- **`VersionablePackage`** (`src/Services/Versioning/VersionablePackage.php`): Base class providing `getVersion()` (reads from `package.json`), `getConfig()`/`setConfig()` (prefixed Laravel config access), and `install()` (adds npm scripts to `package.json`)
- **`VersionablePackageServiceProvider`** (`src/Providers/Abstracts/VersionablePackageServiceProvider.php`): Base service provider that binds the facade, merges config from `config/config.php` relative to the provider, makes config publishable, and auto-registers the package contract
- **`VersionablePackageFacade`** (`src/Facades/Abstracts/VersionablePackageFacade.php`): Base facade resolving via `getPackagePrefix()`
- **`VersionablePackageTestCase`** (`src/Testing/VersionablePackageTestCase.php`): Base test case using Orchestra Testbench and `TestSuite` trait, auto-loads required service providers

### Services

- **`VersioningRepository`**: Reads version from a package's `package.json` file
- **`PackageJson`**: Modifies `package.json` to add versioning scripts (uses `Symfony\Component\Process\Process` with `yarn`)

### Trait: `HavingPackageClass`

Shared across providers, facades, and test cases. Requires `getPackageClass(): string` and derives the prefix from `Package::prefix()`.

## Conventions

- **Namespace**: `Henrotaym\LaravelPackageVersioning\`
- **Contract pattern**: Every service has a corresponding `Contracts/` interface, bound in the service provider
- **Config location**: Each package's config lives at `config/config.php` relative to its service provider directory
- **Versioning**: Semantic versioning via `package.json`; git tags created by `npm version`
- **Commit style**: Emoji-prefixed conventional commits (🐛 fix, ♻️ refactor, 🧑‍💻 dev, 📝 docs)
- **Testing**: PHPUnit 9.5 with Orchestra Testbench 6.0
