# Changelog

All notable changes to `laravel-custom-fields` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-06-03
### Added
- Initial release.
- Support for 20 field types (`text`, `textarea`, `number`, `email`, `password`, `select`, `checkbox`, `radio`, `boolean`, `date`, `datetime`, `time`, `url`, `color`, `range`, `file`, `image`, `repeater`, `json`, `wysiwyg`).
- ACF-style global helpers `get_custom_field()` and `has_custom_field()`.
- Blade directive `@customFields($model)` for automatic form rendering.
- File upload processing and metadata storage via `FileField`.
- Caching layer for extreme performance.
- Event dispatching (`FieldGroupCreated`, `FieldValueSaving`, `FieldValueSaved`).
- Built-in API endpoints for headless applications.
