-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: malyshenko_db
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Торты','2021-02-10 19:34:41','2021-02-11 13:33:50'),(2,'Капкейки','2021-02-10 19:34:41','2021-02-11 13:33:50'),(3,'Печенье','2021-02-10 19:34:41','2021-02-11 13:33:50'),(4,'Хлеб','2021-02-10 19:34:41','2021-02-11 13:33:50');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userID_idx` (`user_id`),
  KEY `ProductID_idx` (`product_id`),
  CONSTRAINT `ProductID` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Мне очень понравился этот вкусный тортик! Буду заказывать еще!',1,1,NULL,'2021-02-17 16:26:18'),(2,'Обожаю чизкейки!!! а этот просто сНОГСшибательный....',1,4,NULL,'2021-02-17 19:24:10'),(3,'Шоколадная бомба, тающая во рту! Мой самый любимый тортик! Безусловно самый нежный, самый тающий!',1,5,NULL,'2021-02-17 19:25:37'),(4,'Как-то заказала это вкусный набор капкейков! Понравились почти все, ну как говориться на любителя))',1,12,NULL,'2021-02-17 19:26:44'),(7,'Брали с мужем этот вкусный тортик, что бы побаловать себя и были приятно удивлены! такой нежный и ореховый! нужно употреблять только с чаем - очень кофейный...',1,2,NULL,'2021-02-17 20:46:03'),(12,'Привет)',1,6,NULL,'2021-02-19 09:05:23');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `address` varchar(45) NOT NULL,
  `price_total` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `contact_phone` varchar(45) NOT NULL,
  `comments` text,
  `user_name` varchar(45) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_1_idx` (`user_id`),
  CONSTRAINT `fk_orders_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (40,1,'Kharkiv, Naukova str, 20',1190,'2021-02-16 20:31:49',NULL,'+380990945359','ghklden','Alexis','alexis@test.com'),(41,1,'sdvvfd',780,'2021-02-17 20:02:02',NULL,'0990945359','ымЫ','Alexis','alexis@test.com'),(42,1,'Kharkiv, Naukova str, 20',160,'2021-02-18 09:03:34',NULL,'09909909909','хочууу как можно скорее','Alexis','alexis@test.com'),(43,1,'Kharkiv, Naukova str, 20',0,'2021-02-18 09:41:00',NULL,'09909909909','хочууу как можно скорее','Alexis','alexis@test.com'),(44,1,'Kharkiv, Naukova str, 20',0,'2021-02-18 09:49:33',NULL,'09909909909','хочууу как можно скорее','Alexis','alexis@test.com'),(45,1,'Kharkiv, Naukova str, 20',0,'2021-02-18 09:50:30',NULL,'09909909909','хочууу как можно скорее','Alexis','alexis@test.com'),(46,1,'Kiev, Volomoyskay str., 45a',1370,'2021-02-18 10:18:18',NULL,'86594339201','','Alexis','alexis@test.com'),(47,1,'Kiev, Volomoyskay str., 45a',224,'2021-02-18 10:23:46',NULL,'454028580234','','Alexis','alexis@test.com'),(48,1,'Kiev, Volomoyskay str., 45a',390,'2021-02-18 10:25:34',NULL,'93885--24553','hello, could you please call me before send','Alexis','alexis@test.com'),(49,1,'Kiev, Volomoyskay str., 45a',0,'2021-02-18 10:30:25',NULL,'93885--24553','hello, could you please call me before send','Alexis','alexis@test.com'),(50,1,'Kiev, Volomoyskay str., 45a',1080,'2021-02-18 10:35:00',NULL,'998421-40553','hello, could you please call me before send','Alexis','alexis@test.com'),(51,1,'Kiev, Volomoyskay str., 45a',1760,'2021-02-18 10:37:36',NULL,'464667684567','хочууу как можно скорее','Alexis','alexis@test.com'),(52,1,'Kharkiv, Naukova str, 20',180,'2021-02-18 10:44:18',NULL,'435577262474','хочууу как можно скорее','Alexis','alexis@test.com'),(53,1,'Kharkiv, Naukova str, 20',600,'2021-02-19 08:50:17',NULL,'99430375833345','hello, could you please call me before send','Alexis','alexis@test.com'),(54,1,'Kharkiv, Naukova str, 20',600,'2021-02-19 08:57:09',NULL,'99430375833345','hello, could you please call me before send','Alexis','alexis@test.com');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `title` varchar(45) NOT NULL,
  `price` int NOT NULL,
  `description` text NOT NULL,
  `image` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `categoryID_idx` (`category_id`),
  CONSTRAINT `categoryID` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Торт лимонный',490,'Лимонный торт - это мягкие, пропитанные лимонным сиропом, бисквиты на лимонной цедре,\nкоторые чередуются с лимонным сливочным муссом😍 Для любителей кислинкии легкости - то, что нужно','/images/category-page/1.jpg','2021-02-10 19:41:00',NULL),(2,1,'Торт кофейный с кешью',600,'Нежнейшие классические бисквиты, пропитанные заварным кофе☕.\nВолшебный кофейный крем (вкуснее, которого вы ни где и ни когда не пробовали!)и отборные орехи кешью🔥 Стоит попробовать!','/images/category-page/3.jpg','2021-02-10 19:49:55',NULL),(3,1,'Торт Сникерс',550,'Наш вариант торта Сникерс. Это настоящий взрыв вкусовых рецепторов🤩\nШоколадный влажный корж. Два вида прослоек: шоколадный крем с кусочками безе,арахисовый ганаш на белом бельгийском\nшоколаде с домашней соленой карамелью.','/images/category-page/4.jpg','2021-02-10 19:49:55',NULL),(4,1,'Чизкейк New York (классический лимонный)',425,'Это настоящий чизкейк, выпекаемый много часов. Такой, какой он должен быть!\nСтрого из крем сыра: никакого творога или рикотты. Кто пробовал его однажды - наш заложник навсегда😂😝','/images/category-page/4.jpg','2021-02-10 19:49:55',NULL),(5,1,'Торт Настоящий шоколад',390,'Это торт для сильных печенью. Его шоколадность зашкаливает. Мокрые шоко-коржи и крем на основе 70% бельгийского шоколада.\nИ да - это классическое сочетание не оставит равнодушным ни одного шокоголика 🍫🍫+орехи 50 грн / кг изделия+фрукты, сухофрукты 0 грн','/images/category-page/6.jpg','2021-02-10 19:49:55',NULL),(6,1,'Торт карамельный',300,'Для людей-бурундуков😂, которые любят орехи везде, всегда и много😝🎉\nОреховые бисквиты, пропитанные миндальным сиропом, карамельный крем, соленая карамель и 4 вида орехов крупного помола: кешью, фундук, миндаль и грецкий. Обожаем этот торт сами😻','/images/category-page/2.jpg','2021-02-10 19:49:55',NULL),(7,2,'Капкейк шоколадно-вишневый',300,'🧁Шоколадно-вишневые капкейки, для любителей винши!🍒 Для любителей кислинкии легкости - то, что нужно! Сверху украшено мастикой 🧁','/images/category-page/27.jpg','2021-02-10 19:55:16',NULL),(8,2,'Ванильный капкей',200,'Нежнейший классический бисквитик, пропитанные винилью. 🧁🔥 Стоит попробовать!','/images/category-page/28.jpg','2021-02-10 19:55:16',NULL),(9,2,'Капкейк класический шоколадный',390,'Наш вариант шоколадного капкейка - это настоящий взрыв вкусовых рецепторов🤩 Шоколадный влажный бисквитик. 🍫 Сверху масляный крем на основе белого бельгийского шоколада. Любовь с первого взгляда','/images/category-page/9.jpg','2021-02-10 19:55:16',NULL),(10,2,'Ореховый капкейк',425,'Для людей-бурундуков,🐿 которые любят орехи везде, всегда и много.🌰🥜 Такой, какой он должен быть! Крем сделан из сыра: маскарпоне или рикотты. Кто пробовал его однажды - наш заложник навсегда😂😝','/images/category-page/10.jpg','2021-02-10 19:55:16',NULL),(11,2,'Капкейк красный бархат',390,'Это капкейк - самая настоящяя изысконость.👑 И да - этот рецепт не оставит равнодушным ни одного ценителя классики. 🎼🎼🎼🎼🎼🎨🎷','/images/category-page/11.jpg','2021-02-10 19:55:16',NULL),(12,2,'Набор капкейков',500,' Этот набор для тех людей, кто любит всё и сразу! Дерзайте!🥇🏆','/images/category-page/12.jpg','2021-02-10 19:55:16',NULL),(13,3,'Печенье с кофейно-шоколадной крошкой',120,'Для любителей кофе и шоколада!☕️🍫 Печенье изготовлено только из натуральных продуктов под присмотром наших профессионалов','/images/category-page/13.jpg','2021-02-10 20:01:12',NULL),(14,3,'Молочное-медовое печенье в виде зверюшек',90,' Такое печенье оценят мамы, которые беспокоятся о своих деточках.🍼🥛🍯 Печенье изготовлено только из натуральных продуктов под присмотром наших профессионалов','/images/category-page/14.jpg','2021-02-10 20:01:12',NULL),(15,3,'Овсяное печенье',100,'Классическое овсяное печенье, для всех кто любит овсянку! Печенье изготовлено только из натуральных продуктов под присмотром наших профессионалов','/images/category-page/15.jpg','2021-02-10 20:01:12',NULL),(16,3,'Печенье с клюквой в присыпке',125,'Клюква и песоное тесто, отличное сочетаное под утрений чайок!☕️🍵 Печенье изготовлено только из натуральных продуктов под присмотром наших профессионалов','/images/category-page/16.jpg','2021-02-10 20:01:12',NULL),(17,3,'Кокосовое печенье',160,'Любителям экзотики пойдет по вкусу этот вид печенья! 🥥🍪Печенье изготовлено только из натуральных продуктов под присмотром наших профессионалов','/images/category-page/17.jpg','2021-02-10 20:01:12',NULL),(18,3,'Имбирное печенье',100,'Имбирь - это здоровье! Так, можно кушать много имбирного печенька!🍪 Печенье изготовлено только из натуральных продуктов под присмотром наших профессионалов','/images/category-page/18.jpg','2021-02-10 20:01:12',NULL),(19,4,'Пшеничный хлеб',32,'Самый свежый и хрустящий! Напонимает детство 🍞🧈','/images/category-page/19.jpg','2021-02-10 20:05:11',NULL),(20,4,'Хлеб бородинский',40,'Мягкий и элегантный. Сделан из муки грубого помола','/images/category-page/20.jpg','2021-02-10 20:05:11',NULL),(21,4,'Черный хлеб',35,'Для ценителей по истине черного хлеба! Сделан на основе трех сортов муки первого сорта','/images/category-page/21.jpg','2021-02-10 20:05:11',NULL),(22,4,'Кунжутный хлеб',35,'Вкусный кунжутный хлеб дополнит ваш обед невероятными вкусами!','/images/category-page/22.jpg','2021-02-10 20:05:11',NULL),(23,4,'Французский багет',40,'Белый и нежный французский багет для утонченных личностей 🥖','/images/category-page/23.jpg','2021-02-10 20:05:11',NULL),(24,4,'Французский багет с оливками',45,'Французский багет со вкусом оливок. 🥖 Выбор номер 1 среди наших клиентов','/images/category-page/24.jpg','2021-02-10 20:05:11',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products_order`
