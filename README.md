# Vdlp.RedirectConditions.Header (extension)

This is an extension plugin for the [Redirect](https://octobercms.com/plugin/vdlp-redirect) plugin for OctoberCMS.

## Requirements

- Plugin `Vdlp.Redirect`
- Plugin `Vdlp.RedirectConditions`

## Conditions

### `HeaderCondition`

On a positive match the redirect will take place if the request matches given condition parameters.

**Condition parameters:**

* Header name (case insensitive)
* Header value (case insensitive)
* Whether to use regular expression for header value matching (see official [preg_match](http://php.net/manual/en/function.preg-match.php) documentation)

## Unit tests

To run the Unit Tests of this plugin, execute the following command from the project root: 

```
vendor/bin/phpunit plugins/vdlp/redirectconditionsheader
```

## Questions? Need help?

If you have any question about how to use this plugin, please don't hesitate to contact us at octobercms@vdlp.nl. We're happy to help you. You can also visit the support forum and drop your questions/issues there.
