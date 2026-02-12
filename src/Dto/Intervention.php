<?php

namespace MedCore\Nk0262021Parser\Dto;

class Intervention
{
    public function __construct(
        public readonly string $class_code,
        public readonly string $class_name,
        public readonly int $anatomical_site_code,
        public readonly string $anatomical_site_name,
        public readonly int $procedure_type_code,
        public readonly string $procedure_type_name,
        public readonly int $procedure_group_code,
        public readonly string $procedure_group_name,
        public readonly string $code,
        public readonly string $name_ua,
        public readonly string $name_en,
    ) {
    }
}
