DROP TABLE IF EXISTS photo;
DROP TABLE IF EXISTS toy;
DROP TABLE IF EXISTS member;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS request;
DROP TABLE IF EXISTS status;

CREATE TABLE status (
  id         INTEGER(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name       VARCHAR(50)             NOT NULL,
  created_at TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE message (
  id         INTEGER(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  from_user  INTEGER(11) NOT NULL,
  to_user    INTEGER(11) NOT NULL,
  content    TEXT NOT NULL,
  status_id	 INTEGER(11) NOT NULL,
  created_at TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE category (
  id         INTEGER(11) PRIMARY KEY  NOT NULL AUTO_INCREMENT,
  name       VARCHAR(255)             NOT NULL,
  created_at TIMESTAMP                         DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                         DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE member (
  id         INTEGER(11) PRIMARY KEY  NOT NULL AUTO_INCREMENT,
  username   VARCHAR(32)              NOT NULL,
  email      VARCHAR(255)             NOT NULL,
  password   CHAR(32)                 NOT NULL,
  score      DECIMAL(4, 1)            NOT NULL DEFAULT '100.0',
  user_type  CHAR(1)                  NOT NULL,
  msg_id     INTEGER(11),
  created_at TIMESTAMP                         DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                         DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (msg_id) REFERENCES message (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE toy (
  id               INTEGER(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  toy              VARCHAR(255)            NOT NULL,
  description      TEXT,
  expect_to_change TEXT                    NOT NULL,
  click_rate       INTEGER(11)             NOT NULL DEFAULT '0',
  member_id        INTEGER(11)             NOT NULL,
  category_id      INTEGER(11)             NOT NULL,
  status_id        INTEGER(11)             NOT NULL,
  created_at       TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (member_id) REFERENCES member (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (category_id) REFERENCES category (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  FOREIGN KEY (status_id) REFERENCES status (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE photo (
  id         INTEGER(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  url        TEXT                    NOT NULL,
  toy_id     INTEGER(11)             NOT NULL,
  created_at TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP                        DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (toy_id) REFERENCES toy (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


INSERT INTO status (name) VALUES ('Accepts Exchange');
INSERT INTO status (name) VALUES ('Waiting For Reply');
INSERT INTO status (name) VALUES ('Exchange Successful');
INSERT INTO status (name) VALUES ('Cancel');

INSERT INTO category (name) VALUES ('Board Game');
INSERT INTO category (name) VALUES ('Model');
INSERT INTO category (name) VALUES ('Figure');
INSERT INTO category (name) VALUES ('Doll');
INSERT INTO category (name) VALUES ('Other');

INSERT INTO member (username, email, password, user_type) VALUES ('admin', 'admin@admin.com', md5('admin'), 0);


