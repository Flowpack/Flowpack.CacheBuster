[![Latest Stable Version](https://poser.pugx.org/flowpack/cachebuster/v/stable)](https://packagist.org/packages/flowpack/cachebuster)
[![Total Downloads](https://poser.pugx.org/flowpack/cachebuster/downloads)](https://packagist.org/packages/flowpack/cachebuster)
[![License](https://poser.pugx.org/flowpack/cachebuster/license)](LICENSE)

# Flowpack.CacheBuster

Adds automatic cache busting for static resources in the frontend.

The output for those resources is modified by appending a shortened sha1 of the file like this

    /_Resources/Static/Packages/Neos.NeosIo/Styles/Main.css?bust=3e9a4e48

## Installation

    composer require flowpack/cachebuster
    
## Usage

This package provides an aspect which is automatically active 
and enabled cache busting without any further modification.

### Compatibility with mod_pagespeed

Add the following to your webserver configuration to allow pagespeed
to optimize resources with the cache bust query parameter.

#### nginx

    pagespeed Allow "*";
    
#### Apache

    ModPagespeedAllow "*"
    
Or be more specific by just allowing the `*?bust=*`.
