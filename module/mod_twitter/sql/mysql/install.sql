CREATE TABLE IF NOT EXISTS `#__twitter`(
  id int(10) NOT NULL AUTO_INCREMENT,
  uuid varchar(255) NOT NULL,
  type varchar(100) NOT NULL,
  text text NOT NULL,
  image text NOT NULL,
  link text NOT NULL,
  favorite int(10) NOT NULL,
  created_at timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  updated_at timestamp NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  PRIMARY KEY(id)
);