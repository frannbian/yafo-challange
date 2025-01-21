<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CMDBExport implements FromCollection, WithHeadings
{
    private Collection $collection;
    private array $headers;

    public function __construct(Collection $collection, array $headers)
    {
        $this->collection = $collection;
        $this->headers = $headers;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return $this->headers;
    }
}
