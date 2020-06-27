# Cotli Talent Picker
This will help you pick talents for the game Crusaders of the Lost Idols. It currently only looks at the very basic DPS talents. It will never suggest any talent that doesn't directly say it increases DPS.

To run it locally you just need to do the following
1. Make sure you have docker installed
2. Clone this repo
3. From the repository run the following commands
    1. docker build -t cotli-talents .
    2. docker run -p 8080:8080 -v .:/var/www/html cotli-talents
4. Open up a browser and navigate to http://localhost:8080/cotli_talents.php
5. Fill in the information and it will suggest talents to you.

## Known Issues/Missing Features

1. No storing of information, everything is just "saved" in POST data.
2. Will only suggest talents that directly impact DPS
    1. Does not handle synergy
    2. Does not handle Fast Learners
    3. Does not handle anything regarding CLK
    4. Does not handle anything to give more idols
    5. Does not handle Maxed Power in terms of possible gains from creating a new max level
3. UI is pretty terrible
