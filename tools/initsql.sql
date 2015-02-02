DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Users;

CREATE TABLE Events(id INTEGER AUTO_INCREMENT,
                    name VARCHAR(50),
                    location VARCHAR(200),
                    date VARCHAR(50),
                    description VARCHAR(240),
                    postcode VARCHAR(10),
                    PRIMARY KEY (id)
                    );

CREATE TABLE Users(id INTEGER AUTO_INCREMENT,
                  name VARCHAR(50),
                  hashpass VARCHAR(100),
                  postcode VARCHAR(10),
                  PRIMARY KEY (id)
                  );


