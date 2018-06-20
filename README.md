# Publication Data Extractor
[![Latest Stable Version](https://poser.pugx.org/pubpeer-foundation/publication-data-extractor/v/stable)](https://packagist.org/packages/pubpeer-foundation/publication-data-extractor)
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
[
    {
        "authors":[
            {"first_name":"J D","last_name":"WATSON","affiliation":""},
            {"first_name":"F H","last_name":"CRICK","affiliation":""}
        ],
        "identifiers":[
            {"value":"13054692","type":"pubmed"},
            {"value":"0028-0836","type":"issn"}
        ],
        "journal":{
            "title":"Nature",
            "issn":[
                0028-0836
            ]
        },
        "publication":{
            "title":"Molecular structure of nucleic acids; a structure for deoxyribose nucleic acid.",
            "url":"http:\/\/www.ncbi.nlm.nih.gov\/pubmed\/13054692",
            "published_at":"1953-04-25",
            "abstract":""
        }
    }
]
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
