DROP TABLE IF EXISTS sm17_MainCategories;

CREATE TABLE sm17_MainCategories (
CategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
Category varchar(50) NULL,
Description text NULL
);

DROP TABLE IF EXISTS sm17_SubCategories;

CREATE TABLE sm17_SubCategories (
SubCategoryID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
CategoryID INT UNSIGNED NOT NULL,
SubCategory varchar(50) NULL,
Description text NULL
);

INSERT INTO sm17_MainCategories (Category, Description) VALUES ("Sports", "YAY SPORTS!");
INSERT INTO sm17_MainCategories (Category, Description) VALUES ("Technology", "YAY TECHNOLOGY!");
INSERT INTO sm17_MainCategories (Category, Description) VALUES ("Entertainment", "YAY POP CULTURE!");

INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (1, "Sounders", "Lots of running. Few Goals. Soccer!");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (1, "Mariners", "The Thinking Man's Sport. There's a moose.");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (1, "Seahawks", "Dirty wins... but that's the way we like it!");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (2, "Apple", "Pretty but also pretty expensive.");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (2, "VR Technology", "It's real, kind of.");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (2, "Facebook", "More like Suckerberg, amirite?");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (3, "Movies", "The Silver Screen");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (3, "Restaurants", "Everybody's gotta eat.");
INSERT INTO sm17_SubCategories (CategoryID, SubCategory, Description) VALUES (3, "Music", "Karaoke Fodder");