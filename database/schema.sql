-- DB script. Структура The Cinema для нової порожньої бази.
-- Існуючі дані зберігаються в окремому резервному SQL-експорті.
CREATE DATABASE IF NOT EXISTS thecinema_v2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE thecinema_v2;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- Облікові записи працівників.
CREATE TABLE `Admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Admin_ID`),
  UNIQUE KEY `unique_admin_email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Спроби входу та надсилання форм для обмеження частих запитів.
CREATE TABLE `AuthAttempts` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) NOT NULL,
  `Action` varchar(30) NOT NULL,
  `AttemptedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  KEY `auth_window` (`IP`,`Action`,`AttemptedAt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Замовлення відвідувача та його загальна сума.
CREATE TABLE `Booking` (
  `Booking_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Movie_ID` int(11) DEFAULT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `GuestUser_ID` int(11) DEFAULT NULL,
  `BookingDate` date DEFAULT NULL,
  `NumberOfTickets` int(11) DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL,
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `Payment_ID` int(11) DEFAULT NULL,
  `Invoice_ID` int(11) DEFAULT NULL,
  `Coupon_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Booking_ID`),
  KEY `Movie_ID` (`Movie_ID`),
  KEY `User_ID` (`User_ID`),
  KEY `GuestUser_ID` (`GuestUser_ID`),
  KEY `Payment_ID` (`Payment_ID`),
  KEY `Invoice_ID` (`Invoice_ID`),
  KEY `Coupon_ID` (`Coupon_ID`),
  CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`Movie_ID`) REFERENCES `Movie` (`Movie_ID`),
  CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`User_ID`) REFERENCES `User` (`User_ID`),
  CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`GuestUser_ID`) REFERENCES `GuestUser` (`GuestUser_ID`),
  CONSTRAINT `booking_ibfk_4` FOREIGN KEY (`Payment_ID`) REFERENCES `Payment` (`Payment_ID`),
  CONSTRAINT `booking_ibfk_5` FOREIGN KEY (`Invoice_ID`) REFERENCES `Invoice` (`Invoice_ID`),
  CONSTRAINT `booking_ibfk_6` FOREIGN KEY (`Coupon_ID`) REFERENCES `Coupon` (`Coupon_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Зали кінотеатру.
CREATE TABLE `CinemaHall` (
  `CinemaHall_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `TotalSeats` int(11) DEFAULT NULL,
  PRIMARY KEY (`CinemaHall_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Назва, опис, адреса й години роботи кінотеатру.
CREATE TABLE `Company` (
  `Company_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `OpeningHours` varchar(100) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Company_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Повідомлення відвідувачів та відповіді працівника.
CREATE TABLE `ContactMessages` (
  `Message_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Subject` varchar(255) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `Submitted_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Reply` text DEFAULT NULL,
  PRIMARY KEY (`Message_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Промокоди та термін їхньої дії.
CREATE TABLE `Coupon` (
  `Coupon_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CouponCode` varchar(50) DEFAULT NULL,
  `DiscountAmount` decimal(10,2) DEFAULT NULL,
  `ExpireDate` date DEFAULT NULL,
  PRIMARY KEY (`Coupon_ID`),
  UNIQUE KEY `unique_coupon_code` (`CouponCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Жанри фільмів.
CREATE TABLE `Genre` (
  `Genre_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`Genre_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Контакти відвідувачів, які замовляють без реєстрації.
CREATE TABLE `GuestUser` (
  `GuestUser_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Firstname` varchar(100) DEFAULT NULL,
  `Lastname` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `TelephoneNumber` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`GuestUser_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Рахунки, пов’язані із замовленнями.
CREATE TABLE `Invoice` (
  `Invoice_ID` int(11) NOT NULL AUTO_INCREMENT,
  `InvoiceDate` date DEFAULT NULL,
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `InvoiceStatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Invoice_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Фільми у головному блоці та порядок їхнього показу.
CREATE TABLE `LandingMovies` (
  `LandingMovie_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Movie_ID` int(11) NOT NULL,
  `DisplayOrder` int(11) NOT NULL,
  PRIMARY KEY (`LandingMovie_ID`),
  KEY `Movie_ID` (`Movie_ID`),
  CONSTRAINT `landingmovies_ibfk_1` FOREIGN KEY (`Movie_ID`) REFERENCES `Movie` (`Movie_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Сумісність із попередньою структурою обліку входів.
CREATE TABLE `Login_Attempts` (
  `Login_Attempts_Id` int(11) NOT NULL AUTO_INCREMENT,
  `Ip_Address` varchar(45) NOT NULL,
  `Attempt_Time` timestamp NOT NULL DEFAULT current_timestamp(),
  `Success` tinyint(1) NOT NULL DEFAULT 0,
  `Blocked_Until` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Login_Attempts_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Локальна копія підготовлених листів.
CREATE TABLE `MailOutbox` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Recipient` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Body` text NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Постери та зображення фільмів.
CREATE TABLE `Media` (
  `Media_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FileName` varchar(255) DEFAULT NULL,
  `UploadAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsFeatured` tinyint(1) DEFAULT 0,
  `Format` enum('jpg','png','webp') NOT NULL,
  `Movie_ID` int(11) DEFAULT NULL,
  `News_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Media_ID`),
  KEY `Movie_ID` (`Movie_ID`),
  KEY `News_ID` (`News_ID`),
  CONSTRAINT `media_ibfk_1` FOREIGN KEY (`Movie_ID`) REFERENCES `Movie` (`Movie_ID`) ON DELETE CASCADE,
  CONSTRAINT `media_ibfk_2` FOREIGN KEY (`News_ID`) REFERENCES `News` (`News_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Фільми та їхні характеристики.
CREATE TABLE `Movie` (
  `Movie_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `Director` varchar(100) DEFAULT NULL,
  `Language` varchar(50) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `Duration` time DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `TrailerLink` varchar(255) DEFAULT NULL,
  `AgeLimit` int(11) DEFAULT NULL,
  `Genre_ID` int(11) DEFAULT NULL,
  `Version_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Movie_ID`),
  KEY `Genre_ID` (`Genre_ID`),
  KEY `Version_ID` (`Version_ID`),
  CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`Genre_ID`) REFERENCES `Genre` (`Genre_ID`),
  CONSTRAINT `movie_ibfk_2` FOREIGN KEY (`Version_ID`) REFERENCES `Version` (`Version_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Новини, які працівник публікує на сайті.
CREATE TABLE `News` (
  `News_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `DatePosted` date DEFAULT NULL,
  PRIMARY KEY (`News_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Тимчасові токени для зміни пароля.
CREATE TABLE `PasswordResets` (
  `Reset_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL,
  `Expiry` datetime NOT NULL,
  PRIMARY KEY (`Reset_ID`),
  KEY `Email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дані оплати, передбачені схемою проєкту.
CREATE TABLE `Payment` (
  `Payment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `AmountPaid` decimal(10,2) DEFAULT NULL,
  `PaymentMethod` varchar(50) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Payment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дата, час і зал кожного сеансу.
CREATE TABLE `Screening` (
  `Screening_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ShowDate` date DEFAULT NULL,
  `ShowTime` time DEFAULT NULL,
  `CinemaHall_ID` int(11) DEFAULT NULL,
  `Movie_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Screening_ID`),
  KEY `CinemaHall_ID` (`CinemaHall_ID`),
  KEY `Movie_ID` (`Movie_ID`),
  CONSTRAINT `screening_ibfk_1` FOREIGN KEY (`CinemaHall_ID`) REFERENCES `CinemaHall` (`CinemaHall_ID`) ON DELETE CASCADE,
  CONSTRAINT `screening_ibfk_2` FOREIGN KEY (`Movie_ID`) REFERENCES `Movie` (`Movie_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Місця та ряди кожного залу.
CREATE TABLE `Seat` (
  `Seat_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SeatNumber` int(11) DEFAULT NULL,
  `Row` int(11) DEFAULT NULL,
  `CinemaHall_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Seat_ID`),
  KEY `CinemaHall_ID` (`CinemaHall_ID`),
  CONSTRAINT `seat_ibfk_1` FOREIGN KEY (`CinemaHall_ID`) REFERENCES `CinemaHall` (`CinemaHall_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Квитки. Одне місце на один сеанс може бути продано лише один раз.
CREATE TABLE `Ticket` (
  `Ticket_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Screening_ID` int(11) DEFAULT NULL,
  `Seat_ID` int(11) DEFAULT NULL,
  `Price_ID` int(11) DEFAULT NULL,
  `Booking_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Ticket_ID`),
  UNIQUE KEY `unique_screening_seat` (`Screening_ID`,`Seat_ID`),
  KEY `Screening_ID` (`Screening_ID`),
  KEY `Booking_ID` (`Booking_ID`),
  KEY `Seat_ID` (`Seat_ID`),
  KEY `Price_ID` (`Price_ID`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`Screening_ID`) REFERENCES `Screening` (`Screening_ID`),
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`Booking_ID`) REFERENCES `Booking` (`Booking_ID`),
  CONSTRAINT `ticket_ibfk_3` FOREIGN KEY (`Seat_ID`) REFERENCES `Seat` (`Seat_ID`),
  CONSTRAINT `ticket_ibfk_4` FOREIGN KEY (`Price_ID`) REFERENCES `TicketPrice` (`Price_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ціни квитків і періоди їхньої дії.
CREATE TABLE `TicketPrice` (
  `Price_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(50) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `ValidFrom` date DEFAULT NULL,
  `ValidTo` date DEFAULT NULL,
  PRIMARY KEY (`Price_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Облікові записи відвідувачів.
CREATE TABLE `User` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `TelephoneNumber` varchar(25) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`User_ID`),
  UNIQUE KEY `unique_user_email` (`Email`),
  UNIQUE KEY `unique_user_name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Формат показу та доплата.
CREATE TABLE `Version` (
  `Version_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Format` varchar(50) DEFAULT NULL,
  `AdditionalFee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Version_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

SET FOREIGN_KEY_CHECKS=1;

-- View: Бронювання разом із назвою фільму та ім’ям відвідувача.
CREATE SQL SECURITY INVOKER VIEW `detailedbookings` AS
select `b`.`Booking_ID` AS `Booking_ID`,`m`.`Title` AS `MovieTitle`,coalesce(`u`.`Name`,concat(`g`.`Firstname`,' ',`g`.`Lastname`))
AS `CustomerName`,`b`.`BookingDate` AS `BookingDate`,`b`.`NumberOfTickets` AS `NumberOfTickets`,`b`.`TotalPrice` AS `TotalPrice`,`b`.`PaymentStatus`
AS `PaymentStatus` from (((`Booking` `b` left join `Movie` `m` on(`b`.`Movie_ID` = `m`.`Movie_ID`)) left join `User` `u`
on(`b`.`User_ID` = `u`.`User_ID`)) left join `GuestUser` `g` on(`b`.`GuestUser_ID` = `g`.`GuestUser_ID`));

-- View: Фільми разом із жанром, форматом та зображеннями.
CREATE SQL SECURITY INVOKER VIEW `moviedetails` AS
select `m`.`Movie_ID` AS `Movie_ID`,`m`.`Title` AS `Title`,`m`.`Director` AS `Director`,`m`.`Language` AS `Language`,`m`.`Year`
AS `Year`,`m`.`Duration` AS `Duration`,`m`.`Rating` AS `Rating`,`m`.`Description` AS `Description`,`m`.`TrailerLink` AS `TrailerLink`,`m`.`AgeLimit`
AS `AgeLimit`,max(case when `Media`.`IsFeatured` = 1 then `Media`.`FileName` end) AS `ImageFileName`,group_concat(case when
`Media`.`IsFeatured` = 0 then `Media`.`FileName` end separator ',') AS `GalleryImages`,`g`.`Genre_ID` AS `Genre_ID`,`g`.`Name`
AS `GenreName`,`v`.`Version_ID` AS `Version_ID`,`v`.`Format` AS `VersionFormat` from (((`Movie` `m` left join `Media` on(`m`.`Movie_ID`
= `Media`.`Movie_ID`)) left join `Genre` `g` on(`m`.`Genre_ID` = `g`.`Genre_ID`)) left join `Version` `v` on(`m`.`Version_ID`
= `v`.`Version_ID`)) group by `m`.`Movie_ID`;

-- Trigger: перевіряємо накладання сеансів і враховуємо 15 хвилин перерви.
DELIMITER ;;
CREATE TRIGGER `check_screening_overlap` BEFORE INSERT ON `Screening` FOR EACH ROW BEGIN
    DECLARE movie_duration_seconds INT;
    DECLARE new_end_time DATETIME;
    SELECT TIME_TO_SEC(Duration) INTO movie_duration_seconds
    FROM Movie WHERE Movie_ID = NEW.Movie_ID;
    SET new_end_time = DATE_ADD(TIMESTAMP(NEW.ShowDate, NEW.ShowTime), INTERVAL (movie_duration_seconds + 900) SECOND);
    IF EXISTS (
        SELECT 1 FROM Screening s
        JOIN Movie m ON s.Movie_ID = m.Movie_ID
        WHERE s.CinemaHall_ID = NEW.CinemaHall_ID
          AND TIMESTAMP(NEW.ShowDate, NEW.ShowTime) < DATE_ADD(TIMESTAMP(s.ShowDate, s.ShowTime), INTERVAL (TIME_TO_SEC(m.Duration) + 900) SECOND)
          AND new_end_time > TIMESTAMP(s.ShowDate, s.ShowTime)
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Overlap detected: Screening conflicts with another screening.';
    END IF;
END;;
DELIMITER ;

-- Trigger: перевіряємо накладання сеансів і враховуємо 15 хвилин перерви.
DELIMITER ;;
CREATE TRIGGER `check_screening_overlap_update` BEFORE UPDATE ON `Screening` FOR EACH ROW BEGIN
    DECLARE movie_duration_seconds INT;
    DECLARE new_end_time DATETIME;
    SELECT TIME_TO_SEC(Duration) INTO movie_duration_seconds
    FROM Movie WHERE Movie_ID = NEW.Movie_ID;
    SET new_end_time = DATE_ADD(TIMESTAMP(NEW.ShowDate, NEW.ShowTime), INTERVAL (movie_duration_seconds + 900) SECOND);
    IF EXISTS (
        SELECT 1 FROM Screening s
        JOIN Movie m ON s.Movie_ID = m.Movie_ID
        WHERE s.CinemaHall_ID = NEW.CinemaHall_ID
          AND s.Screening_ID <> OLD.Screening_ID
          AND TIMESTAMP(NEW.ShowDate, NEW.ShowTime) < DATE_ADD(TIMESTAMP(s.ShowDate, s.ShowTime), INTERVAL (TIME_TO_SEC(m.Duration) + 900) SECOND)
          AND new_end_time > TIMESTAMP(s.ShowDate, s.ShowTime)
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Overlap detected: Screening conflicts with another screening.';
    END IF;
END;;
DELIMITER ;
