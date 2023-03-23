<?php

function insertReview($invId, $clientId, $reviewText){
    $db = phpmotorsConnect();
  
    $sql = 'INSERT INTO reviews (reviewText, invId, clientId)
        VALUES (:reviewText, :invId, :clientId)';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;   

}

function getReviewByInvId($invId){
    $db = phpmotorsConnect();

    $sql = "SELECT * FROM reviews INNER JOIN clients 
            ON reviews.clientId = clients.clientId
            WHERE clientFirstname IN 
            (SELECT clientFirstname FROM clients WHERE invId = :invId)
            ORDER BY reviewDate DESC"; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviews; 
}
    
function getReviewByClientId($clientId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews 
        WHERE clientId = :clientId ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

function getReview($reviewId){
    $db = phpmotorsConnect();
    $sql = 'SELECT reviewText, invId, clientId FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $revInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $revInfo;
}

function updateReview($reviewId, $reviewText, $clientId, $invId){
    
    $db = phpmotorsConnect();

    $sql = 'UPDATE reviews SET invId = :invId, reviewText = :reviewText, 
	clientId = :clientId
    WHERE reviewId = :reviewId';

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function deleteReview($reviewId){
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

?>