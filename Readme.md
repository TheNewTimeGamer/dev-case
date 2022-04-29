# Dev-case:

## Setup
Download XAMP from [here](https://www.apachefriends.org/index.html).
Install it.

Download [this](https://github.com/TheNewTimeGamer/dev-case) repository.
Put all files into ...\xampp\htdocs...

Open XAMP control panel.
Start the apache server.

Navigate to localhost in your browser.

## Home
Whenever your site has a nav-bar it needs a home page.
It contains [lights-out](https://github.com/TheNewTimeGamer/lights-out), a game I created.

## Case one
Case one is a simple page simulating the requirements of the first assignment.

This parameters are set to that of [Rimac Nevera](https://en.wikipedia.org/wiki/Rimac_Nevera).
With additional parameters supplied by the assignment, such as the car being purple.

Due to the car's exceptional acceleration, to achieve 80km/h over 500m; the driver does not depress the gas pedal fully.

Additionally all calculations should be taken with a grain of salt. Some formulas have been implemented ad-hoc.

As a further note, the way this data is displayed is ugly, including direct function calls and <br> tags. This is simply for practical reasons.

## Case Two
Case Two has some better markup.

Initially the 'Token' field will be empty as the user hasn't logged in yet.

To log in use the credentials:
...
Username: eve.holt@reqres.in
Password: cityslicka
...

These credentials are predetermined [here](https://reqres.in/).

The api class also supports registration but is as far as the api is concidered identical to logging in.