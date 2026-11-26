<?php

// Поля, які працівник може редагувати у кожному розділі.
return [
    "movies" => [
        "table" => "Movie",
        "pk" => "Movie_ID",
        "title" => "Films",
        "fields" => [
            "Title" => "text",
            "Director" => "text",
            "Language" => "text",
            "Year" => "number",
            "Duration" => "time",
            "Description" => "textarea",
            "TrailerLink" => "url",
            "Genre_ID" => "genre",
            "Version_ID" => "version"
        ]
    ],
    "screenings" => [
        "table" => "Screening",
        "pk" => "Screening_ID",
        "title" => "Screenings",
        "fields" => [
            "Movie_ID" => "movie",
            "CinemaHall_ID" => "hall",
            "ShowDate" => "date",
            "ShowTime" => "time"
        ]
    ],
    "news" => [
        "table" => "News",
        "pk" => "News_ID",
        "title" => "Journal",
        "fields" => ["Title" => "text", "Content" => "textarea", "DatePosted" => "date"]
    ],
    "coupons" => [
        "table" => "Coupon",
        "pk" => "Coupon_ID",
        "title" => "Offers",
        "fields" => ["CouponCode" => "text", "DiscountAmount" => "number", "ExpireDate" => "date"]
    ],
    "landing" => [
        "table" => "LandingMovies",
        "pk" => "LandingMovie_ID",
        "title" => "Spotlight films",
        "fields" => ["Movie_ID" => "movie", "DisplayOrder" => "number"]
    ],
    "company" => [
        "table" => "Company",
        "pk" => "Company_ID",
        "title" => "Cinema details",
        "fields" => [
            "Name" => "text",
            "Description" => "textarea",
            "OpeningHours" => "textarea",
            "Email" => "email",
            "Location" => "text"
        ]
    ]
];
