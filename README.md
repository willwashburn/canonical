# Canonical :church: [![Travis](https://img.shields.io/travis/willwashburn/canonical.svg)](https://travis-ci.org/willwashburn/canonical) [![Packagist](https://img.shields.io/packagist/dt/willwashburn/canonical.svg)](https://packagist.org/packages/willwashburn/canonical) [![Packagist](https://img.shields.io/packagist/v/willwashburn/canonical.svg)](https://packagist.org/packages/willwashburn/canonical) [![MIT License](https://img.shields.io/packagist/l/willwashburn/canonical.svg?style=flat-square)](https://github.com/willwashburn/canonical/blob/master/LICENSE)
Return the canonical url from a string of html

## Usage
 ```PHP
 $canonical = new \Canonical\Canonical;
 
 // using some string of html fetched via curl or file get contents or carrier pigeon
 $html = file_get_contents('website.html');

 $canonical->url($html);
 //// http://www.yourlink.com
```

## Installation
Use composer

```composer require willwashburn/canonical```

Alternatively, add ```"willwashburn/canonical": "~3.1"``` to your composer.json

## Change Log
- v3.1.3 - Improve regex to match `window.location =`
- v3.1.2 - Loosen dom crawler class requirements
- v3.1.1 - Remove Javascript redirects from default extractors
- v3.1.0 - Use more consistent naming for extractor class; drop nightly support
- v3.0.0 - Parse Javascript redirects similar to http-refresh tags 
- v2.1.1 - Fix bug when calling same html twice with same instance of canonical
- v2.1.0 - Allow accessing url with utm params and hash anchors in return object
- v2.0.0 - Parse http-refresh tags; New namespace; New return object
- v1.2.1 - Favor canonical tag over og:url tag
- v1.2.0 - Remove utm params and hash anchors
- v1.1.0 - Search for twitter:url meta tags if no others are found
- v1.0.2 - Fix support for php 5.4
- v1.0.1 - Clear crawler before use
- v1.0.0 - Basic tag finding for og:link and link rel=canonical using symfony dom crawler
