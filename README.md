# PHPyh Validator
[«Валидатор сына маминой подруги», — Роман Пронский.](https://youtu.be/liMyAuxIoyM?t=5491)

![alt text](refactoring.jpg)

```php
namespace PHPyh\Validator;

$validator = new Validator(
    new RuleHandlerRegistry\InMemoryRuleHandlerRegistry([
        new Rule\AllHandler(),
        new Rule\AnyHandler(),
        new Rule\ObjectPropertiesHandler(),
        new Rule\GreaterThanHandler(),
    ])
);

final class SomeDto
{
    public int $age = 10;
    public int $height = 130;
}

$errors = $validator->validate(
    new SomeDto(),
    new Rule\Any([
        new Rule\ObjectProperties([
            'age' => new Rule\GreaterThan(18),
            'height' => new Rule\GreaterThan(150),
        ])
    ])
);
```

## References
- [My explanations of the architecture in Russian](https://youtu.be/liMyAuxIoyM?t=4308)
