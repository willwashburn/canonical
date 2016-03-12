# Canonical :church: [![Travis](https://img.shields.io/travis/willwashburn/canonical.svg)](https://travis-ci.org/willwashburn/canonical) [![Packagist](https://img.shields.io/packagist/dt/willwashburn/canonical.svg)](https://packagist.org/packages/willwashburn/canonical) [![Packagist](https://img.shields.io/packagist/v/willwashburn/canonical.svg)](https://packagist.org/packages/willwashburn/canonical)
Return the canonical url from a string of html

# Usage
 ```PHP
 $canonical = new \WillWashburn\Canonical;
 
 // using some string of html fetched via curl or file get contents or carrier pigeon
 $html = file_get_contents('website.html');

 $canonical->url($html);
 //// http://www.yourlink.com

```

# Installation
Use composer

```composer require willwashburn/canonical```

Alternatively, add ```"willwashburn/canonical": "~1.0.1"``` to your composer.json

## Change Log
- v1.0.1 - Clear crawler before use
- v1.0.0 - Basic tag finding for og:link and link rel=canonical using symfony dom crawler
