DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Users;

CREATE TABLE Events(id INTEGER AUTO_INCREMENT,
                    name TEXT,
                    location TEXT,
                    date TEXT,
                    description TEXT,
                    postcode TEXT,
                    createdBy TEXT ,
                    PRIMARY KEY (id)
                    );

CREATE TABLE Users(id INTEGER AUTO_INCREMENT,
                  name VARCHAR(50),
                  hashpass VARCHAR(100),
                  postcode VARCHAR(10),
                  PRIMARY KEY (id)
                  );


