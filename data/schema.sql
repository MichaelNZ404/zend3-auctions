CREATE TABLE item (
    id SERIAL PRIMARY KEY, 
    item_name varchar(100) NOT NULL,
    item_image varchar(500) NOT NULL
);
INSERT INTO item (item_name, item_image) VALUES ('Tabula Rasa', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/8/8c/Tabula_Rasa_inventory_icon.png');
INSERT INTO item (item_name, item_image) VALUES ('Iron Hat', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/6/6a/Iron_Hat_inventory_icon.png');
INSERT INTO item (item_name, item_image) VALUES ('Quicksilver Flask', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/8/84/Quicksilver_Flask_inventory_icon.png');
INSERT INTO item (item_name, item_image) VALUES ('Orb of Alchemy', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/9/9f/Orb_of_Alchemy_inventory_icon.png');
INSERT INTO item (item_name, item_image) VALUES ('Mirror of Kalandra', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/9/9c/Mirror_of_Kalandra_inventory_icon.png');

CREATE TABLE currency (
    id SERIAL PRIMARY KEY, 
    currency_name varchar(100) NOT NULL,
    currency_image varchar(500) NOT NULL
);
INSERT INTO currency (currency_name, currency_image) VALUES ('Chaos Orb', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/9/9c/Chaos_Orb_inventory_icon.png');
INSERT INTO currency (currency_name, currency_image) VALUES ('Chromatic Orb', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/f/fd/Chromatic_Orb_inventory_icon.png');
INSERT INTO currency (currency_name, currency_image) VALUES ('Orb of Fusing', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/6/62/Orb_of_Fusing_inventory_icon.png');
INSERT INTO currency (currency_name, currency_image) VALUES ('Orb of Alchemy', 'https://d1u5p3l4wpay3k.cloudfront.net/pathofexile_gamepedia/9/9f/Orb_of_Alchemy_inventory_icon.png');

CREATE TABLE person (
    id SERIAL PRIMARY KEY, 
    person_name varchar(100) NOT NULL
);
INSERT INTO person (person_name) VALUES ('YOU');
INSERT INTO person (person_name) VALUES ('Bob Ross');
INSERT INTO person (person_name) VALUES ('Zizarian');
INSERT INTO person (person_name) VALUES ('Michael Coleman');
INSERT INTO person (person_name) VALUES ('Grinding Gear Games');

CREATE TABLE auction (
    id SERIAL PRIMARY KEY, 
    auction_item_id integer REFERENCES item NOT NULL, 
    auction_owner_id integer REFERENCES person NOT NULL, 
    currency_id integer REFERENCES currency NOT NULL,
    expires_at timestamp NOT NULL DEFAULT (now() + INTERVAL '2 days')
);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id) VALUES (1, 4, 1);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id) VALUES (1, 4, 2);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id) VALUES (2, 2, 1);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id) VALUES (2, 2, 1);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id) VALUES (3, 3, 1);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id) VALUES (4, 3, 4);
INSERT INTO auction (auction_item_id, auction_owner_id, currency_id, expires_at) VALUES (4, 2, 4, '01-01-2011');

CREATE TABLE bid (
    id SERIAL PRIMARY KEY, 
    auction_id integer REFERENCES auction NOT NULL, 
    person_id integer REFERENCES person NOT NULL,  
    currency_amount integer NOT NULL
);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (1, 2, 5);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (2, 4, 500);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (3, 3, 20);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (4, 3, 25);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (5, 3, 30);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (6, 3, 40);
INSERT INTO bid (auction_id, person_id, currency_amount) VALUES (1, 3, 3);