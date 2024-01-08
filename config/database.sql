create table categories
(
    id    int auto_increment
        primary key,
    name  varchar(50)  not null,
    image text         null,
    slug  varchar(255) not null
);

create table users
(
    id         int auto_increment
        primary key,
    first_name varchar(30)                        not null,
    last_name  varchar(30)                        not null,
    birthday   date                               null,
    email      varchar(50)                        not null,
    password   varchar(255)                       not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime                           null,
    deleted_at datetime                           null,
    constraint users_pk2
        unique (email)
);

create table articles
(
    id              int auto_increment
        primary key,
    name            varchar(255)                       not null,
    image           text                               null,
    category_id     int                                not null,
    created_by      int                                not null,
    description     text                               null,
    price           decimal(10, 2) unsigned            not null,
    note            float    default 2.5               not null,
    number_of_notes int      default 0                 not null,
    created_at      datetime default CURRENT_TIMESTAMP not null,
    updated_at      datetime                           null,
    deleted_at      datetime                           null,
    constraint articles_categories_id_fk
        foreign key (category_id) references categories (id),
    constraint articles_users_id_fk
        foreign key (created_by) references users (id)
);

create table buy
(
    user_id    int                                not null,
    article_id int                                not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    primary key (user_id, article_id),
    constraint buy_articles_id_fk
        foreign key (article_id) references articles (id),
    constraint buy_users_id_fk
        foreign key (user_id) references users (id)
);

create table ratings
(
    id         int auto_increment
        primary key,
    rate       int                                not null,
    article_id int                                not null,
    user_id    int                                not null,
    created_at datetime default CURRENT_TIMESTAMP not null,
    updated_at datetime                           null,
    constraint ratings_articles_id_fk
        foreign key (article_id) references articles (id),
    constraint ratings_users_id_fk
        foreign key (user_id) references users (id)
);

