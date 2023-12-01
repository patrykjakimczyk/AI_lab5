<?php
namespace App\Model;

use App\Service\Config;

class Announcement
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Announcement
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Announcement
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Announcement
    {
        $this->description = $description;

        return $this;
    }

    public static function fromArray($array): Announcement
    {
        $post = new self();
        $post->fill($array);

        return $post;
    }

    public function fill($array): Announcement
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['description'])) {
            $this->setDescription($array['description']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM announcement';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $announcements = [];
        $announcementsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($announcementsArray as $announcementArray) {
            $announcements[] = self::fromArray($announcementArray);
        }

        return $announcements;
    }

    public static function find($id): ?Announcement
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM announcement WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $announcementArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $announcementArray) {
            return null;
        }

        return Announcement::fromArray($announcementArray);
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getId()) {
            $sql = "INSERT INTO announcement (title, description) VALUES (:title, :description)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE announcement SET title = :title, description = :description WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                ':id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM announcement WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setTitle(null);
        $this->setDescription(null);
    }
}
