<?php
 declare(strict_types=1);


require_once __DIR__ . "/../../config/Core/Database.php";
require_once __DIR__ . "/../Entities/comment.php";


trait CommentableTrait {


    public function addComment(string $content, int $userId): bool {
        try {
            $pdo = Database::getConnection();

            $data = [
                'content'   => $content,
                'userId'    => $userId,
                'photoId'   => $this->id, 
                'isArchive' => false
            ];

            $comment = new Comment($data);
            $commentData = $comment->toArray();

      
            $sql = "INSERT INTO comments (content, user_id, photo_id, is_archive, created_at) 
                    VALUES (:content, :userId, :photoId, :isArchive, NOW())";
            
            $stmt = $pdo->prepare($sql);
            
            return $stmt->execute([
                ':content'   => $commentData['content'],
                ':userId'    => $commentData['userId'],
                ':photoId'   => $commentData['photoId'],
                ':isArchive' => $commentData['isArchive'] ? 1 : 0
            ]);

        } catch (PDOException $e) {
            error_log("Erreur addComment: " . $e->getMessage());
            return false;
        }
    }

   
    public function removeComment(int $commentId): bool {
        try {
            $pdo = Database::getConnection();
            $sql = "DELETE FROM comments WHERE id = :id AND photo_id = :currentPhotoId";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':id'             => $commentId,
                ':currentPhotoId' => $this->id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getComments(): array {
        try {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM comments WHERE photo_id = :photoId AND is_archive = 0 ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':photoId' => $this->id]);
            
            $comments = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data = [
                    'id'        => (int)$row['id'],
                    'content'   => $row['content'],
                    'isArchive' => (bool)$row['is_archive'],
                    'createdAt' => $row['created_at'],
                    'userId'    => (int)$row['user_id'],
                    'photoId'   => (int)$row['photo_id']
                ];
                $comments[] = new Comment($data);
            }
            return $comments;
        } catch (PDOException $e) {
            return [];
        }
    }

    
    public function getCommentCount(): int {
        try {
            $pdo = Database::getConnection();
            $sql = "SELECT COUNT(*) FROM comments WHERE photo_id = :photoId AND is_archive = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':photoId' => $this->id]);
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

}