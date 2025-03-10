<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Genre;

interface GenreRepositoryInterface
{
    public function insert(Genre $genre): Genre;
    public function findById(string $genreId): Genre;
    public function findAll(string $filter = '', string $order = 'DESC'): array;
    public function paginate(string $filter, $order = 'DESC', int $page = 1, int $perPage = 15): PaginationInterface;
    public function update(Genre $genre): Genre;
    public function delete(string $genreId): bool;
    public function toGenre(object $data): Genre;
}
