DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Users;

CREATE TABLE Events(id INTEGER AUTO_INCREMENT,
                    name TEXT,
                    location TEXT,
                    startDate INT,
                    endDate INT,
                    description TEXT,
                    postcode TEXT,
                    PRIMARY KEY (id)
                    );

CREATE TABLE Users(id INTEGER AUTO_INCREMENT,
                  name TEXT,
                  hashpass TEXT,
                  postcode TEXT,
                  PRIMARY KEY (id)
                  );


