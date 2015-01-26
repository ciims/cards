# CiiMS Card Repository

This repository contains a collection of all the approved dashboard cards that can be installed through the [CiiMS Dashboard](https://github.com/charlesportwoodii/ciims-modules-dashboard), and serves as the primary distribution center for all dashboard cards.

## How this repository works

This repository contains an ```index.json``` file, which contains a master list of all the approved dashboard cards for CiiMS. In the dashboard, when you look to install a new card, this file is referenced as the master approved list of cards that can be installed.

When new cards are added, and automated process kicks off on https://cards.ciims.io to download all cards listed in the ```index.json``` file and push it to a persistent CDN for long term storage. This storage is never purged, so if you want to make a change to your card you'll need to publish a new git tag/version of your card, and submit a new pull request to update the version. Once your updated is approved your card will be pushed to all CiiMS instances as an available update.

## Contributing

To contribute to this repository, first build  a dashboard card (see https://github.com/charlesportwoodii/ciims-basic-card as an example of what a card looks and can do). Once you are happy with your card, tag/version it using [semantic versioning](http://semver.org/). Once versioned, submitted a pull request to this repository. Your pull request should modify ```index.json``` with your card information, and should have the following information at minimum.

```
"BasicCard": {
	"repository": "https://github.com/charlesportwoodii/ciims-basic-card",
	"version": "1.0.0"
}
```

The ```repository``` field can be any publicly available github repository, and the ```version``` should correspond to a published git tag.

## Run your own card repository
Want to run your own card repository for CiiMS instances you manage? CiiMS now lets you specify a custom card repository endpoint and run a private set of cards.

1. Fork this repository
2. Clone the forked repository to your server
3. Edit index.json as you see fit
4. Run ```php parser.php``` to initially populate the database
5. Add ```parser.sh``` to an hourly crontab on your system
6. Make the cloned folder accessible via HTTP
7. In CiiMS#/protected/config/main.php, add the following key value pair to the ```params``` section.
```
'cards' => 'http://your-endpoint.tld/path/to/repo'
```
8. Clear CiiMS' cache

CiiMS will now use your custom endpoint for cards

## DISCLAIMER
By submitting your card to this repository, you agree to allow CiiMS to deal with 
your card without restriction, including without limitations to the right to use, 
copy, modify, distribute, and make available to the extent necessary to publish your card.

All cards submitted to this repository are subject to scrutiny and analysis before acceptance.
CiiMS reserves the right to decline or reject a pull request for any reason, including
but not limited to: content that is unlawful, threatening, abusive, harassing, defamatory, 
libelous, deceptive, fraudulent, invasive of another's privacy, tortious, offensive, profane, 
contains or depicts pornography that is unlawful, or is otherwise inappropriate as determined 
by us in our sole discretion; that you know is false, misleading, untruthful or inaccurate;
constitutes unauthorized or unsolicited advertising; impersonates any person or entity, 
including any of our employees or representatives; includes anyone’s identification documents 
or sensitive financial information; or which attempts comprimise the security of any installed
instanced or user(s).

Inclusion of your card in this repository is in no way an endorsement of the submitted card, the
card authors, or associated names and brands.

## License
The MIT License (MIT)

Copyright (c) 2014-2015 Charles R. Portwood II

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
