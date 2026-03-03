# Pretty Print for PHP
This small library is a handy utility for pretty printing a wide variety of PHP values as strings.

## Installation
```
composer require 1tomany/pretty-print
```

## Usage
```php

use function OneToMany\PrettyPrint\pretty_print;

var_dump(pretty_print(null)); // string(4) "null"
var_dump(pretty_print(true)); // string(4) "true"
var_dump(pretty_print(false)); // string(4) "false"
var_dump(pretty_print(0)); // string(1) "0"
var_dump(pretty_print(1.0)); // string(3) "1.0"
var_dump(pretty_print(\M_PI)); // string(15) "3.1415926535898"
var_dump(pretty_print('PHP')); // string(5) ""PHP""
var_dump(pretty_print([])); // string(2) "[]"
var_dump(pretty_print(['A', 'B'])); // string(10) "["A", "B"]"
var_dump(pretty_print(['name' => 'Vic'])); // string(15) "[name => "Vic"]"
var_dump(pretty_print(new \DateTimeImmutable())); // string(25) "2026-03-03T17:36:40+00:00"
var_dump(pretty_print('This string is longer than 32 characters so it is truncated.', 32)); // string(37) ""This string is longer than 32 ch...""
var_dump(pretty_print(\fopen('file.txt', 'r'))); // string(7) "unknown"
```

## Credits
- [Vic Cherubini](https://github.com/viccherubini), [1:N Labs, LLC](https://1tomany.com)

## License
The MIT License
