## vX

This version's changes are mostly in order to make this library PHP 7 compatible.

BC:
- Int, Float and Boolean filters and annotations get `Scalar` suffix to not clash with reserved words

Internal:
- The use of `self` in `RegExp` filter was returning the original value not the new updated one, this seems to be a change in PHP, so we now use `static` which makes it more friendly to extensions.
