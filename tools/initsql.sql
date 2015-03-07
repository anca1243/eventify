DROP TABLE IF EXISTS Events;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS UserEvents;

CREATE TABLE Events(id INTEGER AUTO_INCREMENT,
                    name TEXT,
                    location TEXT,
                    startDate INT,
                    endDate INT,
                    description TEXT,
                    postcode TEXT,
                    createdBy TEXT ,
                    PRIMARY KEY (id)
                    );

CREATE TABLE UserEvents(userID TEXT, eventID INT);