--

DROP TABLE IF EXISTS `products_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `order_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_products_order_1_idx` (`product_id`),
  KEY `fk_products_order_2_idx` (`order_id`),
  CONSTRAINT `fk_products_order_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_products_order_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products_order`
--

LOCK TABLES `products_order` WRITE;
/*!40000 ALTER TABLE `products_order` DISABLE KEYS */;
INSERT INTO `products_order` VALUES (1,2,40,1,'2021-02-16 20:31:49',NULL),(2,12,40,1,'2021-02-16 20:31:49',NULL),(3,14,40,1,'2021-02-16 20:31:49',NULL),(4,5,41,2,'2021-02-17 20:02:02',NULL),(5,17,42,1,'2021-02-18 09:03:34',NULL),(6,8,46,1,'2021-02-18 10:18:18',NULL),(7,11,46,3,'2021-02-18 10:18:18',NULL),(8,23,47,2,'2021-02-18 10:23:46',NULL),(9,20,47,2,'2021-02-18 10:23:46',NULL),(10,19,47,2,'2021-02-18 10:23:46',NULL),(11,5,48,1,'2021-02-18 10:25:34',NULL),(12,5,50,2,'2021-02-18 10:35:00',NULL),(13,15,50,1,'2021-02-18 10:35:00',NULL),(14,8,50,1,'2021-02-18 10:35:00',NULL),(15,1,51,1,'2021-02-18 10:37:36',NULL),(16,5,51,3,'2021-02-18 10:37:36',NULL),(17,15,51,1,'2021-02-18 10:37:36',NULL),(18,14,52,2,'2021-02-18 10:44:18',NULL),(19,2,53,1,'2021-02-19 08:50:17',NULL),(20,2,54,1,'2021-02-19 08:57:09',NULL);
/*!40000 ALTER TABLE `products_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` enum('Kiev','Kharkiv','Odessa','Lviv') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Alexis','alexis@test.com','$2y$10$DkEqJCDrzSJR7b3BQzY8HOZ7Hwcd.idMOjgv.qi8XzIIfHXM5bKJi','Kharkiv','2021-02-10 20:10:34','2021-02-23 13:33:32'),(2,'admin','admin@test.com','admin','Kiev','2021-02-10 20:10:34',NULL),(3,'Motor Ride','some@email.io','$2y$10$DkEqJCDrzSJR7b3BQzY8HOZ7Hwcd.idMOjgv.qi8XzIIfHXM5bKJi','Lviv','2021-02-10 20:11:24','2021-02-23 13:33:32'),(4,'maybe works','test@test.ru','$2y$10$DkEqJCDrzSJR7b3BQzY8HOZ7Hwcd.idMOjgv.qi8XzIIfHXM5bKJi','Kharkiv','2021-02-12 11:57:06','2021-02-23 13:33:32'),(5,'Данил','dan@test.com','$2y$10$DkEqJCDrzSJR7b3BQzY8HOZ7Hwcd.idMOjgv.qi8XzIIfHXM5bKJi','Odessa','2021-02-18 11:24:54','2021-02-23 13:33:32'),(6,'Priscela','priscela@email.io','$2y$10$A8t.3cU1dh/sYaet.1BG3OuciE9T18KtbmxdbKSg/dqxCi476.7aO','Lviv','2021-02-23 13:34:48',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wish_list`
--

DROP TABLE IF EXISTS `wish_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wish_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_ID_idx` (`product_id`),
  KEY `user_ID_idx` (`user_id`),
  CONSTRAINT `product_ID` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_ID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wish_list`
--

LOCK TABLES `wish_list` WRITE;
/*!40000 ALTER TABLE `wish_list` DISABLE KEYS */;
INSERT INTO `wish_list` VALUES (4,5,1,'2021-02-17 14:35:24',NULL),(5,15,1,'2021-02-17 14:41:50',NULL),(8,8,1,'2021-02-17 16:57:10',NULL),(9,1,1,'2021-02-17 20:00:13',NULL),(10,14,1,'2021-02-17 20:51:42',NULL);
/*!40000 ALTER TABLE `wish_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-25 18:29:47
