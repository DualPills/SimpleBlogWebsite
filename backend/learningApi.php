<?php
    require_once 'config.php';

    //Lấy tất cả các phương thức Request HTTP (GET, POST, PUT, DELETE)
    $method = $_SERVER['REQUEST_METHOD']; 
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

    //Grab endpoint from the request
    $endpoint= array_shift($request);
    

    switch ($method) {
        case 'GET':
            // nếu chỉ articles/ (tức không có id)
            if(empty($request[0])){
                
                $result = $db->query('SELECT * FROM articles ORDER BY created_at DESC');
                $articles = [];
                while($row = $result->fetchArray(SQLITE3_ASSOC)){
                    $articles[]=$row;
                }
                echo json_encode($articles);
            }
            else{
                // nếu có id
                $id = (int)$request[0];
                try {
                    $stmt = $db->prepare('SELECT * FROM articles WHERE id = :id');
                    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
                    $result = $stmt->execute();
                } catch (Exception $e) {
                    http_response_code(404); // Not Found
                    echo json_encode(['error' => 'Article not found']);
                    exit;
                }
                echo json_encode($result->fetchArray(SQLITE3_ASSOC));
            }
            break;
        
        case 'POST':
            if(empty($request[0])){
                $data = json_decode(file_get_contents('php://input'), true);
                
                
                $stmt = $db->prepare('INSERT INTO articles (title, content) VALUES (:title, :content)');
                $stmt->bindValue(':title', $data['title'], SQLITE3_TEXT);
                $stmt->bindValue(':content', $data['content'], SQLITE3_TEXT);
                $stmt->execute();

                echo json_encode(['id' => $db->lastInsertRowID()]);
            }
            break;
        case 'PUT':
            if(empty($request[0])){
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID is required for update']);
                exit;
            }else{
                $id = (int)$request[0];
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $db->prepare('UPDATE articles SET title= :title, content = :content WHERE id= :id');
                $stmt->bindValue(':title', $data['title'], SQLITE3_TEXT );
                $stmt->bindValue(':content', $data['content'], SQLITE3_TEXT);
                $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
                $stmt->execute();
                echo json_encode([ 'success' => true, 'id' => $id ,'title' => $data['title'], 'content' => $data['content'] ]);
            }
            break;
        
        case 'DELETE':
            if(empty($request[0])){
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID is required for deletion']);
                exit;
            }else{
                $id = (int)$request[0];
                try{
                    $stmt=$db->prepare('DELETE FROM articles WHERE id=:id');
                    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
                    $stmt->execute();
                    http_response_code(204); // No Content
                }
                catch(Exception $e){
                    http_response_code(404); // Not Found
                    echo json_encode(['error' => 'Article not found. Cant find the article with the given ID to delete']);
                    exit;
                }

            }
            break;
        
        default:
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method not allowed']);
            break;
        
    }


?>