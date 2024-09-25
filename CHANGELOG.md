# Changelog

## [6.0.0]

Changed
- [BC Break] Doctrine Annotations are no longer used in this project. Annotations have been replaced by PHP attributes. If your codebase or any third-party dependencies still rely on annotations, please migrate to attributes or adjust accordingly.
- [BC Break] The project now requires PHP 8.2 or higher. Ensure that your development and production environments are updated to PHP 8.2+.
- [BC Break] The project now requires PHPUnit version 11 or higher. Ensure that your environment is compatible with PHPUnit 11+ before running tests.
- [BC Break] All classes previously marked with @deprecated and replaced by {@link Laminas} have been removed. If your code still relies on these deprecated classes, please update your references to use the corresponding Laminas classes.

- Add squizlabs/php_codesniffer library.
- Add require-dev ext-pcov for PHPUnit Code Coverage
- PHPCS Coding Standard: The project now exclusively uses PSR-12 as the coding standard. This change ensures that the code adheres to the PSR-12 guidelines, promoting consistency and readability.
- Updated the laminas/laminas-filter bundle from version ^2.9 to ^2.37
- Remove the laminas/laminas-zendframework-bridge bundle.
- Remove the dms/coding-standard bundle.


From v3.0.0 onwards this file will always be updated with notable changes and BC breaks.
This project follows semver.

## [3.0.0] - 2016-02-28
### Changed
- Int, Float and Boolean filters and annotations get `Scalar` suffix to not clash with reserved words

### Fixed
- The use of `self` in `RegExp` filter was returning the original value not the new updated one, this seems to be a change in PHP, so we now use `static` which makes it more friendly to extensions.
