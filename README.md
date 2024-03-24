# phppiggy
php learning project

run php cmd script example =>
composer run-script phppiggy


### PHPStan
level 0 by deafault
```bash
vendor/bin/phpstan analyze src 
```
level 8
```bash
vendor/bin/phpstan analyze -l 8 src
``` 

level 8 + write results to file
```bash
vendor/bin/phpstan analyze -l 8 src > result.txt
```

level 8 + write results to file formatted in pretty json (table is default)
```bash
vendor/bin/phpstan analyze -l 8 --error-format=prettyJson src > result.txt
```