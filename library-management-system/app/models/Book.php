<?php
// app/models/Book.php
class Book {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function getAllBooks($limit = null, $offset = 0) {
        try {
            $sql = "SELECT * FROM books ORDER BY title";
            
            if ($limit) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            
            $stmt = $this->pdo->prepare($sql);
            
            if ($limit) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching books: " . $e->getMessage());
            return [];
        }
    }
    
    public function getBookById($id) {
        try {
            $sql = "SELECT * FROM books WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching book: " . $e->getMessage());
            return false;
        }
    }
    
    public function createBook($data) {
        try {
            $sql = "INSERT INTO books (isbn, title, author, category, publisher, publication_year, total_copies, available_copies, location) 
                    VALUES (:isbn, :title, :author, :category, :publisher, :publication_year, :total_copies, :available_copies, :location)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'isbn' => $data['isbn'],
                'title' => $data['title'],
                'author' => $data['author'],
                'category' => $data['category'] ?? null,
                'publisher' => $data['publisher'] ?? null,
                'publication_year' => $data['publication_year'] ?? null,
                'total_copies' => $data['total_copies'] ?? 1,
                'available_copies' => $data['available_copies'] ?? 1,
                'location' => $data['location'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log("Error creating book: " . $e->getMessage());
            return false;
        }
    }
    
    public function updateBook($id, $data) {
        try {
            $sql = "UPDATE books SET 
                    isbn = :isbn,
                    title = :title,
                    author = :author,
                    category = :category,
                    publisher = :publisher,
                    publication_year = :publication_year,
                    total_copies = :total_copies,
                    available_copies = :available_copies,
                    location = :location
                    WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'isbn' => $data['isbn'],
                'title' => $data['title'],
                'author' => $data['author'],
                'category' => $data['category'],
                'publisher' => $data['publisher'],
                'publication_year' => $data['publication_year'],
                'total_copies' => $data['total_copies'],
                'available_copies' => $data['available_copies'],
                'location' => $data['location']
            ]);
        } catch (PDOException $e) {
            error_log("Error updating book: " . $e->getMessage());
            return false;
        }
    }
    
    public function deleteBook($id) {
        try {
            $sql = "DELETE FROM books WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log("Error deleting book: " . $e->getMessage());
            return false;
        }
    }
    
    public function searchBooks($searchTerm) {
        try {
            $sql = "SELECT * FROM books 
                    WHERE title LIKE :search 
                    OR author LIKE :search 
                    OR isbn LIKE :search 
                    OR category LIKE :search
                    ORDER BY title";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['search' => "%$searchTerm%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching books: " . $e->getMessage());
            return [];
        }
    }
    
    public function getBookStats() {
        try {
            $stats = [];
            
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM books");
            $stats['total'] = $stmt->fetchColumn();
            
            $stmt = $this->pdo->query("SELECT SUM(total_copies) FROM books");
            $stats['total_copies'] = $stmt->fetchColumn() ?: 0;
            
            $stmt = $this->pdo->query("SELECT SUM(available_copies) FROM books");
            $stats['available_copies'] = $stmt->fetchColumn() ?: 0;
            
            $stats['borrowed_copies'] = $stats['total_copies'] - $stats['available_copies'];
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Error getting book stats: " . $e->getMessage());
            return [];
        }
    }
}
?>
