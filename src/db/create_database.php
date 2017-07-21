<?php
require_once dirname(__FILE__) . "/../connection/connect.php";

$shopArraysSQL = array(
    "create table Users(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255) NOT NULL,
                        surname varchar(255) NOT NULL,
                        email varchar(255) NOT NULL UNIQUE,
                        password varchar(60) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Products(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255) NOT NULL,
                        price decimal(5,2)  NOT NULL,
                        descritpion varchar(255) NOT NULL,
                        inStock int  NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,    
    "create table ProductPhotos(
                        id int AUTO_INCREMENT NOT NULL,
                        product_id int NOT NULL,
                        path varchar(255) NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(product_id) REFERENCES Products(id) ON DELETE CASCADE)
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table Admins(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(255) NOT NULL,
                        email varchar(255) NOT NULL UNIQUE,
                        password varchar(60) NOT NULL,
                        PRIMARY KEY(id))
     ENGINE=InnoDB, CHARACTER SET=utf8"
,   
    "create table Orders(
                        id int AUTO_INCREMENT NOT NULL,
                        user_id int NOT NULL,
                        status varchar(32) NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(user_id) REFERENCES Users(id) ON DELETE CASCADE)
     ENGINE=InnoDB, CHARACTER SET=utf8"
,    
    "create table Products_Orders(
                        id int AUTO_INCREMENT NOT NULL,
                        product_id int NOT NULL,
                        order_id int NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY(order_id) REFERENCES Orders(id) ON DELETE CASCADE,
                        FOREIGN KEY(product_id) REFERENCES Products(id) ON DELETE CASCADE)
     ENGINE=InnoDB, CHARACTER SET=utf8"
,
    "create table ProductGroups(
                        id int AUTO_INCREMENT NOT NULL,
                        name varchar(48) NOT NULL,
                        PRIMARY KEY(id),
     ENGINE=InnoDB, CHARACTER SET=utf8"
    
    );

foreach($shopArraysSQL as $query){
    $result = $conn->query($query);
    if ($result === TRUE) {
        echo "Tabela zostala stworzona poprawnie<br>";
    } else {
        echo "Blad podczas tworzenia tabeli: " . $conn->error."<br>";
    }
}


$conn->close();
$conn = null;