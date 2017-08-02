# Flowpack.CacheBuster

Adds automatic cache busting for static resources in the frontend.

The output for those resources is modified by appending a shortened sha1 of the file like this

    /_Resources/Static/Packages/Neos.NeosIo/Styles/Main.css?bust=3e9a4e48

## Installation

    composer require flowpack/cachebuster
    
## Usage

This package provides an aspect which is automatically active 
and enabled cache busting without any further modification.
