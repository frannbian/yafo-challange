<?php

namespace App\Dtos;

class CMDBDto
{
    /**
     * Construct
     *
     * @return void
     */
    public function __construct(
        public string $identificator,
        public string $name,
        public string $category_id,
        public ?array $optionalFields,
    ) {
        //
    }
}
