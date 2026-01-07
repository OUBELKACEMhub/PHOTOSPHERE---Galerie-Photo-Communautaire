<?php
 class TagRepository{



   
    public function getPopularTags($limit=50){ 
   try {
            $pdo = Database::getConnection();
            $sql = "SELECT * FROM tags ORDER BY photoCount  DESC LIMIT =:limite";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['limite'=>$limit]);
            $Mytags = $stmt->fetchAll(PDO::FETCH_ASSOC);
           }catch (PDOException $e) {
            die("Erreur SQL : " . $e->getMessage());
        } 
     return $Mytags?: null;
    }


   public function searchTags(string $query, int $limit = 20): array 
{
    try {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM tags 
                WHERE name LIKE :query 
                ORDER BY count DESC 
                LIMIT :limit";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':query', $query . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erreur SQL : " . $e->getMessage());
        return [];
    }
}


 
public function getPhotoByTag(string $tagname, int $npage = 1, int $perpage = 30): array 
{
    try {
        $pdo = Database::getConnection();

        $offset = ($npage - 1) * $perpage;

        $sql = "SELECT p.* FROM postes p
                JOIN photo_tags pt ON p.id = pt.photo_id
                JOIN tags t ON pt.tag_id = t.id
                WHERE t.name = :tagname
                ORDER BY p.created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':tagname', $tagname, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $perpage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erreur getPhotoByTag : " . $e->getMessage());
        return [];
    }
}


public function getTagStats(string $tagName): ?array
{
    try {
        $pdo = Database::getConnection();
        $sql = "SELECT  t.id,  t.name,  t.usage_count, COUNT(pt.photo_id) as real_photo_count, MAX(p.created_at) as last_used
                FROM tags t
                LEFT JOIN photo_tags pt ON t.id = pt.tag_id
                LEFT JOIN photos p ON pt.photo_id = p.id
                WHERE t.name = :name
                GROUP BY t.id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $tagName]);
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);

        return $stats ?: null;

    } catch (PDOException $e) {
        error_log("Erreur getTagStats : " . $e->getMessage());
        return null;
    }
}

    public function mergeTags($formTag,$toTag):bool{
        
    }

 }
