<?php

namespace MedCore\Nk0262021Parser\Dto;

use Countable;
use IteratorAggregate;

class InterventionCollection implements IteratorAggregate, Countable
{
    /**
     * @var Intervention[]
     */
    private array $interventions = [];

    public function add(Intervention $intervention) : void
    {
        $this->interventions[] = $intervention;
    }

    public function getIterator() : \ArrayIterator
    {
        return new \ArrayIterator($this->interventions);
    }

    public function count() : int
    {
        return count($this->interventions);
    }

    public function findByCode(string $code) : ?Intervention
    {
        foreach ($this->interventions as $intervention) {
            if ($intervention->code === $code) {
                return $intervention;
            }
        }

        return null;
    }

    public function findByClassName(string $class_name) : InterventionCollection
    {
        $results = new self();
        foreach ($this->interventions as $intervention) {
            if (false !== stripos($intervention->class_name, $class_name)) {
                $results->add($intervention);
            }
        }

        return $results;
    }

    public function findByAnatomicalSite(string $anatomical_site) : InterventionCollection
    {
        $results = new self();
        foreach ($this->interventions as $intervention) {
            if (false !== stripos($intervention->anatomical_site_name, $anatomical_site)) {
                $results->add($intervention);
            }
        }

        return $results;
    }

    public function findByProcedureType(string $procedure_type) : InterventionCollection
    {
        $results = new self();
        foreach ($this->interventions as $intervention) {
            if (false !== stripos($intervention->procedure_type_name, $procedure_type)) {
                $results->add($intervention);
            }
        }

        return $results;
    }

    public function findByProcedureGroup(string $procedure_group) : InterventionCollection
    {
        $results = new self();
        foreach ($this->interventions as $intervention) {
            if (false !== stripos($intervention->procedure_group_name, $procedure_group)) {
                $results->add($intervention);
            }
        }

        return $results;
    }

    public function searchByName(string $query) : InterventionCollection
    {
        $results = new self();
        foreach ($this->interventions as $intervention) {
            if (
                false !== stripos($intervention->name_ua, $query) ||
                false !== stripos($intervention->name_en, $query) ||
                false !== stripos($intervention->procedure_group_name, $query)
            ) {
                $results->add($intervention);
            }
        }

        return $results;
    }
}
