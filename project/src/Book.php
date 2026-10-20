<?php

class Book
{
    public function __construct(
        public int $id,
        public string $title,
        public string $author,
        public int $year,
        public string $genre
    ) {
    }

    /** Bookオブジェクトを、表示やJSON化に使いやすい配列へ変換します。 */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'year' => $this->year,
            'genre' => $this->genre,
        ];
    }
}
