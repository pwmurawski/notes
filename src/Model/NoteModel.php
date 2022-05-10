<?php
declare(strict_types=1);

namespace App\Model;

require_once('src\Model\AbstractModel.php');
require_once('src\Model\ModelInterface.php');
require_once('src\Exception\NotFoundException.php');
require_once('src\Exception\StoargeException.php');

use PDO;
use App\Exception\StoargeException;
use App\Exception\NotFoundException;
use Throwable;

class NoteModel extends AbstractModel implements ModelInterface {
    public function list(array $page, array $sort, ?string $phrase = null): array {
        try {
            $limit = $page['size'];
            $offset = ($page['currentPage'] - 1) * $page['size'];

            if(!in_array($sort['by'], ['title', 'created'])) {
                $sort['by'] = 'created';
            }

            if(!in_array($sort['order'], ['asc', 'desc'])) {
                $sort['order'] = 'asc';
            }

            $wherePart = $this->validPhrase($phrase);

            $query = "
                    SELECT id, title, created
                    FROM notes
                    $wherePart
                    ORDER BY {$sort['by']} {$sort['order']}
                    LIMIT $offset , $limit
            ";

            $result = $this->connect->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch(Throwable $e) {
            throw new StoargeException('Nie udało sie pobrać notatek', 400, $e);
        }
    }

    public function get(int $noteId): array {
        try {
            $query = "
                SELECT id, title, description, created
                FROM notes
                WHERE id = $noteId
            ";
            
            $result = $this->connect->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch(Throwable $e) {
            throw new StoargeException('Nie udało sie pobrać notatki', 400, $e);
        }

        if(!$note) {
            throw new NotFoundException("Notatka o id: $noteId nie istnieje");
        }

        return $note;
    }

    public function create(array $data): void {
        try {
            $title = $this->connect->quote($data['title']);
            $desc = $this->connect->quote($data['description']);
            $created = $this->connect->quote(date('Y-m-d H-i-s'));

            $query = "
                INSERT INTO notes(title, description, created)
                VALUES ($title, $desc, $created)
            ";
            
            $this->connect->exec($query);
        } catch(Throwable $e) {
            throw new StoargeException('Nie udało sie utworzyć notatki', 400, $e);
        }
    }

    public function edit(int $noteId, array $newNoteData): void {
        $title = $this->connect->quote($newNoteData['title']);
        $desc = $this->connect->quote($newNoteData['description']);

        try {
            $query = "
                UPDATE notes
                SET title = $title, description = $desc
                WHERE id = $noteId
            ";
            
            $this->connect->exec($query);
        } catch(Throwable $e) {
            throw new StoargeException('Nie udało sie edytowac notatki', 400, $e);
        }
    }

    public function delete(int $noteId): void {
        try {
            $query = "
                DELETE FROM notes
                WHERE id = $noteId
                LIMIT 1
            ";
            
            $this->connect->exec($query);
        } catch(Throwable $e) {
            dump($e);
            throw new StoargeException('Nie udało sie usunac notatki', 400, $e);
        }
    }

    public function count(?string $phrase = null): int {
        try {
            $wherePart = $this->validPhrase($phrase);

            $query = "
                SELECT count(*) AS cn
                FROM notes
                $wherePart
            ";

            $result = $this->connect->query($query);
            $result =  $result->fetch(PDO::FETCH_ASSOC);
            if(!$result) {
                throw new StoargeException('Nie udało sie pobrać informacij o ilosci notatek', 400);
            }
            return (int) $result['cn'];
        } catch(Throwable $e) {
            throw new StoargeException('Nie udało sie pobrać informacij o ilosci notatek', 400, $e);
        }
    }

    private function validPhrase($phrase): ?string {
        if($phrase) {
            $phrase = $this->connect->quote('%' . $phrase . '%');
            $wherePart = "WHERE title LIKE ($phrase)";
        }

        return $wherePart ?? null;
    }
}