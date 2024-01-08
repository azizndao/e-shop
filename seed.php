<?php

$database = new PDO(
    "mysql:host=localhost:3306;dbname=eshop;",
    "abdou",
    "aziz",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
    ]
);

// Initialize curl session
// $ch = curl_init();


// // Set options
// curl_setopt($ch, CURLOPT_URL, "https://api.escuelajs.co/api/v1/users");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HEADER, false);

// // Execute
// $users = json_decode(curl_exec($ch));

// // Close curl session
// curl_close($ch);


// foreach ($users as $user) {
//     $statement = $database->prepare(
//         "INSERT INTO user (id, name, description, images, category_id, created_by, created_at) VALUES (:id, :name, :description, :images, :category_id, :created_by, :created_at)"
//     );
//     $statement->execute([
//         'id' => $user->id,
//         'name' => $user->title,
//         'description' => $user->description,
//         'images' => json_encode($user->images),
//         'created_at' => date('Y-m-d H:i:s'),
//         'created_by' => 4,
//         'category_id' => (int) $user->category->id
//     ]);
// }

$products = json_decode(file_get_contents("./products.json"), true);


foreach ($products as $product) {
    $statement = $database->prepare('INSERT INTO articles 
    (id, name, image, description, price, category_id, created_at, created_by) 
    VALUES(:id,:name, :image, :description, :price, :category_id, :created_at, :created_by)');

    $statement->execute([
        'id' => $product['id'],
        'name' => $product['name'],
        'image' => $product['image'],
        'description' => '',
        'price' => $product['price'],
        'category_id' =>  $product['category_id'],
        'created_at' =>  $product['created_at'],
        'created_by' =>  $product['created_by']
    ]);
}
