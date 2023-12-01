create table announcement
(
    id      integer not null
        constraint announcement_pk
            primary key autoincrement,
    title text not null,
    description text not null
);
