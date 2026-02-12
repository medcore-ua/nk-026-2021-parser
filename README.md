# NK-026-2021 Parser

[![Latest Stable Version](https://img.shields.io/packagist/v/medcore-ua/nk-026-2021-parser.svg?label=Packagist&logo=packagist)](https://packagist.org/packages/medcore-ua/nk-026-2021-parser)
[![Total Downloads](https://img.shields.io/packagist/dt/medcore-ua/nk-026-2021-parser.svg?label=Downloads&logo=packagist)](https://packagist.org/packages/medcore-ua/nk-026-2021-parser)
[![License](https://img.shields.io/packagist/l/medcore-ua/nk-026-2021-parser.svg?label=Licence&logo=open-source-initiative)](https://packagist.org/packages/medcore-ua/nk-026-2021-parser)

A PHP library to parse the NK-026-2021 (Classifier of Medical Interventions) from [meddata.pp.ua](https://meddata.pp.ua/data/classifications/nk-026-2021.json).

## Installation

You can install the package via Composer:

```bash
composer require chernegasergiy/nk-026-2021-parser
```

## Usage

The `parse()` method returns an `InterventionCollection` object which you can iterate over, or use the finder methods to search for specific interventions.

### Basic Usage

```php
<?php

require 'vendor/autoload.php';

use ChernegaSergiy\Nk0262021Parser\Parser;

$parser = new Parser();

try {
    $interventions = $parser->parse();

    // Iterate over all interventions
    foreach ($interventions as $intervention) {
        echo $intervention->name_ua . PHP_EOL;
    }

    // Get the total count
    echo "Total interventions: " . count($interventions) . PHP_EOL;

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

### Finding an Intervention

You can find an intervention by its code.

```php
<?php

// ...

$intervention = $parser->findByCode('40803-00');
if ($intervention) {
    echo $intervention->name_ua; // Внутрішньочерепна стереотаксична локалізація
    echo $intervention->class_name; // ПРОЦЕДУРИ НА НЕРВОВІЙ СИСТЕМІ
    echo $intervention->anatomical_site_name; // ЧЕРЕП, ОБОЛОНКИ МОЗКУ ТА ГОЛОВНИЙ МОЗОК
}
```

### Searching for Interventions

You can search for interventions by name (in either Ukrainian or English).

```php
<?php

// ...

$results = $parser->searchByName('стереотаксична');

foreach ($results as $result) {
    echo $result->code . ': ' . $result->name_ua . PHP_EOL;
}
```

### Filtering by Class, Anatomical Site, Procedure Type or Group

You can filter interventions by various criteria.

```php
<?php

// ...

// Find by class name
$nervous_system = $parser->findByClassName('НЕРВОВІЙ СИСТЕМІ');

foreach ($nervous_system as $intervention) {
    echo $intervention->code . ': ' . $intervention->name_ua . PHP_EOL;
}

// Find by anatomical site
$skull = $parser->findByAnatomicalSite('ЧЕРЕП');

foreach ($skull as $intervention) {
    echo $intervention->code . ': ' . $intervention->name_ua . PHP_EOL;
}

// Find by procedure type
$examinations = $parser->findByProcedureType('ОБСТЕЖЕННЯ');

foreach ($examinations as $intervention) {
    echo $intervention->code . ': ' . $intervention->name_ua . PHP_EOL;
}

// Find by procedure group
$localization = $parser->findByProcedureGroup('Обстеження черепа');

foreach ($localization as $intervention) {
    echo $intervention->code . ': ' . $intervention->name_ua . PHP_EOL;
}
```

## Data Structure

Each `Intervention` object contains:

- `class_code` - Class code (e.g., "Клас 1")
- `class_name` - Class name (e.g., "ПРОЦЕДУРИ НА НЕРВОВІЙ СИСТЕМІ")
- `anatomical_site_code` - Anatomical site code (integer)
- `anatomical_site_name` - Anatomical site name
- `procedure_type_code` - Procedure type code (integer)
- `procedure_type_name` - Procedure type name
- `procedure_group_code` - Procedure group code (integer)
- `procedure_group_name` - Procedure group name
- `code` - Intervention code (e.g., "40803-00")
- `name_ua` - Ukrainian name
- `name_en` - English name

## Contributing

Contributions are welcome and appreciated! Here's how you can contribute:

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

Please make sure to update tests as appropriate and adhere to the existing coding style.

## License

This library is licensed under the CSSM Unlimited License v2.0 (CSSM-ULv2). See the [LICENSE](LICENSE) file for details.
