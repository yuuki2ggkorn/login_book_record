-- create
CREATE TABLE gs_bm_table (
    id int(12) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    insert_dt datetime NOT NULL,
    image_url text NOT NULL,
    book_title varchar(64) NOT NULL,
    book_author varchar(64) NOT NULL,
    book_publisher varchar(64) NOT NULL,
    naiyou text DEFAULT NULL,
    indate datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- create
CREATE TABLE gs_bm_table (
    id int(12) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    insert_dt text NOT NULL,
    image_url text NOT NULL,
    book_title varchar(64) NOT NULL,
    book_author varchar(64) NOT NULL,
    book_publisher varchar(64) NOT NULL,
    naiyou text DEFAULT NULL,
    indate datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- php04
CREATE TABLE gs_an_table (
id         int(12)  NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
name       varchar(64) NOT NULL ,
lid        varchar(128) NOT NULL ,
lpw        varchar(64) NOT NULL ,
kanri_flg  int(1) NOT NULL ,  -- 0=管理者 1=スーパー管理者
life_flg   int(1) NOT NULL   -- 0=退社 1=入社
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;