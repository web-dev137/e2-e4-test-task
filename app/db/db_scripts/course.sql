create table course
(
    id         int auto_increment
        primary key,
    char_code  varchar(10)  not null,
    vunit_rate double                               not null,
    created_at timestamp default CURRENT_TIMESTAMP  not null
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;