<?php
declare(strict_types=1);

namespace App\Model;

interface ModelInterface {
    public function list(
        array $page,
        array $sort,
        ?string $phrase = null
    ): array;

    public function get(int $id): array;

    public function create(array $data): void;

    public function edit(int $id, array $newData): void;

    public function delete(int $id): void;

    public function count(?string $phrase = null): int;
}