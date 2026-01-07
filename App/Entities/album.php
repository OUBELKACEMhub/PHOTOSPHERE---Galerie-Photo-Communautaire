<?php

class Album {
    private int $id;
    private int $userId;
    private string $title;
    private ?string $description;
    private string $visibility; 
    private int $photoCount;
    private ?int $coverPhotoId;
    private string $createdAt;
    private ?string $updatedAt;

    public function __construct(array $data) {
        $this->id = $data['id_alb'] ?? 0;
        $this->userId = $data['user_id'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? null;
        $this->visibility = $data['visibility'] ?? 'public';
        $this->photoCount = $data['photo_count'] ?? 0;
        $this->coverPhotoId = $data['cover_photo_id'] ?? null;
        $this->createdAt = $data['created_at'] ?? date('Y-m-d H:i:s');
        $this->updatedAt = $data['updated_at'] ?? null;
    }

    public function getId(): int { return $this->id; }
    public function getUserId(): int { return $this->userId; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): ?string { return $this->description; }
    public function getVisibility(): string { return $this->visibility; }
    public function getPhotoCount(): int { return $this->photoCount; }
    public function getCoverPhotoId(): ?int { return $this->coverPhotoId; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }

    public function setTitle(string $title): void { $this->title = $title; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setVisibility(string $visibility): void { $this->visibility = $visibility; }
    public function setPhotoCount(int $count): void { $this->photoCount = $count; }
    public function setCoverPhotoId(?int $id): void { $this->coverPhotoId = $id; }
    public function setUpdatedAt(string $timestamp): void { $this->updatedAt = $timestamp; }

    public function incrementPhotoCount(): void { $this->photoCount++; }
    public function decrementPhotoCount(): void { $this->photoCount = max(0, $this->photoCount - 1); }

    public function toArray(): array {
        return [
            'id_alb' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'visibility' => $this->visibility,
            'photo_count' => $this->photoCount,
            'cover_photo_id' => $this->coverPhotoId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt
        ];
    }
}