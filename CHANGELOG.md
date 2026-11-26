# Release Notes for Content Field

## Unreleased

### Changed
- The `ckeditor` field type now requires `craftcms/ckeditor` 5.10 or later.
- CKEditor configs are now stored in `config/content/cke`, `ckeConfig` references them by their file name.

### Added
- Legacy CKEditor configs are exported to `config/content/cke` automatically when `craftcms/ckeditor` 5 removes them from the project config.
- Added the `contentfield/cke/check` command, use `--fix` to replace legacy uid references with config names.
- Added the `contentfield/cke/export` command to export legacy CKEditor configs manually.
- `ckeConfig` now accepts an inline config.

### Fixed
- Macros of inlined templates sharing a name (e.g. two element templates both declaring `results`) no longer overwrite each other, calls like `_self.results()` invoked the macro of another template.

### Deprecated
- Referencing CKEditor configs by their uid. See the upgrade guide in `docs/fields/ckeditor.md`.

## 1.0.0 - YYYY-MM-DD
Initial release
