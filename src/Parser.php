<?php

namespace ChernegaSergiy\Nk0262021Parser;

use ChernegaSergiy\Nk0262021Parser\Dto\Intervention;
use ChernegaSergiy\Nk0262021Parser\Dto\InterventionCollection;

class Parser
{
    private const DATA_URL = 'https://meddata.pp.ua/data/classifications/nk-026-2021.json';

    private ?InterventionCollection $collection = null;

    /**
     * Fetches and parses the NK-026-2021 data.
     *
     * @return InterventionCollection The parsed data as a collection of Intervention objects.
     * @throws \Exception If the data cannot be fetched or parsed.
     */
    public function parse(): InterventionCollection
    {
        if ($this->collection) {
            return $this->collection;
        }

        $json = @file_get_contents(self::DATA_URL);

        if ($json === false) {
            throw new \Exception("Failed to fetch data from " . self::DATA_URL);
        }

        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Failed to parse JSON: " . json_last_error_msg());
        }

        $this->collection = new InterventionCollection();

        foreach ($data['data'] as $row) {
            $this->collection->add(new Intervention(
                class_code: $row[0] ?? '',
                class_name: $row[1] ?? '',
                anatomical_site_code: (int)($row[2] ?? 0),
                anatomical_site_name: $row[3] ?? '',
                procedure_type_code: (int)($row[4] ?? 0),
                procedure_type_name: $row[5] ?? '',
                procedure_group_code: (int)($row[6] ?? 0),
                procedure_group_name: $row[7] ?? '',
                code: $row[8] ?? '',
                name_ua: $row[9] ?? '',
                name_en: $row[10] ?? '',
            ));
        }

        return $this->collection;
    }

    public function findByCode(string $code): ?Intervention
    {
        return $this->parse()->findByCode($code);
    }

    public function findByClassName(string $class_name): InterventionCollection
    {
        return $this->parse()->findByClassName($class_name);
    }

    public function findByAnatomicalSite(string $anatomical_site): InterventionCollection
    {
        return $this->parse()->findByAnatomicalSite($anatomical_site);
    }

    public function findByProcedureType(string $procedure_type): InterventionCollection
    {
        return $this->parse()->findByProcedureType($procedure_type);
    }

    public function findByProcedureGroup(string $procedure_group): InterventionCollection
    {
        return $this->parse()->findByProcedureGroup($procedure_group);
    }

    public function searchByName(string $query): InterventionCollection
    {
        return $this->parse()->searchByName($query);
    }
}
