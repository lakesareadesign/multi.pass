# Pot Similarity
[![Build Status](https://travis-ci.org/pentatonicfunk/pot-similarity.svg?branch=master)](https://travis-ci.org/pentatonicfunk/pot-similarity) 
[![Code Coverage](https://codecov.io/gh/pentatonicfunk/pot-similarity/branch/master/graph/badge.svg)](https://codecov.io/gh/pentatonicfunk/pot-similarity)

Feeling too much string to translate ? do pre-scan with this.

## Current Limitation
- Not handling any `context`, if you use `__x()` on WordPress, take extra care on the results
- Not handling any `plural`, if you use `__n()` on Wordpress, take extra care on the results

## Installation
    # Globally
    $ composer global require pentatonicfunk/pot-similarity:dev-master

    # In your project
    $ composer require --dev pentatonicfunk/pot-similarity:dev-master
    
## Usage

    # Globally
    $ export PATH=~/.composer/vendor/bin:$PATH
    $ pot-similarity find:similar /mnt/e/wsl/wpmudev-ms/wp-content/plugins/forminator/languages/forminator.pot 96
    
    # In your project
    $ ./vendor/bin/ pot-similarity find:similar /mnt/e/wsl/wpmudev-ms/wp-content/plugins/forminator/languages/forminator.pot 96

### Arguments

    - pot_path              Path of the pot file
    - threshold_percentage  Thresehold Percentage of similar text [default: 70]
    
## Troubleshoot

### Memory limit
    increase memory limit
