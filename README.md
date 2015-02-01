# zero-constructor
Runtime customizable constructor

For lazy people ._.

## Usage
```php
class myclass extends \zero\constructor{
    public function construct(){
        $this->extend([
            'var' => 'value',
            'func' => function(){
                return $this->var;
            }
        ]);
    }
}
```

```php
$m = new myclass([
    'var' => 'value2'
]);
var_dump($m->func());
// string(6) "value2"
```
## Dependencies
PHP >= 5.4

## License
MIT
