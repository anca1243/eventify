DROP TABLE UserEmails;
DROP TABLE UserNames;
DROP TABLE UserPasswords;
CREATE TABLE UserNames(ID INTEGER AUTO_INCREMENT,
                         Name VARCHAR(50),
                         PRIMARY KEY (ID)
                         );
CREATE TABLE UserEmails(ID INTEGER AUTO_INCREMENT,
                          Email VarChar(50),
                          PRIMARY KEY (ID)
                         );
CREATE TABLE UserPasswords(ID INTEGER AUTO_INCREMENT,
                             HashPass VarChar(100),
                             PRIMARY KEY (ID)
                            ); 
                        
CREATE TABLE UserGroups(ID INTEGER AUTO_INCREMENT,
                             Groups VarChar(2),
                             PRIMARY KEY (ID)
                            );



