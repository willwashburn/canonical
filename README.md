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

Alternatively, add ```"willwashburn/canonical": "~2.0"``` to your composer.json

## Change Log
- v2.0.0 - Parse http-refresh tags; New namespace; New return object
- v1.2.1 - Favor canonical tag over og:url tag
- v1.2.0 - Remove utm params and hash anchors
- v1.1.0 - Search for twitter:url meta tags if no others are found
- v1.0.2 - Fix support for php 5.4
- v1.0.1 - Clear crawler before use
- v1.0.0 - Basic tag finding for og:link and link rel=canonical using symfony dom crawler
