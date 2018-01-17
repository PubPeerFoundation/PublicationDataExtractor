# Publication Data Extractor
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/PubPeerFoundation/PublicationDataExtractor.svg?branch=master)](https://travis-ci.org/PubPeerFoundation/PublicationDataExtractor)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PubPeerFoundation/PublicationDataExtractor/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PubPeerFoundation/PublicationDataExtractor/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/PubPeerFoundation/PublicationDataExtractor/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PubPeerFoundation/PublicationDataExtractor/?branch=master)
[![StyleCI](https://styleci.io/repos/117548394/shield?branch=master)](https://styleci.io/repos/117548394)

The main idea behind this package is to allow the extraction of Research Publication data from any external API into a simple common structure.

The package can identify multiple types of identifiers such as DOI, PubMed Id, arXiv ID, ...

The package can then read from different external APIs such as doi.org, crossref api, ncbi, arXiv.org, ...

The resulting structure looks like this:

```
{
    "authors":[
        {
            "first_name":"Richard S.",
            "last_name":"Smith",
            "orcid":null,
            "affiliation":[{
                "name":"Department of Biology, University of Maryland, College Park, Maryland"
            }]
        },
        {
            "first_name":"Ricardo C.",
            "last_name":"Araneda",
            "orcid":null,
            "affiliation":[{
                "name":"Department of Biology, University of Maryland, College Park, Maryland"
            }]
        }
    ],
    "identifiers":[
        {
            "value":"10.1152\/jn.00446.2010",
            "type":"doi"
        },
        {
            "value":"0022-3077",
            "type":"issn"
        },
        {
            "value":"1522-1598",
            "type":"issn"
        }
    ],
    "journal":{
        "title":"Journal of Neurophysiology",
        "issn":["0022-3077","1522-1598"],
        "publisher":"American Physiological Society"
    },
    "publication":{
        "title":"Cholinergic Modulation of Neuronal Excitability in the Accessory Olfactory Bulb",
        "abstract":null,
        "url":"http:\/\/dx.doi.org\/10.1152\/jn.00446.2010",
        "published_at":"2010-12"
    },
    "tags": [
        {
            "name":"Physiology"
        },
        {
            "name":"General Neuroscience"
        }
    ],
    "types":[
        {
            "name":"journal-article"
        }
    ]
}
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please use the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support us

You wish to donate to the PubPeer Foundation? Reach out and support us on [Patreon](https://www.patreon.com/pubpeer).

## Credits

- [Xavier Roussel](https://github.com/XavRsl)

## About the PubPeer Foundation

The PubPeer Foundation is a California-registered public-benefit corporation with 501(c)(3) nonprofit status in the United States. The overarching goal of the Foundation is to improve the quality of scientific research by enabling innovative approaches for community interaction. The bylaws of the Foundation establish pubpeer.com as a service run for the benefit of its readers and commenters, who create its content. Our current focus is maintaining and developing the PubPeer online platform for post-publication peer review.

## Contact us
For anything related to the PubPeer Foundation or PubPeer web site, please contact us through **contact at pubpeer dot com**.