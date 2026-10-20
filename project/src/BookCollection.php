<?php

require_once __DIR__ . '/Book.php';

class BookCollection
{
    /** @var Book[] */
    private array $books = [];

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    /** @return array<int, array{id:int,title:string,author:string,year:int,genre:string}> */
    public function getAllBooks(): array
    {
        return array_map(
            static fn (Book $book): array => $book->toArray(),
            $this->books
        );
    }

    public function findById(int $id): ?Book
    {
        foreach ($this->books as $book) {
            if ($book->id === $id) {
                return $book;
            }
        }

        return null;
    }

    public function count(): int
    {
        return count($this->books);
    }
}
