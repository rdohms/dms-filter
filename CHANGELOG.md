# Changelog

From v3.0.0 onwards this file will always be updated with notable changes and BC breaks.
This project follows semver.

## [3.0.0] - 2016-02-28
### Changed
- Int, Float and Boolean filters and annotations get `Scalar` suffix to not clash with reserved words

### Fixed
- The use of `self` in `RegExp` filter was returning the original value not the new updated one, this seems to be a change in PHP, so we now use `static` which makes it more friendly to extensions.
